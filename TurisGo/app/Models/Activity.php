<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'id_item',
        'name',
        'description',
        'address_id',
        'price_hour',
        'cancel_anytime',
        'reserve_now_pay_later',
        'guide',
        'small_groups',
        'language',
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
