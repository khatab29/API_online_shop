<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'title' => $this->title,
        'final price' => $this->final_price,
        'in_stock' => $this->quantity,
        'links' => [
            'view' => route('products.show', $this->id),
            ]
        ];
    }
}
