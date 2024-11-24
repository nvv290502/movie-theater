<?php

namespace App\Exceptions;

use Exception;

class InvalidNumbericException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'status' => 400,
            'message' => $this->getMessage(),
        ], status: 400);
    }
}
