<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ExceptionHandler extends Exception
{
    public static function handle(Exception $e, Request $request, string $customMessage = null): JsonResponse
    {
        Log::error($customMessage ?? 'API Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all(),
        ]);
        return response()->json([
            'success' => false,
            'message' => $customMessage ?? 'An error occurred',
        ], 500);
    }
}
