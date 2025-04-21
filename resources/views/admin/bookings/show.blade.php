@extends('layouts.admin')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pemesanan #{{ $booking->booking_id }}</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Booking Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pemesanan</h6>
                    <div>
                        <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'info')) }} rounded-pill px-3 py-2">
                            {{ $booking->status === 'pending' ? 'Menunggu Konfirmasi' : ($booking->status === 'confirmed' ? 'Dikonfirmasi' : ($booking->status === 'cancelled' ? 'Dibatalkan' : 'Selesai')) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $booking->package->image_url) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $booking->package->package_name }}"
                                 style="height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">{{ $booking->package->package_name }}</h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                {{ $booking->package->location }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ $booking->package->duration }} hari
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-users text-primary me-2"></i>
                                {{ $booking->number_of_people }} orang
                            </p>
                            <div class="mt-4">
                                <h6 class="text-muted mb-2">Total Pembayaran</h6>
                                <h4 class="text-primary">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Tanggal Keberangkatan</h6>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted mb-2">Status Pembayaran</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }} rounded-pill px-3 me-2">
                                    {{ $booking->payment_status === 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                                </span>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }}" 
                                        data-toggle="modal" 
                                        data-target="#paymentStatusModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($booking->payment_proof_image)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Bukti Pembayaran</h6>
                            <img src="{{ asset('storage/' . $booking->payment_proof_image) }}" 
                                 class="img-fluid rounded" 
                                 alt="Bukti Pembayaran"
                                 style="max-height: 300px;">
                        </div>
                    @endif

                    <div class="mb-3">
                            <h6 class="text-muted mb-2">Catatan Admin</h6>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 flex-grow-1">{{ $booking->admin_notes ?? 'Tidak ada catatan' }}</p>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary" 
                                        data-toggle="modal" 
                                        data-target="#adminNotesModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Customer Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pemesan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Nama:</strong> {{ $booking->user->full_name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong> {{ $booking->user->email }}
                            </p>
                            <p class="mb-2">
                                <strong>Nomor Telepon:</strong> {{ $booking->user->phone_number ?? '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Tanggal Pemesanan:</strong> {{ $booking->created_at->format('d M Y H:i') }}
                            </p>
                            <p class="mb-2">
                                <strong>Terakhir Diperbarui:</strong> {{ $booking->updated_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Status History Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($booking->statusHistory as $history)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $history->status === 'pending' ? 'warning' : ($history->status === 'confirmed' ? 'success' : ($history->status === 'cancelled' ? 'danger' : 'info')) }}"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">
                                        {{ $history->status === 'pending' ? 'Menunggu Konfirmasi' : ($history->status === 'confirmed' ? 'Dikonfirmasi' : ($history->status === 'cancelled' ? 'Dibatalkan' : 'Selesai')) }}
                                    </h6>
                                    <p class="text-muted small mb-1">
                                        Oleh: {{ $history->changedBy->full_name }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y H:i') }}
                                    </p>
                                    @if($history->notes)
                                        <p class="small mt-2 mb-0">{{ $history->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Package Facilities Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fasilitas Paket</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">Termasuk:</h6>
                        <ul class="list-unstyled">
                            @foreach(explode(',', $booking->package->include_facilities) as $facility)
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    {{ trim($facility) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h6 class="text-primary">Tidak Termasuk:</h6>
                        <ul class="list-unstyled">
                            @foreach(explode(',', $booking->package->exclude_facilities) as $facility)
                                <li class="mb-2">
                                    <i class="fas fa-times text-danger me-2"></i>
                                    {{ trim($facility) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Status Modal -->
<div class="modal fade" id="paymentStatusModal" tabindex="-1" role="dialog" aria-labelledby="paymentStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentStatusModalLabel">Update Status Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.bookings.update-payment-status', $booking->booking_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment_status">Status Pembayaran</label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="notes">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Admin Notes Modal -->
<div class="modal fade" id="adminNotesModal" tabindex="-1" role="dialog" aria-labelledby="adminNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminNotesModalLabel">Edit Catatan Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.bookings.update-notes', $booking->booking_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_notes">Catatan Admin</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4">{{ $booking->admin_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 1rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -0.5rem;
    top: 0;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 1rem;
}
</style>
@endsection 