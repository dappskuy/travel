@extends('layouts.admin')

@section('title', 'Travel Packages')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Travel Packages</h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Package
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Package List</h6>
            <div>
                <form class="d-none d-sm-inline-block form-inline">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for packages..."
                            aria-label="Search" aria-describedby="basic-addon2" name="search" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Package Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Location</th>
                            <th>Available Seats</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $package->package_id }}</td>
                            <td>
                                @if($package->image_url)
                                    <div class="thumbnail-container" style="width: 100px; height: 100px; overflow: hidden; border-radius: 4px;">
                                        <img src="{{ asset('storage/' . $package->image_url) }}" 
                                             alt="{{ $package->package_name }}" 
                                             class="img-thumbnail" 
                                             style="width: 100%; height: 100%; object-fit: cover;"
                                             onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                    </div>
                                @else
                                    <div class="no-image" style="width: 100px; height: 100px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                        <span class="text-muted">No Image</span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $package->package_name }}</td>
                            <td>{{ $package->category->category_name }}</td>
                            <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                            <td>{{ $package->duration }}</td>
                            <td>{{ $package->location }}</td>
                            <td>{{ $package->available_seats }}</td>
                            <td>
                                @if($package->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.packages.edit', $package->package_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.packages.delete', $package->package_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $packages->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 