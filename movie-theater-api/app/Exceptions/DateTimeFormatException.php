<?php

namespace App\Exceptions;

use Exception;

class DateTimeFormatException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'status' => 400,
            'message' => $this->getMessage(),
        ], status: 400);
    }
}
