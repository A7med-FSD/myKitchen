<?php

namespace App\Repositories;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection as SupportCollection;

class OrderRepository {

	/**
	 * @return CursorPaginator<\App\Models\Order>
	 */
	public function getAllOrders(array $data): CursorPaginator {

		return Order::query()
			->when(isset($data['status']), fn($q) => $q->where('status', $data['status']))
			->when(isset($data['searchBody']) && $data['searchBody'] !== '', function ($q) use ($data) {
				if (!isset($data['searchBy'])  || $data['searchBy'] === '' || $data['searchBy'] === 'all') {
					return $q->where('order_code', 'LIKE', "%{$data['searchBody']}%")
						->orWhere('customer_name', 'LIKE', "%{$data['searchBody']}%")
						->orWhere('customer_phone', 'LIKE', "%{$data['searchBody']}%");
				} elseif ($data['searchBy'] === 'order_code') {
					return $q->where('order_code', 'LIKE', "%{$data['searchBody']}%");
				} elseif ($data['searchBy'] === 'customer_name') {
					return $q->where('customer_name', 'LIKE', "%{$data['searchBody']}%");
				} elseif ($data['searchBy'] === 'customer_phone') {
					return $q->where('customer_phone', 'LIKE', "%{$data['searchBody']}%");
				} else {
					return $q;
				}
			})
			->with('dishes')
			->orderBy('created_at', 'desc')
			->orderBy('id')
			->cursorPaginate(4);
	}


	/**
	 * @return Collection<int, Order> 
	 */
	public function getOrders(array $data, int $userId): Collection {

		$orders = Order::where('user_id', $userId)
		->when(isset($data['order_code']), function ($query) use ($data) {
			$query->where('order_code', 'like', '%' . $data['order_code'] . '%');
		})
		->when(isset($data['time']) && $data['time'] !== "all", function ($query) use ($data) {
			if ($data['time'] === "week") {
			$query->where('created_at', '>=', now()->subWeek());
			} elseif ($data['time'] === "month") {
			$query->where('created_at', '>=', now()->subMonth());
			} elseif ($data['time'] === "year") {
			$query->where('created_at', '>=', now()->subYear());
			}
		})
		->with('dishes')
		->orderBy('created_at', 'desc')
		->get();

		return $orders;
	}

	public function getOrderActivePromo($promo_code): ?int {
		$promo = Promotion::where(function ($query) {
			$query->where('apply_to', 'all_menu')
				->orWhere('apply_to', 'special');
		})
			->where('promo_code', $promo_code)
			->active() 
			->first();

		return $promo?->value;
	}

	public function getOrderDishesPromo(SupportCollection $dishIds) : Collection {
		return Dish::with([
			'activePromotion' => function ($q) {
				return $q->select('promotions.value');
			},
			'category.activePromotion' => function ($q) {
				return $q->select('promotions.value');
			}
		])
			->whereIn('id', $dishIds)
			->get();
	}
}