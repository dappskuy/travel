@extends('layouts.admin')

@section('title', 'Edit Travel Package')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Travel Package</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.packages.update', $package->package_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" {{ old('category_id', $package->category_id) == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="package_name">Package Name</label>
                    <input type="text" class="form-control @error('package_name') is-invalid @enderror" id="package_name" name="package_name" value="{{ old('package_name', $package->package_name) }}" required>
                    @error('package_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $package->price) }}" min="0" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $package->duration) }}" required>
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $package->location) }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="include_facilities">Include Facilities</label>
                    <textarea class="form-control @error('include_facilities') is-invalid @enderror" id="include_facilities" name="include_facilities" rows="3" required>{{ old('include_facilities', $package->include_facilities) }}</textarea>
                    @error('include_facilities')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exclude_facilities">Exclude Facilities</label>
                    <textarea class="form-control @error('exclude_facilities') is-invalid @enderror" id="exclude_facilities" name="exclude_facilities" rows="3" required>{{ old('exclude_facilities', $package->exclude_facilities) }}</textarea>
                    @error('exclude_facilities')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_people">Maximum People</label>
                    <input type="number" class="form-control @error('max_people') is-invalid @enderror" id="max_people" name="max_people" value="{{ old('max_people', $package->max_people) }}" min="1" required>
                    @error('max_people')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="available_seats">Available Seats</label>
                    <input type="number" class="form-control @error('available_seats') is-invalid @enderror" id="available_seats" name="available_seats" value="{{ old('available_seats', $package->available_seats) }}" min="0" required>
                    @error('available_seats')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_url">Package Image</label>
                    @if($package->image_url)
                        <div class="mb-2">
                            <img src="{{ Storage::url($package->image_url) }}" alt="{{ $package->package_name }}" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('image_url') is-invalid @enderror" id="image_url" name="image_url">
                    <small class="form-text text-muted">Leave empty to keep the current image</small>
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Package</button>
                <a href="{{ route('admin.packages') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 