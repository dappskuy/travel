<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TravelPackage;
use App\Models\BookingStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['package', 'package.category'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create($packageId)
    {
        $package = TravelPackage::findOrFail($packageId);
        return view('bookings.create', compact('package'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:travel_packages,package_id',
            'booking_date' => 'required|date|after:today',
            'number_of_people' => 'required|integer|min:1',
            'payment_proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $package = TravelPackage::findOrFail($request->package_id);

        if ($package->available_seats < $request->number_of_people) {
            return back()->with('error', 'Not enough available seats for this package.');
        }

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->package_id = $request->package_id;
        $booking->booking_date = $request->booking_date;
        $booking->number_of_people = $request->number_of_people;
        $booking->total_price = $package->price * $request->number_of_people;
        $booking->status = 'pending';
        $booking->payment_status = 'unpaid';

        if ($request->hasFile('payment_proof_image')) {
            $path = $request->file('payment_proof_image')->store('payment_proofs', 'public');
            $booking->payment_proof_image = $path;
        }

        $booking->save();

        // Update available seats
        $package->available_seats -= $request->number_of_people;
        $package->save();

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully. Please wait for admin confirmation.');
    }

    public function show($id)
    {
        $booking = Booking::with(['package', 'package.category', 'statusHistory'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Check if booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan pemesanan ini.');
        }

        // Check if booking can be cancelled
        if ($booking->status === 'cancelled') {
            return redirect()->route('bookings.index')
                ->with('error', 'Pemesanan ini sudah dibatalkan sebelumnya.');
        }

        if ($booking->status === 'completed') {
            return redirect()->route('bookings.index')
                ->with('error', 'Pemesanan yang sudah selesai tidak dapat dibatalkan.');
        }

        // Update booking status
        $booking->status = 'cancelled';
        $booking->save();

        // Create status history
        BookingStatusHistory::create([
            'booking_id' => $booking->booking_id,
            'status' => 'cancelled',
            'changed_by' => auth()->id(),
            'notes' => 'Pemesanan dibatalkan oleh user'
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }
} 