<?php 

namespace App\Repositories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class PromotionRepository {
    
    /**
     * @return Collection<int, Promotion>
     */
    public function getActivePromotions(string $apply_to): Collection {
        return Promotion::query()
            ->where('apply_to', $apply_to)
            ->active()
            ->with(['dishes', 'categories'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * @return CursorPaginator<Promotion>
     */
    public function getIndex(array $data): CursorPaginator {

        return Promotion::query()
            ->when(isset($data['status']) && $data['status'] !== 'all', function ($q) use ($data) {
                if ($data['status'] === 'active') {
                    return $q->active();
                } elseif ($data['status'] === 'expired') {
                    return $q->where('end_date', '<', now());
                } else {
                    return $q->where('start_date', '>', now());
                }
            })
            ->when(isset($data['searchBody']), function ($q) use ($data) {
                if ($data['searchBy'] === 'all') {
                    return $q->where('title', 'LIKE', "%{$data['searchBody']}%")
                        ->orWhere('promo_code', 'LIKE', "%{$data['searchBody']}%");
                } elseif ($data['searchBy'] === 'title') {
                    return $q->where('title', 'LIKE', "%{$data['searchBody']}%");
                } else {
                    return $q->where('promo_code', 'LIKE', "%{$data['searchBody']}%");
                }
            })
            ->with(['dishes', 'categories'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->cursorPaginate(6);
    }
}