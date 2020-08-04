<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Supplier\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {
        Route::post('register', 'RegisterController@register')->name('user.register');
        Route::post('login', 'AuthController@login')->name('user.login');
        Route::post('logout', 'AuthController@logout')->name('user.logout');
        Route::post('refresh', 'AuthController@refresh')->name('user.refresh.token');
        Route::post('me', 'AuthController@me')->name('user.register')->name('user.profile');
    });

    Route::group(['prefix' => 'suppliers', 'namespace' => 'Supplier'], function () {
        Route::post('register', 'RegisterController@register')->name('supplier.register');
        Route::post('login', 'AuthController@login')->name('supplier.register');
        Route::post('logout', 'AuthController@logout')->name('supplier.register');
        Route::post('refresh', 'AuthController@refresh')->name('supplier.register');
        Route::post('me', 'AuthController@me')->name('supplier.register');
    });

    Route::group(['prefix' => 'admins', 'namespace' => 'Admin'], function () {
        Route::post('register', 'RegisterController@register')->name('admin.register');
        Route::post('login', 'AuthController@login')->name('admin.register');
        Route::post('logout', 'AuthController@logout')->name('admin.register');
        Route::post('refresh', 'AuthController@refresh')->name('admin.register');
        Route::post('me', 'AuthController@me')->name('admin.register');
    });
});



Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'ProductController@index')->name('products.index');
    Route::get('/{product}', 'ProductController@show')->name('products.show');

    Route::group(['middleware' => 'auth:supplier_api'], function () {
        Route::post('store', 'ProductController@store')->name('products.store');
        Route::delete('/{product}/delete', 'ProductController@destroy')->name('products.destroy');
        Route::put('{product}/update', 'ProductController@update')->name('products.update');
    });
});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/token', 'CartController@genrateToken')->name('cart.token');
    Route::post('/{product_id}', 'CartController@addProductToCart')->name('cart.add_product');
    Route::get('/checkout', 'CartController@checkout')->name('cart.checkout');
});

Route::group(['prefix' => 'order'], function () {
    Route::post('/store', 'OrderController@store')->name('order.store')->name('order.store');
    Route::post('/process/{unique_id}', 'PaymentController@processOrder')->name('patment.process');
    Route::post('/confirm/{confirmation_code}', 'PaymentController@confirmPayment')->name('payment.confirm');
    Route::post('/cancel', 'OrderController@destroy')->name('order.cancel');
});

Route::group([
    'prefix' => 'suppliers',
    'namespace' => 'Supplier',
    'middleware' => 'auth:admin_api'
    ], function () {
            Route::get('/', 'SupplierController@index')->name('supplier.show');
            Route::get('/{supplier}', 'SupplierController@show')->name('supplier.show');
            Route::put('activate/{supplier}', 'SupplierController@activateSupplier')->name('supplier.activate');
            Route::put('deactivate/{supplier}', 'SupplierController@deactivateSupplier')->name('supplier.deactivate');
            Route::delete('delete/{id}', 'SupplierController@destroy')->name('supplier.destroy');
    });

Route::group([
    'prefix' => 'users',
    'namespace' => 'User',
    'middleware' => 'auth:admin_api'
], function () {
    Route::get('/', 'UserController@index')->name('user.show');
    Route::get('/{user}', 'UserController@show')->name('user.show');
    Route::delete('delete/{user}', 'UserController@destroy')->name('user.destroy');
});

Route::group(['prefix' => 'categories'], function () {

    Route::get('/', 'CategoryController@index')->name('category.index');
    Route::get('/{category}', 'CategoryController@show')->name('category.show');

    Route::group(['middleware' => 'auth:admin_api'], function () {
        Route::post('/store', 'CategoryController@store')->name('category.store');
        Route::put('/update/{category}', 'CategoryController@update')->name('category.update');
        Route::delete('/delete/{category}', 'CategoryController@destroy')->name('category.destroy');
    });
});
