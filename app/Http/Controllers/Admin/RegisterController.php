<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminRegisterValidator;

class RegisterController extends Controller
{
    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AdminRegisterValidator $request)
    {
        $validated = $request->validated();
        $supplier = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = auth('admin_api')->login($supplier);

        return response()->json([
            'massage' => 'success',
            'token' => $token,
        ]);
    }
}
