<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use App\ApiResponse;

class ReviewController extends Controller
{
    use ApiResponse;

    // Home Apis
    public function store(ReviewRequest $request) {
        $data = $request->validated();

        $review = Review::make($data);
        $review->dish_id = $data['dish_id'];
        $review->user_id = $request->user()->id; 
        $review->save();

        return $this->successResponse($review, 201);
    }

    // Owner Apis
    public function togglePublish($reviewId) {
        $review = Review::find($reviewId);

        $review->is_published = !$review->is_published;
        $review->save();

        return $this->successResponse($review, 200);
    } 
}
