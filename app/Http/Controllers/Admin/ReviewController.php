<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = PackageReview::with(['user', 'package', 'booking']);
        
        // Apply search if provided - only search by user name
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function($userQuery) use ($search) {
                $userQuery->where('full_name', 'like', "%{$search}%");
            });
        }
        
        $reviews = $query->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000'
        ]);

        $review = PackageReview::findOrFail($id);
        $review->admin_reply = $request->admin_reply;
        $review->save();

        return back()->with('success', 'Balasan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $review = PackageReview::findOrFail($id);
        
        try {
            $review->delete();
            return back()->with('success', 'Review berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus review. Error: ' . $e->getMessage());
        }
    }
} 