<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingManagementController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'package', 'package.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'package', 'package.category', 'statusHistory'])
            ->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string'
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status;
        $booking->status = $request->status;
        $booking->save();

        // Record status change
        $history = new BookingStatusHistory();
        $history->booking_id = $booking->booking_id;
        $history->status = $request->status;
        $history->changed_by = Auth::id();
        $history->notes = $request->notes;
        $history->save();

        // Update payment status if confirmed
        if ($request->status === 'confirmed') {
            $booking->payment_status = 'paid';
            $booking->save();
        }

        // Update available seats if cancelled
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $package = $booking->package;
            $package->available_seats += $booking->number_of_people;
            $package->save();
        }

        return redirect()->route('admin.bookings.show', $id)
            ->with('success', 'Booking status updated successfully.');
    }
} 