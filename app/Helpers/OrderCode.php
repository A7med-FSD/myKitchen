<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

class OrderCode {
	
	public static function generateOrderCode(): string {
		$orderNum = Redis::incr('order_num');
		$code = now()->format('Ymd') . '-' . sprintf('%04d', $orderNum);

		if ($orderNum == 1) {
			$midNight = now()->endOfDay();
			Redis::expireAt('order_num', $midNight->timestamp);
		}

		return $code;
	}
}