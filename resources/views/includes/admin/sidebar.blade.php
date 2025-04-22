<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-plane"></i>
        </div>
        <div class="sidebar-brand-text mx-3">vynxtravel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Travel Management
    </div>

    <!-- Nav Item - Categories -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.categories') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Categories</span>
        </a>
    </li>

    <!-- Nav Item - Packages -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.packages') }}">
            <i class="fas fa-fw fa-suitcase"></i>
            <span>Packages</span>
        </a>
    </li>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        User Management
    </div> -->

    <!-- Nav Item - Users -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li> -->

    <!-- Nav Item - Booking Management -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.bookings.index') }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Pemesanan</span>
        </a>
    </li>

    <!-- Nav Item - Review Management -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.reviews.index') }}">
            <i class="fas fa-star"></i>
            <span>Review</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
