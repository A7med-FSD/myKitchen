<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use App\ApiResponse;
use Carbon\Carbon;

class PromotionController extends Controller
{
    use ApiResponse;

    // Start home apis
    public function activePromotions ($apply_to) {

        if($apply_to !== 'all_menu' && $apply_to !== 'categories' && $apply_to !== 'dishes') {
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
    
    public function index() {
        
    }

    // End owner apis
}
