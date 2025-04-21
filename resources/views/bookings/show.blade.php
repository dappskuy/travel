@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Detail Pemesanan</h4>
                        <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'info')) }} rounded-pill px-3 py-2">
                            {{ $booking->status === 'pending' ? 'Menunggu Konfirmasi' : ($booking->status === 'confirmed' ? 'Dikonfirmasi' : ($booking->status === 'cancelled' ? 'Dibatalkan' : 'Selesai')) }}
                        </span>
                    </div>

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
                            <h6 class="text-muted mb-2">Status Pemesanan</h6>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'info')) }} rounded-pill px-3 me-2">
                                    {{ $booking->status === 'pending' ? 'Menunggu Konfirmasi' : ($booking->status === 'confirmed' ? 'Dikonfirmasi' : ($booking->status === 'cancelled' ? 'Dibatalkan' : 'Selesai')) }}
                                </span>
                                @if($booking->status === 'pending')
                                    <form action="{{ route('bookings.cancel', $booking->booking_id) }}" method="POST" class="ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
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
                            <p class="mb-0">
                                <span class="badge bg-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }} rounded-pill px-3">
                                    {{ $booking->payment_status === 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                                </span>
                            </p>
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

                    @if($booking->admin_notes)
                        <div class="alert alert-info">
                            <h6 class="mb-2">Catatan Admin</h6>
                            <p class="mb-0">{{ $booking->admin_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Riwayat Status</h5>
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

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Fasilitas</h5>
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