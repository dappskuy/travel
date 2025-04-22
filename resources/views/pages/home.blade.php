@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!--Header-->
<header class="text-center">
    <h1>Explore The Beautiful Beach
        <br>
        In Indonesia
    </h1>
    <p class="mt-3">
        Let's Join
        <br>
        Our Campaign
    </p>
    <a href="#popular" class="btn btn-get-started px-3 mt-4">Explore Now</a>
</header>

<!--Statistik-->
<main>
    <div class="container">
        <section class="section-stats row justify-content-center" id="stats">
            <div class="col-3 col-md-2 stats-detail">
                <h2>{{ number_format($stats['members']) }}</h2>
                <p class="stat">Members</p>
            </div>
            <div class="col-3 col-md-2 stats-detail">
                <h2>{{ number_format($stats['places']) }}</h2>
                <p class="stats">Places</p>
            </div>
            <!-- <div class="col-3 col-md-2 stats-detail">
                <h2>{{ number_format($stats['hotels']) }}</h2>
                <p class="stats">Hotels</p>
            </div> -->
            <!-- <div class="col-3 col-md-2 stats-detail">
                <h2>{{ number_format($stats['partners']) }}</h2>
                <p class="stats">Partners</p>
            </div> -->
        </section>
    </div>

    <!--Trip-->
    <section class="section-popular" id="popular">
        <div class="container">
            <div class="row">
                <div class="col text-center section-popular-heading">
                    <h2>Popular Travel Packages</h2>
                    <p>
                        Something Fantastic You Must Know
                        <br>
                        Hidden in This World
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-popular-content" id="popularContent">
        <div class="container">
            <div class="section-popular-travel row justify-content-center">
                @foreach($packages as $index => $package)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 package-card {{ $index >= 4 ? 'hidden-package' : '' }}">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset('storage/' . $package->image_url) }}" 
                                 class="card-img-top" 
                                 alt="{{ $package->package_name }}"
                                 style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-gradient-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $package->category->category_name }}
                                </span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                                <h5 class="card-title text-white mb-0">{{ $package->package_name }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <span class="text-muted small">{{ $package->location }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="text-muted small">{{ $package->duration }} hari</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-users text-primary me-2"></i>
                                <span class="text-muted small">Maksimal {{ $package->max_people }} orang</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Mulai dari</span>
                                    <h6 class="text-primary mb-0">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </h6>
                                </div>
                                <a href="{{ route('bookings.create', $package->package_id) }}" 
                                   class="btn btn-primary btn-sm rounded-pill px-3">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if(count($packages) > 4)
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button id="showMoreBtn" class="btn btn-outline-primary px-4">
                        <i class="fas fa-plus-circle me-2"></i>Show More Packages
                    </button>
                    <button id="showLessBtn" class="btn btn-outline-secondary px-4 d-none">
                        <i class="fas fa-minus-circle me-2"></i>Show Less
                    </button>
                </div>
            </div>
            @endif
        </div>
    </section>

    <section class="section-networks">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Sponsorship</h2>
                    <p>Companies are trusted us
                        <br>more than just a trip
                    </p>
                </div>
                <div class="col-md-8 text-center">
                    <img src="{{ asset('frontend/images/partner.png') }}" alt="Logo Partner" class="img-partner">
                </div>
            </div>
        </div>
    </section>

    <!--Testimoni-->
    <section class="section-testimonial-heading" id="testimonialheading">
        <div class="row">
            <div class="col text-center">
                <h2>They Are Loving Us</h2>
                <p>
                    Moments were giving them
                    <br>
                    the best experience
                </p>
            </div>
        </div>
    </section>

    <section class="section-testimonial-content" id="testimonialcontent">
        <div class="container">
            <div class="section-popular-travel row justify-content-center">
                @foreach($reviews as $review)
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="{{ asset('frontend/images/user_pic' . $loop->iteration . '.png') }}" 
                                 alt="user" class="mb-4 rounded-circle">
                            <h3 class="mb-4">{{ $review->user->full_name }}</h3>
                            <p class="Testimonial">
                                "{{ $review->comment }}"
                            </p>
                            @if($review->admin_reply)
                            <div class="admin-reply border-top pt-3 mt-3 text-start">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary me-2">
                                        <i class="fas fa-headset me-1"></i>Admin
                                    </span>
                                </div>
                                <p class="text-muted small fst-italic">
                                    "{{ $review->admin_reply }}"
                                </p>
                            </div>
                            @endif
                        </div>
                        <hr>
                        <p class="trip-to mt-2">
                            {{ $review->package->package_name }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12 text-center">
            <a href="#popular" class="btn btn-need-help px-4 mt-4 mx-1">
                I Need Help
            </a>
            <a href="{{ route('bookings.index') }}" class="btn btn-get-started px-4 mt-4 mx-1">
                My Bookings
            </a>
        </div>
    </div>
</main>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}
.hidden-package {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const showMoreBtn = document.getElementById('showMoreBtn');
    const showLessBtn = document.getElementById('showLessBtn');
    const hiddenPackages = document.querySelectorAll('.hidden-package');
    
    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function() {
            hiddenPackages.forEach(package => {
                package.style.display = 'block';
            });
            showMoreBtn.classList.add('d-none');
            showLessBtn.classList.remove('d-none');
        });
    }
    
    if (showLessBtn) {
        showLessBtn.addEventListener('click', function() {
            hiddenPackages.forEach(package => {
                package.style.display = 'none';
            });
            showLessBtn.classList.add('d-none');
            showMoreBtn.classList.remove('d-none');
        });
    }
});
</script>
@endsection