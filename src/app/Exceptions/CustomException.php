<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    /**
     * Render an exception into an HTTP response.
     */
    public function render($exception)
    {
        return response()->json(['error' => $exception->getMessage()], 500);
    }
}
