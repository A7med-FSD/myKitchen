<?php

namespace App\Listeners;

use App\Events\OrderDelivered;
use App\Jobs\EvaluateCustomerStatusJob;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EvaluateCustomerStatus
{
    public $user;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderDelivered $event): void
    {
        EvaluateCustomerStatusJob::dispatch($event->userId);
    }
}
