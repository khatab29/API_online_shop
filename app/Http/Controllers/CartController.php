<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CartValidator;
use App\Product;
use App\Traits\ResponseTrait;

class CartController extends Controller
{
    use ResponseTrait;

    /**
    *
    *
    *Genrate unique cart token.
    *
    */
    public function genrateToken()
    {
        $token = Str::random(60);
        hash('sha256', $token);

        return $this->returnData($token, 200);
    }

    /**
    * Get cart with valied token.
    *
    * @param \Illuminate\Http\Request $request
    *
    */
    public function getCart(Request $request)
    {
        return Cart::where('token', $request->token)->first();
    }

    /**
    * Create new cart.
    *
    * @param \Illuminate\Http\Request $request
    *
    *
    */
    public function createCart($request)
    {
        $cart = new Cart();
        $cart->forceFill([
            'token' => $request->token
        ])->save();
        $cart->products()->attach($request->product_id);
        return $this->returnSuccess('product added to cart successfully', 200);
    }

    /**
    * update existing cart.
    *
    * @param \Illuminate\Http\Request $request
    *
    *
    */
    public function updateCart(CartValidator $request)
    {
        $validated = $request->validated();
        $cart = $this->getCart($request);
        if (!$cart) {
            return $this->createCart($request);
        }
        $cart->products()->attach($request->product_id);
        return $this->returnSuccess('cart updated successfully', 200);
    }

    /**
    *check if product exist ? add products to cart .
    *
    * @param \Illuminate\Http\Request $request
    *
    *
    */
    public function addProductToCart(CartValidator $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        $quantity = $product->quantity;
        if ($quantity == 0) {
            return $this->returnError('this product is out of stock', 500);
        }
        $product->quantity = $quantity - 1;
        $product->save();

            return $this->updateCart($request);
    }

    /**
    * Checkout the cart with selected products.
    *
    * @param \Illuminate\Http\Request $request
    *
    *
    */
    public function checkout(CartValidator $request)
    {
        $validated = $request->validated();

        $cart = $this->getCart($request);
        $cartItems = $cart->products->count();
        $products_id = $cart->products->pluck('id');
        $products = $cart->products->pluck('title')->toArray();
        $price = $cart->products->pluck('final_price')->toArray();
        $productsWithPrice = array_merge($products, $price);
        $totalPrice = array_sum($price);
        $priceWithTax = round((1 + (10 / 100)) * $totalPrice, 2);
        $data = [
            'custmer email' => auth()->user()->email ?? "",
            'cart items' => $cartItems,
            'products Pricing' => $productsWithPrice,
            'total price' => $totalPrice,
            'price with tax' => $priceWithTax
        ];
        return $this->returnData($data, 200);
    }
}
