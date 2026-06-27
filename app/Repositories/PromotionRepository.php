<?php 

namespace App\Repositories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;

class PromotionRepository {
    
/**
 * @return Collection<int, Promotion>
 */

    public function getActivePromotions($apply_to): Collection {
        return Promotion::query()
            ->where('apply_to', $apply_to)
            ->active()
            ->with(['dishes', 'categories'])
            ->orderBy('created_at')
            ->get();
    }
}