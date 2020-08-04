<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'title', 'supplier_id', 'category_id',  'price', 'discount', 'final_price',
    ];

    /**
    * Defining many to many realation with User model
    *
    *
    */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
    * Defining many to many realation with Cart model
    *
    *
    */
    public function carts()
    {
        return $this->belongsToMany('App\Cart')
                    ->withTimestamps();
    }

    /**
     * Defining many to many realation with order model
     *
     *
     */

    public function orders()
    {
        return $this->belongsToMany('App\Order')
                    ->withTimestamps();
    }

    /**
     * Defining one to many realation with Supplier model
     *
     *
     */

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    /**
     * Defining one to many realation with Category model
     *
     *
     */

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
