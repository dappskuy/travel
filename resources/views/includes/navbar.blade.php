<!--Navbar-->
<div class="container">
    <nav class="row navbar navbar-expand-lg navbar-light bg-white">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('frontend/images/X-removebg-preview 1.png') }}" alt="Brand Element">
        </a>
        <button class="navbar-toggler navbar-toggler-right"
            type="button"
            data-toggle="collapse"
            data-target="#navb">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav ml-auto mr-3">
                <li class="nav-item mx-md-2">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item mx-md-2">
                    <a href="#" class="nav-link">Paket</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbardrop"
                    data-toggle="dropdown">Services</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Link</a>
                        <a href="#" class="dropdown-item">Link</a>
                        <a href="#" class="dropdown-item">Link</a>
                    </div>
                </li>
                <li class="nav-item mx-md-2">
                    <a href="#" class="nav-link">Testimonial</a>
                </li>
            </ul>

            @auth
                <!-- Mobile Button - Logout -->
                <form class="form-inline d-sm-block d-md-none" action="{{ route('logout') }}" method="POST">
                    @csrf
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-login my-2 my-sm-0 mr-2">
                            Dashboard
                        </a>
                    @endif
                    <button type="submit" class="btn btn-login my-2 my-sm-0">
                        Logout
                    </button>
                </form>

                <!-- Desktop Button - Logout -->
                <form class="form-inline my-2 my-lg-0 d-none d-md-block" action="{{ route('logout') }}" method="POST">
                    @csrf
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4 mr-2">
                            Dashboard
                        </a>
                    @endif
                    <button type="submit" class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4">
                        Logout
                    </button>
                </form>
            @else
                <!-- Mobile Button - Login/Register -->
                <div class="form-inline d-sm-block d-md-none">
                    <a href="{{ route('login') }}" class="btn btn-login my-2 my-sm-0 mr-2">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-login my-2 my-sm-0">
                        Register
                    </a>
                </div>

                <!-- Desktop Button - Login/Register -->
                <div class="form-inline my-2 my-lg-0 d-none d-md-block">
                    <a href="{{ route('login') }}" class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4 mr-2">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </nav>
</div>