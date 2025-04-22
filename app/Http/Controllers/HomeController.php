<?php

namespace App\Http\Controllers;

use App\Models\PackageReview;
use App\Models\TravelPackage;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get active packages with their categories
        $packages = TravelPackage::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // Get recent reviews with user and package info
        $reviews = PackageReview::with(['user', 'package'])
            ->latest()
            ->take(3)
            ->get();

        // Get popular packages (most booked)
        $popularPackages = TravelPackage::withCount('bookings')
            ->where('is_active', true)
            ->orderBy('bookings_count', 'desc')
            ->take(4)
            ->get();

        // Get featured packages (you can add a 'is_featured' column to travel_packages table)
        $featuredPackages = TravelPackage::with('category')
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Get statistics
        $stats = [
            'members' => User::where('role', 'customer')->count(),
            'places' => TravelPackage::where('is_active', true)->count(),
            'hotels' => Booking::where('status', 'completed')->count(),
            'partners' => User::where('role', 'partner')->count(),
            'total_packages' => TravelPackage::where('is_active', true)->count(),
            'total_reviews' => PackageReview::count(),
            'total_bookings' => Booking::where('status', 'completed')->count(),
            'total_customers' => User::where('role', 'customer')->count()
        ];

        return view('pages.home', compact(
            'packages',
            'reviews',
            'popularPackages',
            'featuredPackages',
            'stats'
        ));
    }
}
