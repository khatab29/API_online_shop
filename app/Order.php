<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
    'user_id', 'name',
    'address', 'shipment_type',
    'shipment_fees','discount_voucher',
    'discount_amount', 'final_price'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
