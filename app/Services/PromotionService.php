<?php

namespace App\Services;

use App\Models\Promotion;
use App\Repositories\PromotionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class PromotionService {

    public function __construct(private PromotionRepository $repo)
    {
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function handleActivePromotions(string $apply_to): Collection {
        return $this->repo->getActivePromotions($apply_to);
    }

    /**
     * @return CursorPaginator<Promtoion>
     */
    public function handlePromotionIndex(array $data): CursorPaginator {
        return $this->repo->getIndex($data);
    }

    /**
     * @return Promotion
     */
    public function handleStorePromotion(array $data): Promotion {

        $dishes = $data['dishes'] ?? [];
        $categories = $data['categories'] ?? [];

        unset($data['dishes'], $data['categories']);

        $promotion = Promotion::create($data);

        if (!empty($dishes) && $promotion->apply_to === 'dishes') {
            $promotion->dishes()->attach($dishes);
        }

        if (!empty($categories) && $promotion->apply_to === 'categories') {
            $promotion->categories()->attach($categories);
        }

        return $promotion;
    }

    public function handleUpdatePromotion(array $data, Promotion $promotion): void {
        $dishes = $data['dishes'] ?? [];
        $categories = $data['categories'] ?? [];
        unset($data['dishes'], $data['categories']);
        if (isset($data['apply_to']) && $data['apply_to'] !== $promotion->apply_to) {
            if ($promotion->apply_to === 'dishes') $promotion->dishes()->detach();
            if ($promotion->apply_to === 'categories') $promotion->categories()->detach();
        }

        if (!empty($data)) {
            $promotion->update($data);
        }

        if (!empty($dishes)) $promotion->dishes()->sync($dishes);
        if (!empty($categories)) $promotion->categories()->sync($categories);
    }


    public function handleDestroyPromotion(Promotion $promotion): void {

        if ($promotion->apply_to === 'dishes') $promotion->dishes()->detach();
        if ($promotion->apply_to === 'categories') $promotion->categories()->detach();

        $promotion->delete();
    }
}