<?php

namespace App\Helpers;

class ApiResponse
{
    public static function sendResponse($code = null, $data = null, $msg = null)
    {
        $response = [
            'status' => $code,
            'message' => $msg,
            'data' => $data
        ];

        return response()->json($response);
    }
}
