<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageReview extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';
    public $timestamps = true;

    protected $fillable = [
        'booking_id',
        'user_id',
        'package_id',
        'rating',
        'comment'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(TravelPackage::class, 'package_id');
    }
} 