<?php 

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserRepository {

    public function getUserProfile(User $user): void {
        $user->favorite_category_name = $this->getFavoriteCategory($user->id)->first();
        $user->last_order_time = $this->getLastOrder($user->id)->first();
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function getIndexUsers(array $data): LengthAwarePaginator {

        $sign = null;
        $oneMonthAgo = null;
        if(isset($data['availability'])) { 
            $sign = $data['availability'] == "active" ? '>=' : '<';
            $oneMonthAgo = Carbon::now()->subMonth();
        }

        return User::query()
            ->withCount('orders')
            ->addSelect(['favorite_category_name' => $this->getFavoriteCategory()])
            ->addSelect(['last_order_time' => $this->getLastOrder()])
            ->when(isset($data['searchBody']) && isset($data['searchBy']), 
                fn($query) => $query->where($data['searchBy'], 'like', "%{$data['searchBody']}%")
            )
            ->when(isset($data['status']), 
                fn($query) => $query->where('status', '=', $data['status'])
            )
            ->when(isset($data['availability']), 
                fn($query) => $query->having('last_order_time', $sign, $oneMonthAgo) // عايزين قدام نبقى نخلى المده ال owner الى يحددها من ملف setting.json
            )
            ->orderBy($data['sortBy'], $data['direction'])
            ->paginate(10);

    }

    private function getFavoriteCategory(?int $userId = null): Builder {
        return DB::table('categories')
            ->join('dishes', 'categories.id', '=', 'dishes.category_id')
            ->join('dish_order', 'dishes.id', '=', 'dish_order.dish_id')
            ->join('orders', 'orders.id', '=', 'dish_order.order_id')
            ->when($userId,
                fn($query) => $query->where('orders.user_id', $userId),
                fn($query) => $query->whereColumn('orders.user_id', 'users.id')
            )
            ->groupBy('categories.name')
            ->orderByRaw('COUNT(*) DESC')
            ->select('categories.name')
            ->limit(1);
    }

    private function getLastOrder(?int $userId = null): Builder {
        return DB::table('orders')
            ->when($userId,
                fn($query) => $query->where('orders.user_id', $userId),
                fn($query) => $query->whereColumn('orders.user_id', 'users.id')
            )
            ->select('orders.created_at')
            ->orderBy('orders.created_at', 'DESC')
            ->limit(1);
    }
}