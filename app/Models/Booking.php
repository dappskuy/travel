<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'number_of_people',
        'total_price',
        'status',
        'payment_status',
        'payment_proof_image',
        'payment_date',
        'admin_notes'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'payment_date' => 'datetime',
        'total_price' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(TravelPackage::class, 'package_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(BookingStatusHistory::class, 'booking_id');
    }

    public function review()
    {
        return $this->hasOne(PackageReview::class, 'booking_id');
    }
} 