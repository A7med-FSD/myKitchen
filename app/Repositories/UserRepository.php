<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository {

    public function getUserProfile(User $user): void {
        $user->favorite_category = $this->getFavoriteCategory($user->id);
        $user->last_order = $this->getLastOrder($user->id);
    }

    private function getFavoriteCategory(int $userId) {
        return DB::table('categories')
            ->join('dishes', 'categories.id', '=', 'dishes.category_id')
            ->join('dish_order', 'dishes.id', '=', 'dish_order.dish_id')
            ->join('orders', 'orders.id', '=', 'dish_order.order_id')
            ->where('orders.user_id', $userId)
            ->groupBy('categories.id', 'categories.name')
            ->orderByRaw('COUNT(categories.id) DESC')
            ->select('categories.name', DB::raw('COUNT(categories.id) as order_count'))
            ->first();
    }

    private function getLastOrder(int $userId) {
        return DB::table('orders')
            ->where('user_id', $userId)
            ->select('created_at')
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}