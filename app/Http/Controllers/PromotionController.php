<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PromotionRequest;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use App\ApiResponse;
use Carbon\Carbon;

class PromotionController extends Controller
{
    use ApiResponse;

    // Start home apis
    public function activePromotions($apply_to)
    {

        if ($apply_to !== 'all_menu' && $apply_to !== 'categories' && $apply_to !== 'dishes') {
            return $this->errorResponse(null, 400);
        }

        $promotions = Promotion::query()
            ->where('apply_to', $apply_to)
            ->where('is_active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->with(['dishes', 'categories'])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse(PromotionResource::collection($promotions), 200);
    }
    // End home apis

    // Start owner apis

    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:all,active,expired,scheduled',
            'searchBy' => 'nullable|in:all,title,promo_code'
        ]);
        $promotions = Promotion::query()
            ->when($request->status && $request->status !== 'all', function ($q) use ($request) {
                if ($request->status === 'active') {
                    return $q->where('is_active', true)
                        ->where('start_date', '<=', now())
                        ->where('end_date', '>=', now());
                } elseif ($request->status === 'expired') {
                    return $q->where('end_date', '<', now());
                } else {
                    return $q->where('start_date', '>', now());
                }
            })
            ->when($request->searchBody, function ($q) use ($request) {
                if ($request->searchBy === 'all') {
                    return $q->where('title', 'LIKE', "%{$request->searchBody}%")
                        ->orWhere('promo_code', 'LIKE', "%{$request->searchBody}%");
                } elseif ($request->searchBy === 'title') {
                    return $q->where('title', 'LIKE', "%{$request->searchBody}%");
                } else {
                    return $q->where('promo_code', 'LIKE', "%{$request->searchBody}%");
                }
            })
            ->with(['dishes', 'categories'])
            ->orderBy('created_at')
            ->orderBy('id')
            ->cursorPaginate(6);

        return $this->successResponse(PromotionResource::collection($promotions), 200, $promotions);
    }

    public function store(PromotionRequest $request)
    {

        try {
            $validation = $request->validated();

            $dishes = $validation['dishes'] ?? [];
            $categories = $validation['categories'] ?? [];

            unset($validation['dishes'], $validation['categories']);

            $promotion = Promotion::create($validation);

            if (!empty($dishes)) {
                $promotion->dishes()->attach($dishes);
            }

            if (!empty($categories)) {
                $promotion->categories()->attach($categories);
            }
            return $this->successResponse(null, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        try {
            $validation = $request->validated();
            $dishes = $validation['dishes'] ?? [];
            $categories = $validation['categories'] ?? [];
            unset($validation['dishes'], $validation['categories']);
            if (isset($validation['apply_to']) && $validation['apply_to'] !== $promotion->apply_to) {
                if ($promotion->apply_to === 'dishes') $promotion->dishes()->detach();
                if ($promotion->apply_to === 'categories') $promotion->categories()->detach();
            }

            $promotion->update($validation);

            if (!empty($dishes)) $promotion->dishes()->sync($dishes);
            if (!empty($categories)) $promotion->categories()->sync($categories);
            return $this->successResponse(null, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    // End owner apis
}
