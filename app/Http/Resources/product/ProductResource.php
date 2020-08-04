<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\SupplierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'discount' => $this->discount,
            'final price' => $this->final_price,
            'in_stock' => $this->quantity,
            'category' => $this->category->name,
            'supplier' => [
               'name' => $this->supplier->name,
               'email' => $this->supplier->email
            ],
            'links' => [
             'delete' => route('products.destroy', $this->id),
             'update' => route('products.update', $this->id),
            ]
        ];
    }
}
