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
        'price_night',
        'stars',
        'average_guest_rating',
        'free_wifi',
        'parking',
        'gym',
        'pool',
        'spa_wellness',
        'hotel_restaurant',
        'bar',
        'refundable_reservations',
        'country',
        'zip_code',
        'city',
        'street',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }
}
