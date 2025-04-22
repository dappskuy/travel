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

            <!-- Reviews Section -->
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Review Pengguna</h5>
                </div>
                <div class="card-body">
                    @if($package->reviews->count() > 0)
                        <div class="reviews-list">
                            @foreach($package->reviews as $review)
                                <div class="review-item mb-4 pb-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1 font-weight-bold">{{ $review->user->full_name }}</h6>
                                            <div class="rating-stars mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $i <= $review->rating ? 'active' : '' }}">★</span>
                                                @endfor
                                            </div>
                                            <p class="text-muted mb-2 small">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}
                                            </p>
                                        </div>
                                        @if(auth()->check() && auth()->id() === $review->user_id)
                                            <div class="review-actions">
                                                <button type="button" class="btn btn-sm btn-outline-primary me-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editReviewModal{{ $review->review_id }}">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                                <form action="{{ route('reviews.destroy', ['review' => $review->review_id]) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="review-content">
                                        <p class="mb-2">{{ $review->comment }}</p>
                                        @if($review->admin_reply)
                                            <div class="admin-reply border-start border-primary border-3 bg-light p-3 rounded mt-3" style="margin-left: 20px;">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="badge bg-primary me-2">
                                                        <i class="fas fa-headset me-1"></i>Admin
                                                    </span>
                                                    <span class="text-muted small">
                                                        <i class="far fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($review->updated_at)->format('d M Y H:i') }}
                                                    </span>
                                                </div>
                                                <p class="mb-0 fst-italic">{{ $review->admin_reply }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif

                                <!-- Edit Review Modal -->
                                <div class="modal fade" id="editReviewModal{{ $review->review_id }}" tabindex="-1" aria-labelledby="editReviewModalLabel{{ $review->review_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editReviewModalLabel{{ $review->review_id }}">Edit Review</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('reviews.update', ['review' => $review->review_id]) }}" method="POST" class="edit-review-form" data-review-id="{{ $review->review_id }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label fw-bold">Rating</label>
                                                        <div class="rating-wrapper">
                                                            <div class="rating">
                                                                @for($i = 5; $i >= 1; $i--)
                                                                    <input type="radio" name="rating" id="editStar{{ $i }}_{{ $review->review_id }}" 
                                                                           value="{{ $i }}" {{ $review->rating == $i ? 'checked' : '' }} required>
                                                                    <label for="editStar{{ $i }}_{{ $review->review_id }}" title="{{ $i }} stars">★</label>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        @error('rating')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editComment{{ $review->review_id }}" class="form-label fw-bold">Komentar</label>
                                                        <textarea class="form-control @error('comment') is-invalid @enderror" 
                                                                  id="editComment{{ $review->review_id }}" 
                                                                  name="comment" 
                                                                  rows="4" 
                                                                  required>{{ old('comment', $review->comment) }}</textarea>
                                                        @error('comment')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="far fa-comments text-muted mb-3" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">Belum ada review untuk paket ini.</p>
                        </div>
                    @endif

                    @if(auth()->check() && 
                        auth()->user()->bookings()->where('package_id', $package->package_id)->where('status', 'completed')->exists() &&
                        !auth()->user()->reviews()->where('package_id', $package->package_id)->exists())
                        <hr class="my-4">
                        <h6 class="mb-3">Beri Review</h6>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->package_id }}">
                            <input type="hidden" name="booking_id" value="{{ auth()->user()->bookings()->where('package_id', $package->package_id)->where('status', 'completed')->first()->booking_id }}">
                            
                            <div class="form-group mb-3">
                                <label class="d-block">Rating</label>
                                <div class="rating-wrapper">
                                    <div class="rating">
                                        <input type="radio" name="rating" id="star5" value="5" required>
                                        <label for="star5" title="5 stars">★</label>
                                        
                                        <input type="radio" name="rating" id="star4" value="4">
                                        <label for="star4" title="4 stars">★</label>
                                        
                                        <input type="radio" name="rating" id="star3" value="3">
                                        <label for="star3" title="3 stars">★</label>
                                        
                                        <input type="radio" name="rating" id="star2" value="2">
                                        <label for="star2" title="2 stars">★</label>
                                        
                                        <input type="radio" name="rating" id="star1" value="1">
                                        <label for="star1" title="1 star">★</label>
                                    </div>
                                </div>
                                @error('rating')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="comment">Komentar</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                @error('comment')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Review
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Price calculation
    const pricePerPerson = parseInt({{ $package->price }});
    const numberOfPeopleInput = document.getElementById('number_of_people');
    const totalPriceElement = document.getElementById('total_price');

    function formatRupiah(angka) {
        const number_string = angka.toString();
        const sisa = number_string.length % 3;
        let rupiah = number_string.substr(0, sisa);
        const ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp ' + rupiah;
    }

    function updateTotalPrice() {
        const numberOfPeople = parseInt(numberOfPeopleInput.value) || 0;
        const totalPrice = pricePerPerson * numberOfPeople;
        totalPriceElement.textContent = formatRupiah(totalPrice);
    }

    numberOfPeopleInput.addEventListener('input', updateTotalPrice);
    updateTotalPrice();

    // Rating system
    const ratingInputs = document.querySelectorAll('.rating input');
    const ratingLabels = document.querySelectorAll('.rating label');

    ratingLabels.forEach(label => {
        label.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.checked = true;
            
            ratingLabels.forEach(l => {
                if (l.htmlFor <= input.id) {
                    l.style.color = '#ffc107';
                } else {
                    l.style.color = '#ddd';
                }
            });
        });
    });

    // Initialize Bootstrap modals
    const editModals = document.querySelectorAll('.modal');
    editModals.forEach(modal => {
        new bootstrap.Modal(modal);
    });

    // Handle edit button clicks
    const editButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            const modal = document.querySelector(targetId);
            if (modal) {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }
        });
    });

    // Handle edit form submissions
    const editForms = document.querySelectorAll('.edit-review-form');
    editForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const reviewId = this.getAttribute('data-review-id');
            
            // Get CSRF token from the form
            const csrfToken = document.querySelector('input[name="_token"]').value;
            
            fetch(`/reviews/${reviewId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Review berhasil diperbarui');
                    // Close the modal
                    const modalElement = this.closest('.modal');
                    // if (modalElement) {
                    //     const modal = bootstrap.Modal.CreateInstance(modalElement);
                    //     modal.hide();
                    // }
                    // Refresh the page to show updated review
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'Terjadi kesalahan saat memperbarui review';
                
                if (error.errors) {
                    // Handle validation errors
                    errorMessage = Object.values(error.errors).flat().join('\n');
                } else if (error.message) {
                    errorMessage = error.message;
                }
                
                alert(errorMessage);
            });
        });
    });
});
</script>

<style>
.rating-wrapper {
    display: inline-block;
}

.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating input {
    display: none;
}

.rating label {
    color: #ddd;
    font-size: 30px;
    padding: 0 2px;
    cursor: pointer;
    transition: color 0.2s;
}

.rating label:hover,
.rating label:hover ~ label,
.rating input:checked ~ label {
    color: #ffc107;
}

.rating input:checked + label {
    color: #ffc107;
}

.rating-stars {
    display: inline-block;
    font-size: 18px;
    line-height: 1;
}

.rating-stars .star {
    color: #ddd;
    margin-right: 2px;
    transition: color 0.2s;
}

.rating-stars .star.active {
    color: #ffc107;
}

.review-item {
    position: relative;
}

.review-content {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
}

.admin-reply {
    background-color: #f8f9fa;
    border-left: 3px solid #4e73df;
    padding: 1rem;
    border-radius: 0.5rem;
}

.review-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
}

.review-actions {
    display: flex;
    gap: 0.5rem;
}

.review-actions .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
}

.review-actions .btn i {
    font-size: 0.875rem;
}

.modal-content {
    border-radius: 0.5rem;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
}

.modal-body {
    padding: 1rem;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding: 1rem;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.modal-header.bg-primary {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

.rating-wrapper {
    display: inline-block;
    margin-top: 0.5rem;
}

.rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 0.5rem;
}

.rating input {
    display: none;
}

.rating label {
    color: #ddd;
    font-size: 2rem;
    cursor: pointer;
    transition: color 0.2s;
}

.rating label:hover,
.rating label:hover ~ label,
.rating input:checked ~ label {
    color: #ffc107;
}

.rating input:checked + label {
    color: #ffc107;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.invalid-feedback {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}
</style>
@endsection 