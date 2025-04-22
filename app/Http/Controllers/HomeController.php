<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\PackageReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $packages = TravelPackage::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $reviews = PackageReview::with(['user', 'package'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('pages.home', compact('packages', 'reviews'));
    }
}
