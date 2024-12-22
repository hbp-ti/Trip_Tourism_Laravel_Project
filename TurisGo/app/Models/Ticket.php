<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'id_item',
        'transport_type',
        'train_type',
        'train_class',
        'departure_hour',
        'quantity',
        'total_price',
        'origin',
        'destination',
        'is_used',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }
}
