<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Override;

class InvalidOrderStatusException extends Exception
{

    protected $currentStatus;
    protected $newStatus;

    public function __construct($currentStatus, $newStatus)
    {
        $this->currentStatus = $currentStatus;
        $this->newStatus = $newStatus;
        parent::__construct("Invalid status transition.");
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
            'detailed' => "Cannot change status from {$this->currentStatus} to {$this->newStatus}."
        ], 422);
    }
}
