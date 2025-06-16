<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Return success response for API
     */
    protected function sendResponse($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return error response
     */
    protected function sendError(string $message, $errors = null, int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Handle view rendering with error handling
     */
    protected function renderView(string $view, array $data = [], string $errorMessage = 'Halaman tidak dapat dimuat')
    {
        try {
            return view($view, $data);
        } catch (\Exception $e) {
            Log::error("View render error in {$view}: " . $e->getMessage());
            
            // Jika dalam mode debug, tampilkan error detail
            if (config('app.debug')) {
                $data['error'] = $e->getMessage();
                $data['debug_trace'] = $e->getTraceAsString();
            } else {
                $data['error'] = $errorMessage;
            }
            
            return view($view, $data)->with('hasError', true);
        }
    }

    /**
     * Handle common exceptions
     */
    protected function handleException(\Exception $e, string $defaultMessage = 'Terjadi kesalahan', int $code = 500)
    {
        Log::error($e->getMessage(), [
            'exception' => $e,
            'request' => request()->all(),
            'url' => request()->url()
        ]);
        
        if (request()->expectsJson()) {
            return $this->sendError(
                config('app.debug') ? $e->getMessage() : $defaultMessage,
                null,
                $code
            );
        }
        
        return back()
            ->withErrors(['error' => $defaultMessage])
            ->withInput()
            ->with('alert', [
                'type' => 'error',
                'message' => $defaultMessage
            ]);
    }

    /**
     * Validate required files exist
     */
    protected function validateFileExists(string $filePath, string $errorMessage = 'File tidak ditemukan'): bool
    {
        if (!file_exists($filePath)) {
            throw new \Exception($errorMessage . ": {$filePath}");
        }
        return true;
    }
}