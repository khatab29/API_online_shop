<?php

namespace App\Traits;

trait ResponseTrait
{

    public function returnData($value, $nu)
    {
        return response()->json([
            'status' => 'success',
            'data' => $value
        ], $nu);
    }

    public function returnError($value, $nu)
    {
        return response()->json([
            'status' => 'failed',
            'massage' => $value
        ], $nu);
    }

    public function returnSuccess($value, $nu)
    {
        return response()->json([
            'status' => 'success',
            'massage' => $value
        ], $nu);
    }

}
