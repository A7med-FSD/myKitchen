<?php

namespace App\Services;

use App\Repositories\PromotionRepository;

class PromotionService {

    public function __construct(private PromotionRepository $repo)
    {
    }

    public function handleActivePromotions($apply_to) {

    }

}