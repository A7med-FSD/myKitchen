<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data, $code = 200, $paginator = null)
    {
        $response = ['data' => $data];

        // Cursor Pagination
        if ($paginator && method_exists($paginator, 'nextCursor')) {
            $response['pagination'] = [
                'next_cursor' => $paginator->nextCursor()?->encode(),
                'prev_cursor' => $paginator->previousCursor()?->encode(),
                'has_more' => $paginator->hasMorePages(),
                'per_page' => $paginator->perPage(),
            ];
        }
        // Page Pagination
        elseif ($paginator && method_exists($paginator, 'lastPage')) {
            $response['pagination'] = [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ];
        }

        return response()->json($response, $code);
    }

    protected function successRegister($data, $message = null, $code = 200,$token)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'token' => $token,
        ], $code);
    }


    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
