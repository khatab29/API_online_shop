<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\ProductValidator;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{
    use ResponseTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductValidator $request)
    {
        $validated = $request->validated();
        $product = Product::create([
            'title' => $request->title,
            'supplier_id' => auth('supplier_api')->user()->id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'discount' => $request->discount,
            'final_price' => round((1 - ($request->discount / 100)) * $request->price, 2),
            'quantity' => $request->quantity
        ]);
        return $this->returnData(new ProductResource($product), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductValidator $request, Product $product)
    {
        if ($product->supplier_id !== auth('supplier_api')->user()->id) {
            return $this->returnError('unautherized', 401);
        }

        $validated = $request->validated();

        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->final_price = round((1 - ($request->discount / 100)) * $request->price, 2);
        $product->quantity = $request->quantity;
        $product->save();

        return $this->returnData(new ProductResource($product), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->supplier_id !== auth('supplier_api')->user()->id) {
            return $this->returnError('unautherized', 401);
        }
        $product->delete;
        return $this->returnSuccess('Product deleted', 200);
    }
}
