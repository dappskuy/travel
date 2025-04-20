<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelCategory extends Model
{
    use HasFactory;

    protected $table = 'travel_categories';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'description'
    ];

    public function travelPackages()
    {
        return $this->hasMany(TravelPackage::class, 'category_id');
    }
} 