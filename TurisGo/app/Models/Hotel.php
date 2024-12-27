<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'id_item',
        'name',
        'description',
        'stars',
        'average_guest_rating',
        'free_wifi',
        'parking',
        'gym',
        'pool',
        'non_smoking_rooms',
        'hotel_restaurant',
        'bar',
        'refundable_reservations',
        'country',
        'zip_code',
        'city',
        'street',
        'lat',
        'lon'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

// No modelo Hotel.php
public function rooms()
{
    return $this->hasMany(Room::class, 'hotel_id');
}

    public function reviews()
    {
        return $this->hasMany(Review::class, 'item_id', 'id_item');
    }
}
