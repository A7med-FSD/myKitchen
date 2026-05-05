<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\OrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class EvaluateCustomerStatusJob implements ShouldQueue
{
    use Queueable;

    public $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(OrderService $service): void
    {
        $user = User::with('orders.dishes')->findOrFail($this->userId);
        
        if($user->status == 'regular' || $user->status == 'new') {
            $setting_rules = json_decode(Storage::disk('private')->get('setting.json'), false);
            $customer = $setting_rules->Customer_settings;
            
            if($user->status == 'regular') {
                $vip = $customer->VIP_settings;
                
                if($user->orders->count() >= $vip->MIN_ORDER_COUNT) {
                    $total_spend = 0;
                    $service->calculateTotalPrice($user->orders);
                    foreach($user->orders as $order) {
                        $total_spend += $order->total_price;
                    }
                    if($total_spend >= $vip->MIN_SPEND) {
                        $user->status = 'vip';
                        $user->save();
                    }
                }
            }
            elseif($user->status == 'new') {
                $regular = $customer->Regular_settings;

                if ($user->orders->count() >= $regular->MIN_ORDER_COUNT) {
                    $total_spend = 0;
                    $service->calculateTotalPrice($user->orders);
                    foreach ($user->orders as $order) {
                        $total_spend += $order->total_price;
                    }
                    if ($total_spend >= $regular->MIN_SPEND) {
                        $user->status = 'regular';
                        $user->save();
                    }
                }
            }
        }
    }
}
