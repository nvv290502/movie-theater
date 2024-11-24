<?php

namespace App\Exceptions;

use Exception;

class ObjectEmptyException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'status' => 204,
            'message' => $this->getMessage()
        ], 200);
    }
}
