<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'numb_people_hotel',
        'room_type_hotel',
        'reservation_date_hotel_checkin',
        'reservation_date_hotel_checkout',
        'numb_people_activity',
        'hours_activity',
        'train_type',
        'train_people_count',
        'cart_id',
        'item_id',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
}
