<?php

namespace App\Repositories;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class DishRepository {

    /**
     * @return CursorPaginator<int, Dish>
     */
    public function getMostOrderedDishes(): CursorPaginator {
        return Dish::query()
            ->with('activePromotion')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->orderBy('id')
            ->cursorPaginate(3);
    }

    /**
     * @return CursorPaginator<int, Dish>
     */
    public function getDishes(array $data): CursorPaginator {
        return Dish::query()
            ->when(isset($data['category_id']), fn($q) => $q->where('category_id', $data['category_id']))
            ->when(isset($data['badge']) && $data['badge'] !== 'all', fn($q) => $q->where('badge', $data['badge']))
            ->when(isset($data['searchBody']) && $data['searchBody'] !== '', function ($q) use ($data) {
                if (!$data['searchBy']  || $data['searchBy'] === '' || $data['searchBy'] === 'all') {
                    return $q->where('name', 'LIKE', "%{$data['searchBody']}%")
                        ->orWhere('description', 'LIKE', "%{$data['searchBody']}%");
                } elseif ($data['searchBy'] === 'name') {
                    return $q->where('name', 'LIKE', "%{$data['searchBody']}%");
                } elseif ($data['searchBy'] === 'description') {
                    return $q->where('description', 'LIKE', "%{$data['searchBody']}%");
                } else {
                    return $q;
                }
            })
            ->when(isset($data['is_available']), fn($q) => $q->where('is_available', $data['is_available']))
            ->with(['category', 'activePromotion'])
            ->withCount('orders')
            ->orderBy('name')
            ->orderBy('id')
            ->cursorPaginate(4);
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getMostPopularDishes(): Collection {
        return Dish::query()
            ->with('activePromotion')
            ->withCount('orders')
            ->orderBy('rate', 'desc')
            ->orderBy('orders_count', 'desc')
            ->orderBy('id')
            ->limit(9)
            ->get();
    }
}