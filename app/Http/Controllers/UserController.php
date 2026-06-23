<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponse;
    // Home Apis

    public function profile() {
        $user = User::where('id', Auth::id())->withCount('orders')->first();
        if($user->orders_count > 0) {
            $user->favorite_category = DB::table('categories')
            ->join('dishes', 'categories.id', '=', 'dishes.category_id')
            ->join('dish_order', 'dishes.id', '=', 'dish_order.dish_id')
            ->join('orders', 'orders.id', '=', 'dish_order.order_id')
            ->where('orders.user_id', Auth::id())
            ->groupBy('categories.id', 'categories.name')
            ->orderByRaw('COUNT(categories.id) DESC')
            ->select('categories.name', DB::raw('COUNT(categories.id) as order_count'))
            ->first();

            $user->last_order = DB::table('orders')
            ->where('user_id', Auth::id())
            ->select('created_at')
            ->orderBy('created_at', 'DESC')
            ->first();
        }

        return $this->successResponse(new UserResource($user), 200);
    }

    public function update(UserRequest $request) {
        try {
            $user = Auth::user();
            $data = $request->validated();
    
            if($request->hasFile('image')) {
                if($user->image) {
                    $oldPath = 'users/' . $user->image;
                    if(Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
    
                $imgExt = $request->image->getClientOriginalExtension();
                $imgName = Auth::id() . '_' . time() . '.' . $imgExt;
                $request->file('image')->storeAs('users', $imgName, 'public');
                $data['image'] = $imgName;
            }
    
            $user->update($data);
            return $this->successResponse(new UserResource($user), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
