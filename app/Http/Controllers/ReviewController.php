<?php

namespace App\Http\Controllers;

use App\Models\PackageReview;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,booking_id',
            'package_id' => 'required|exists:travel_packages,package_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        // Check if user has already reviewed this booking
        $existingReview = PackageReview::where('booking_id', $request->booking_id)->first();
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk pemesanan ini.');
        }

        // Check if booking belongs to user and is completed
        $booking = Booking::where('user_id', Auth::id())
            ->where('booking_id', $request->booking_id)
            ->where('status', 'completed')
            ->firstOrFail();

        PackageReview::create([
            'booking_id' => $request->booking_id,
            'user_id' => Auth::id(),
            'package_id' => $request->package_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Review berhasil ditambahkan.');
    }

    public function adminReply(Request $request, $reviewId)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000'
        ]);

        $review = PackageReview::findOrFail($reviewId);
        $review->admin_reply = $request->admin_reply;
        $review->save();

        return back()->with('success', 'Balasan berhasil ditambahkan.');
    }

    public function update(Request $request, PackageReview $review)
    {
        // Check if the user is the author of the review
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk mengedit review ini.'
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diperbarui.'
        ]);
    }

    public function destroy(PackageReview $review)
    {
        // Check if the user is the author of the review
        if ($review->user_id !== auth()->id()) {
            return back()->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
} 