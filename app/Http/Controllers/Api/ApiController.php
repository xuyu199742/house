<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function success($data = null, $message = '')
    {
        return $data;
//        return response()->json([
//            'status' => 'ok',
//            'message' => $message,
//            'data' => $data
//        ]);
    }

    public function fail($message = '', $code = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => $code,
            'data' => $data
        ], $code);
    }
}
