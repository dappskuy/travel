<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'package', 'statusHistory']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'package', 'statusHistory.changedBy'])
                         ->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:255'
        ]);

        // Update booking status
        $booking->status = $request->status;
        $booking->save();

        // Create status history
        BookingStatusHistory::create([
            'booking_id' => $booking->booking_id,
            'status' => $request->status,
            'changed_by' => Auth::id(),
            'notes' => $request->notes
        ]);

        // Update available seats if confirmed
        if ($request->status === 'confirmed') {
            $booking->package->available_seats -= $booking->number_of_people;
            $booking->package->save();
        }

        return redirect()->route('admin.bookings.index')
                         ->with('success', 'Status pemesanan berhasil diperbarui');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid',
            'notes' => 'nullable|string|max:255'
        ]);

        // Update payment status
        $booking->payment_status = $request->payment_status;
        
        // If marking as paid, set payment date
        if ($request->payment_status === 'paid') {
            $booking->payment_date = now();
        }
        
        $booking->save();

        // Create status history
        BookingStatusHistory::create([
            'booking_id' => $booking->booking_id,
            'status' => $booking->status, // Keep the same booking status
            'changed_by' => Auth::id(),
            'notes' => 'Status pembayaran diubah menjadi ' . ($request->payment_status === 'paid' ? 'Lunas' : 'Belum Dibayar') . '. ' . ($request->notes ?? '')
        ]);

        return redirect()->route('admin.bookings.show', $booking->booking_id)
                         ->with('success', 'Status pembayaran berhasil diperbarui');
    }

    public function updateNotes(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $booking->admin_notes = $request->admin_notes;
        $booking->save();

        return redirect()->route('admin.bookings.show', $booking->booking_id)
                         ->with('success', 'Catatan admin berhasil diperbarui');
    }
} 