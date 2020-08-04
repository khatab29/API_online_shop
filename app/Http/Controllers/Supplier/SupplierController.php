<?php

namespace App\Http\Controllers\Supplier;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Supplier\SupplierResource;
use App\Http\Resources\Supplier\SupplierCollection;
use App\Traits\ResponseTrait;

class SupplierController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SupplierCollection::collection(Supplier::paginate(20));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function activateSupplier(Request $request, Supplier $supplier)
    {
        $supplier->active = 1;
        $supplier->save();
        return $this->returnSuccess('supplier activated', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function deactivateSupplier(Request $request, Supplier $supplier)
    {
        $supplier->active = 0;
        $supplier->save();
        return $this->returnSuccess('supplier deactivated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete;
        return $this->returnSuccess('supplier deleted', 200);
    }
}
