@extends('layouts.app')

@section('title', 'Pesan Paket Wisata')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4">Detail Pemesanan</h4>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $package->image_url) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $package->package_name }}"
                                 style="height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">{{ $package->package_name }}</h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                {{ $package->location }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                {{ $package->duration }} hari
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-users text-primary me-2"></i>
                                Maksimal {{ $package->max_people }} orang
                            </p>
                            <div class="mt-4">
                                <h6 class="text-muted mb-2">Harga per orang</h6>
                                <h4 class="text-primary">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->package_id }}">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="booking_date" class="form-label">Tanggal Keberangkatan</label>
                                <input type="date" 
                                       class="form-control @error('booking_date') is-invalid @enderror" 
                                       id="booking_date" 
                                       name="booking_date" 
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('booking_date') }}" 
                                       required>
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="number_of_people" class="form-label">Jumlah Orang</label>
                                <input type="number" 
                                       class="form-control @error('number_of_people') is-invalid @enderror" 
                                       id="number_of_people" 
                                       name="number_of_people" 
                                       min="1" 
                                       max="{{ $package->max_people }}"
                                       value="{{ old('number_of_people', 1) }}" 
                                       required>
                                @error('number_of_people')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_proof_image" class="form-label">Bukti Pembayaran</label>
                            <input type="file" 
                                   class="form-control @error('payment_proof_image') is-invalid @enderror" 
                                   id="payment_proof_image" 
                                   name="payment_proof_image" 
                                   accept="image/*"
                                   required>
                            <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                            @error('payment_proof_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <h6 class="mb-2">Informasi Pembayaran</h6>
                            <p class="mb-1">Total yang harus dibayar: <strong id="total_price">Rp {{ number_format($package->price, 0, ',', '.') }}</strong></p>
                            <p class="mb-0">Silakan transfer ke rekening berikut:</p>
                            <p class="mb-0">Bank: BCA</p>
                            <p class="mb-0">No. Rekening: 1234567890</p>
                            <p class="mb-0">Atas Nama: Travel Agency</p>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Fasilitas yang Dapatkan</h5>
                    <div class="mb-3">
                        <h6 class="text-primary">Termasuk:</h6>
                        <ul class="list-unstyled">
                            @foreach(explode(',', $package->include_facilities) as $facility)
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
                            @foreach(explode(',', $package->exclude_facilities) as $facility)
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pricePerPerson = {{ $package->price }};
    const numberOfPeopleInput = document.getElementById('number_of_people');
    const totalPriceElement = document.getElementById('total_price');

    function updateTotalPrice() {
        const numberOfPeople = parseInt(numberOfPeopleInput.value) || 0;
        const totalPrice = pricePerPerson * numberOfPeople;
        totalPriceElement.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }

    numberOfPeopleInput.addEventListener('input', updateTotalPrice);
    updateTotalPrice();
});
</script>
@endsection 