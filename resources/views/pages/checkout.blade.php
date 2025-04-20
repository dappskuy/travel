@extends('layouts.checkout')

@section('title','Detail Travel')

@section('content')

<main>
            <section class="section-details-header"></section>
            <section class="section-details-content">

                <!--Breadcrumb-->
                <div class="container">
                    <div class="row">
                        <div class="col p-0">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        Paket Travel
                                    </li>
                                    <li class="breadcrumb-item">
                                        Details
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Checkout
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 pl-lg-0">
                            <div class="card card-details">
                                <h1>Who is Going?</h1>
                            <p>Trip to Pantai Kuta, Indonesia</p>
                                <div class="attendee">
                                    <table class="table
                                    table-responsive-sm text-center">
                                    <thead>
                                        <tr>
                                            <td>Picture</td>
                                            <td>Name</td>
                                            <td>Nationality</td>
                                            <td>Visa</td>
                                            <td>Passport</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="{{asset('frontend/images/user_picrazor.png')}}" class="user-img" alt="">
                                            </td>
                                            <td class="align-middle">
                                                Razor
                                            </td>
                                            <td class="align-middle">
                                                Nomaden
                                            </td>
                                            <td class="align-middle">
                                                N/A
                                            </td>
                                            <td class="align-middle">
                                                N/A
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <img src="{{asset('frontend/images/close.png')}}" alt="">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{asset('frontend/images/user_picasep.png')}}" class="user-img" alt="">
                                            </td>
                                            <td class="align-middle">
                                                Asep
                                            </td>
                                            <td class="align-middle">
                                                Nomaden
                                            </td>
                                            <td class="align-middle">
                                                30 days
                                            </td>
                                            <td class="align-middle">
                                                Active
                                            </td>
                                            <td>
                                                <a href="#">
                                                    <img src="{{asset('frontend/images/close.png')}}" alt="">
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                <div class="member mt-3">
                                    <h2>Add Member</h2>
                                    <form action=""
                                    class="form-inline">
                                        <label for="inputUsername"
                                        class="sr-only">Name</label>
                                        <input type="text" name="inputUsername"
                                        class="form-control 
                                        mb-2 mr-sm-2" id="inputUsername" 
                                        placeholder="Username">
                                        <label for="inputVisa"
                                        class="sr-only">Visa</label>
                                        <select name="inputVisa" id="inputVisa" 
                                        class="custom-select mb-2 mr-sm-2">
                                            <option value="VISA" selected>VISA</option>
                                            <option value="30 Days">30 Days</option>
                                            <option value="N/A">N/A</option>
                                        </select>

                                        <label for="doePassport" 
                                        class="sr-only">DOE Passport</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <input type="text" class="form-control datepicker"
                                            id="doePassport" placeholder="DOE Passport">
                                        </div>

                                        <button type="submit" 
                                        class="btn btn-add-now mb-2 px-4">
                                            Add Now
                                        </button>
                                </form>
                                <h3 class="mt-2 mb-0">Note</h3>
                                <p class="disclaimer mb-0">Heyyo</p>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-details card-right">
                            <h2>Checkout Information</h2>
                            <table class="trip-information">
                                <tr>
                                    <th width="50%">Members</th>
                                    <td width="50%" class="text-right">
                                        2 Person
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th width="50%">Additional Visa</th>
                                    <td width="50%" class="text-right">
                                        $ 50,00
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th width="50%">Trip Price</th>
                                    <td width="50%" class="text-right">
                                        $20,00 / Person
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th width="50%">Sub Total</th>
                                    <td width="50%" class="text-right">
                                        $ 100,00
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th width="50%">Total (+Discount)</th>
                                    <td width="50%" class="text-right">
                                        $ 99,00
                                    </td>
                                    
                                </tr>
                            </table>
                            <hr>
                            <h2>Payment Instruction</h2>
                            <p class="payment-instruction">
                                Complete your payment before to continue the amazing trip
                            </p>
                            <div class="bank">
                                <div class="bank-item pb-3">
                                    <img src="{{asset('frontend/images/bank.png')}}" 
                                    alt="" class="bank-image">
                                    <div class="description">
                                        <h3>PT Vynx Travel</h3>
                                        <p>
                                            0800 0001 0002
                                            <br>
                                            Bank Rakyat Indonesia
                                        </p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                    <div class="bank-item pb-3">
                                        <img src="{{asset('frontend/images/bri-removebg-preview (1).png')}}" alt=""
                                    class="bank-image">
                                        <div class="description">
                                            <h3>PT Vynx Travel</h3>
                                            <p>
                                                0800 0001 0002
                                                <br>
                                                Bank Central Asia
                                            </p>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                </div>
                <div class="join-container">
                    <a href="succes" class="btn btn-block
                    btn-join-now mt-3 py-2">
                        I Have Paid    
                </a>
                </div>
                <div class="text-center mt-3">
                    <a href="details" 
                    class="text-muted">
                        Cancel Booking
                    </a>
                </div>
            </div>
            </section>
        </main>

    
@endsection
@push('prepend-style')
        <link rel="stylesheet" href="{{asset('frontend/styles/main.css')}}">
       
 @endpush

 @push('addon-script')
 <script src="{{ asset('frontend/libraries/gijgo/js/gijgo.js')}}"></script>
        <script>
            $('.datepicker').datepicker({
                    uilibrary:'bootstrap4',
                    icons:{
                        rightIcon:'<img src="frontend/images/doe.png" />'
                    }
                });
        </script>

@endpush