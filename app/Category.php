<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * Defining many to one realation with Product model
     *
     *
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
