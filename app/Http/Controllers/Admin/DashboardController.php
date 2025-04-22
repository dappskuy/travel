<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PackageReview;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalUsers = User::count();
        $totalPackages = TravelPackage::count();
        $totalBookings = Booking::count();
        $totalReviews = PackageReview::count();

        // Get recent bookings
        $recentBookings = Booking::with(['user', 'package'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent reviews
        $recentReviews = PackageReview::with(['user', 'package'])
            ->latest()
            ->take(5)
            ->get();

        // Get booking statistics
        $bookingStats = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count()
        ];

        // Get payment statistics
        $paymentStats = [
            'paid' => Booking::where('payment_status', 'paid')->count(),
            'unpaid' => Booking::where('payment_status', 'unpaid')->count()
        ];

        // Get popular packages
        $popularPackages = TravelPackage::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPackages',
            'totalBookings',
            'totalReviews',
            'recentBookings',
            'recentReviews',
            'bookingStats',
            'paymentStats',
            'popularPackages'
        ));
    }
}
