<?php

if (!function_exists('apiResponse')) {
    function apiResponse($data = null, $message = 'Thành công', $status = 'success')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'content' => $data,
        ]);
    }
}
