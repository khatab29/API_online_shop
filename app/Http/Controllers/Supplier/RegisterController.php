<?php

namespace App\Http\Controllers\Supplier;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SupplierRegisterValidator;

class RegisterController extends Controller
{
    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(SupplierRegisterValidator $request)
    {
        $validated = $request->validated();
        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = auth('supplier_api')->login($supplier);

        return response()->json([
            'massage' => 'success',
            'token' => $token,
        ]);
    }
}
