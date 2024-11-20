<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'numb_people_hotel',
        'room_type_hotel',
        'reservation_date_hotel',
        'numb_people_activity',
        'hours_activity',
        'train_type',
        'train_people_count',
        'order_id',
        'item_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
