<?php

namespace App\Http\Controllers;

use App\Http\Requests\Promotion\IndexRequest;
use App\Http\Requests\Promotion\StorePromotionRequest;
use App\Http\Requests\Promotion\UpdatePromotionRequest;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use App\Services\PromotionService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class PromotionController extends Controller
{
    use ApiResponse;

    public function __construct(private PromotionService $serv)
    {
    }

    // Start home apis
    public function activePromotions(string $apply_to)
    {
        if (!in_array($apply_to, ['all_menu', 'categories', 'dishes'])) {
            return $this->errorResponse(null, 400);
        }
        $promotions = $this->serv->handleActivePromotions($apply_to);
        return $this->successResponse(PromotionResource::collection($promotions), 200);
    }
    // End home apis

    // Start owner apis

    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $promotions = $this->serv->handlePromotionIndex($data);

        return $this->successResponse(PromotionResource::collection($promotions), 200, $promotions);
    }

    public function store(StorePromotionRequest $request)
    {

        $data = $request->validated();
        $promotion = $this->serv->handleStorePromotion($data);

        return $this->successResponse($promotion, 201);

    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $data = $request->validated();

        $this->serv->handleUpdatePromotion($data, $promotion);
        return $this->successResponse(new PromotionResource($promotion), 200);
    }

    public function destroy(Promotion $promotion) {

        $this->serv->handleDestroyPromotion($promotion);
        return $this->successResponse(null, 204);
    }
    // End owner apis
}
