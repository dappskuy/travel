@extends('layouts.app')

@section('title', )
vynxtravel
@endsection

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
          <a href="#" class="btn btn-get-started px-3 mt-4">Join</a>
    </header>
        <!--Statistik-->
            <main>
                <div class="container">
                    <section class="section-stats row justify-content-center"
                    id="stats">
                        <div class="col-3 col-md-2 stats-detail">
                            <h2>21K</h2>
                            <p class="stat">Members</p>
                        </div>
                        <div class="col-3 col-md-2 stats-detail">
                          <h2>400</h2>
                          <p class="stats">Places</p>
                        </div>
                        <div class="col-3 col-md-2 stats-detail">
                          <h2>5k</h2>
                          <p class="stats">Hotels</p>
                      </div>
                      <div class="col-3 col-md-2 stats-detail">
                        <h2>5</h2>
                        <p class="stats">Partners</p>
                    </div>
                    </section>
                </div>

                <!--Trip-->
                <section class="section-popular" id="popular">
                  <div class="container">
                      <div class="row">
                          <div class="col text-center section-popular-heading">
                              <h2>Pantai   Wisata Terpopuler</h2>
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
                    <div class="section-popular-travel row
                    justify-content-center">
                    <div class="col-sm-6 col-md-4 col-lg-3">
                      <div class="card-travel text-center d-flex flex-column" 
                      style="background-image: url('{{asset('frontend/images/kuta.jpg')}}')">
                          <div class="travel-country">INDONESIA</div>
                          <div class="travel-location">Pantai Kuta</div>
                          <div class="travel-button mt-auto">
                              <a href="details" class="btn btn-travel-details px-4">
                                  View Details
                              </a>
                          </div>
                          
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column" 
                    style="background-image: url('{{ asset ('frontend/images/sengigi.png')}}')">
                        <div class="travel-country">INDONESIA</div>
                        <div class="travel-location">Pantai Sengigi</div>
                        <div class="travel-button mt-auto">
                            <a href="#" class="btn btn-travel-details px-4">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card-travel text-center d-flex flex-column" 
                  style="background-image: url('{{ asset ('frontend/images/tanjungaan.jpg')}}')">
                      <div class="travel-country">INDONESIA</div>
                      <div class="travel-location">Pantai Tanjungaan</div>
                      <div class="travel-button mt-auto">
                          <a href="#" class="btn btn-travel-details px-4">
                              View Details
                          </a>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card-travel text-center d-flex flex-column" 
                style="background-image: url('{{ asset('frontend/images/parangtritis.jpg') }}');">
                    <div class="travel-country">INDONESIA</div>
                    <div class="travel-location">Pantai Parangtritis</div>
                    <div class="travel-button mt-auto">
                        <a href="#" class="btn btn-travel-details px-4">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
                    </div>
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
                      <img src="{{ asset ('frontend/images/partner.png')}}" alt="Logo Partner" class="img-partner">
                    </div>
                  </div>
                </div>
              </section>

              <!--Testimoni-->
              <section class="section-testimonial-heading"
              id="testimonialheading">
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
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="card card-testimonial text-center">
                                <div class="testimonial-content">
                                <img src="{{asset ('frontend/images/user_picrazor.png')}}" alt="user" class="mb-4 rounded-circle">
                                <h3 class="mb-4">Razor</h3>
                                <p class="Testimonial">
                                    "Heyyo"
                                </p>
                                </div>
                            <hr>
                            <p class="trip-to mt-2">
                                Pantai Sengigi
                            </p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="card card-testimonial text-center">
                                    <div class="testimonial-content">
                                    <img src="{{asset ('frontend/images/user_picalpha.png')}}" alt="user" class="mb-4 rounded-circle">
                                    <h3 class="mb-4">Alpha</h3>
                                    <p class="Testimonial">
                                        "Wassup"
                                    </p>
                                    </div>
                                <hr>
                                <p class="trip-to mt-2">
                                    Pantai Parangtritis
                                </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="card card-testimonial text-center">
                                        <div class="testimonial-content">
                                        <img src="{{asset ('frontend/images/user_picmaya.png')}}" alt="user" class="mb-4 rounded-circle">
                                        <h3 class="mb-4">Maya</h3>
                                        <p class="Testimonial">
                                            "Heyyo"
                                        </p>
                                        </div>
                                    <hr>
                                    <p class="trip-to mt-2">
                                        Pantai Kuta
                                    </p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div> 
            </section>
              

              <div class="row">
                <div class="col-12 text-center">
                  <a href="#" class="btn btn-need-help
                  px-4 mt-4 mx-1">
                    I Need Help
                  </a>
                  <a href="#" class="btn btn-get-started
                  px-4 mt-4 mx-1">
                    Get Started
                  </a>
                </div>
              </div>
            </main>

@endsection