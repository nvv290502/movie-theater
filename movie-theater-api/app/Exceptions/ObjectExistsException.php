<?php

namespace App\Exceptions;

use Exception;

class ObjectExistsException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'status' => 409,
            'message' => $this->getMessage()
        ], 409);
    }
}
