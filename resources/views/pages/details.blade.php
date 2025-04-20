@extends('layouts.app')

@section('title','Detail Travel')

@section('content')

<main>
            <section class="section-details-header"></section>
            <section class="section-details-content">
                <div class="container">
                    <div class="row">
                        <div class="col p-0">
                            <nav>
                                <!--Breadcrumb-->
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        Paket Travel
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Details
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 pl-lg-0">
                            <div class="card card-details">
                                <h1>INDONESIA</h1>
                                <p>
                                   Pantai Kuta
                                <div class="gallery">
                                    <div class="xzoom-container">
                                        <img src="{{ asset ('frontend/images/backlit-bali-beach-blue.jpg')}}"
                                        class="xzoom" id="xzoom-default"
                                        xoriginal="{{ asset ('frontend/images/backlit-bali-beach-blue.jpg')}}">
                                    </div>
                                    <div class="xzoom-thumbs">
                                        <a href="{{ asset ('frontend/images/backlit-bali-beach-blue.jpg')}}">
                                            <img src="{{ asset ('frontend/images/backlit-bali-beach-blue.jpg')}}"
                                            class="xzoom-gallery"
                                            width="120" xpreview="{{ asset ('frontend/images/backlit-bali-beach-blue.jpg')}}">
                                        </a>
                                        <a href="{{ asset ('frontend/images/istockphoto-621822524-612x612.jpg')}}">
                                            <img src="{{ asset ('frontend/images/istockphoto-621822524-612x612.jpg')}}"
                                            class="xzoom-gallery"
                                            width="120" xpreview="{{ asset ('frontend/images/istockphoto-621822524-612x612.jpg')}}">
                                        </a>
                                        <a href="{{ asset ('frontend/images/pantai-kuta-bali-indonesia.jpg')}}">
                                            <img src="{{ asset ('frontend/images/pantai-kuta-bali-indonesia.jpg')}}"
                                            class="xzoom-gallery"
                                            width="120" xpreview="{{ asset ('frontend/images/pantai-kuta-bali-indonesia.jpg')}}">
                                        </a>
                                        <a href="{{ asset ('frontend/images/pantaikuta.jpg')}}">
                                            <img src="{{ asset ('frontend/images/pantaikuta.jpg')}}"
                                            class="xzoom-gallery"
                                            width="120" xpreview="{{ asset ('frontend/images/pantaikuta.jpg')}}">
                                        </a>
                                        <a href="{{ asset ('frontend/images/kutabali.jpg')}}">
                                            <img src="{{ asset ('frontend/images/kutabali.jpg')}}"
                                            class="xzoom-gallery"
                                            width="120" xpreview="{{ asset ('frontend/images/kutabali.jpg')}}">
                                        </a>
                                </div>
                                <h2>About Trip</h2>
                                <p>
                                   Yoo let's trip
                                </p>
                                <div class="features row">
                                    <div class="col-md-4">
                                        <div class="description">
                                            <img src="{{ asset ('frontend/images/event.png')}}" alt="">
                                            <h3>Event</h3>
                                            <p>Flying</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 border-left">
                                        <div class="description">
                                            <img src="{{ asset ('frontend/images/language.png')}}" alt="features-image">
                                            <h3>Language</h3>
                                            <p>English</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 border-left">
                                        <div class="description">
                                            <img src="{{ asset ('frontend/images/foods.png')}}" alt="features-image">
                                            <h3>Foods</h3>
                                            <p>Local Foods</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-details card-right">
                            <h2>Our Members</h2>
                            <div class="members my-2">
                                <img src="{{ asset ('frontend/images/user_picalpha.png')}}"
                                class="member-image mr-1">
                                <img src="{{ asset ('frontend/images/user_picasep.png')}}"
                                class="member-image mr-1">
                                <img src="{{ asset ('frontend/images/user_picmaya.png')}}"
                                class="member-image mr-1">
                                <img src="{{ asset ('frontend/images/user_picrazor.png')}}"
                                class="member-image mr-1">
                                <img src="{{ asset ('frontend/images/user_picusep.png')}}"
                                class="member-image mr-1">
                            </div>
                            <hr>
                            <h2>Trip Details</h2>
                            <table class="trip-information">
                                <tr>
                                    <th width="50%">Date of Departure</th>
                                    <td width="50%" class="text-right">
                                        20 Juli, 2023
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%">Duration</th>
                                    <td width="50%" class="text-right">
                                        2D1N
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%">Type</th>
                                    <td width="50%" class="text-right">
                                        For Public
                                    </td>
                                </tr>
                                <tr>
                                    <th width="50%">Price</th>
                                    <td width="50%" class="text-right">
                                        Rp 250k/Person
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="join-container">
                            <a href="checkout"
                            class="btn btn-block btn-join-now mt-3 py-2">
                            Join Now
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
@endsection

@push('prepend-style')
        <link rel="stylesheet" href="{{asset('frontend/styles/main.css')}}">
       
 @endpush

 @push('addon-script')
 <script src="{{ asset('frontend/libraries/dist/xzoom.min.js')}}"></script>
        <script>
            $(document).ready(function() {
                $('.xzoom, .xzoom-gallery').xzoom({
                    zoomWidth: 300,
                    zoomHeight:200,
                    title: false,
                    tint: '#333',
                    Xoffset: 15
                });
            });
        </script>

@endpush