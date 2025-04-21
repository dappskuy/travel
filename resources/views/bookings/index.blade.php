@extends('layouts.app')

@section('title', 'Daftar Pemesanan')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Daftar Pemesanan Saya</h4>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($bookings->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pemesanan</h5>
                            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-search me-2"></i>
                                Cari Paket Wisata
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Paket</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Orang</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $booking->package->image_url) }}" 
                                                         class="rounded me-3" 
                                                         alt="{{ $booking->package->package_name }}"
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $booking->package->package_name }}</h6>
                                                        <small class="text-muted">
                                                            {{ $booking->package->category->category_name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                            <td>{{ $booking->number_of_people }} orang</td>
                                            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @switch($booking->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-success">Dikonfirmasi</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-info">Selesai</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('bookings.show', $booking->booking_id) }}" 
                                                       class="btn btn-sm btn-primary rounded-pill px-3">
                                                        <i class="fas fa-eye me-1"></i>
                                                        Detail
                                                    </a>
                                                    @if($booking->status === 'pending')
                                                        <form action="{{ route('bookings.cancel', $booking->booking_id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                                                <i class="fas fa-times me-1"></i>
                                                                Batal
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 