<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'package', 'statusHistory']);

        // Apply status filter if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('full_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('package', function($packageQuery) use ($search) {
                      $packageQuery->where('package_name', 'like', "%{$search}%")
                                  ->orWhere('location', 'like', "%{$search}%");
                  });
            });
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

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Update booking status to completed
        $booking->status = 'completed';
        $booking->save();

        // Add status history
        BookingStatusHistory::create([
            'booking_id' => $booking->booking_id,
            'status' => 'completed',
            'changed_by' => auth()->id(),
            'notes' => 'Pesanan telah selesai'
        ]);

        return back()->with('success', 'Status pesanan berhasil diubah menjadi selesai.');
    }

    public function delete($id)
    {
        $booking = Booking::findOrFail($id);
        
        try {
            // Begin transaction
            DB::beginTransaction();
            
            // If the booking was confirmed, add back the seats to the package
            if ($booking->status === 'confirmed') {
                $booking->package->available_seats += $booking->number_of_people;
                $booking->package->save();
            }
            
            // Delete associated status history
            $booking->statusHistory()->delete();
            
            // Delete associated reviews
            $booking->review()->delete();
            
            // Delete booking
            $booking->delete();
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('admin.bookings.index')
                             ->with('success', 'Pemesanan berhasil dihapus.');
                             
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            return redirect()->route('admin.bookings.index')
                             ->with('error', 'Gagal menghapus pemesanan. Error: ' . $e->getMessage());
        }
    }
} 