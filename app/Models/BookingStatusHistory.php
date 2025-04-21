<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'booking_status_history';
    protected $primaryKey = 'history_id';
    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'status',
        'changed_by',
        'notes'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
} 