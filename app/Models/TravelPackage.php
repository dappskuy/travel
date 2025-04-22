<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPackage extends Model
{
    use HasFactory;

    protected $table = 'travel_packages';
    protected $primaryKey = 'package_id';
    protected $fillable = [
        'category_id',
        'package_name',
        'description',
        'price',
        'duration',
        'location',
        'include_facilities',
        'exclude_facilities',
        'max_people',
        'available_seats',
        'image_url',
        'is_active'
    ];

    protected $casts = [
        'price' => 'integer',
        'is_active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(TravelCategory::class, 'category_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }

    public function reviews()
    {
        return $this->hasMany(PackageReview::class, 'package_id');
    }
} 