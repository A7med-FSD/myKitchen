<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use App\Traits\ApiResponse;

class ReviewController extends Controller
{
    use ApiResponse;

    // Home Apis
    public function store(ReviewRequest $request) {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $review = Review::create($data);

        return $this->successResponse($review, 201);
    }

    public function index() {
        $Reviews = Review::where('is_published', true)
        ->with(['user', 'dish'])->orderBy('created_at', 'DESC')->orderBy('rating', 'DESC')->orderBy('id', 'DESC')->cursorPaginate(3);

        return $this->successResponse(ReviewResource::collection($Reviews), 200, $Reviews);
    }

    // Owner Apis
    public function togglePublish($reviewId) {
        $review = Review::find($reviewId);

        $review->is_published = !$review->is_published;
        $review->save();

        return $this->successResponse($review, 200);
    } 
}
