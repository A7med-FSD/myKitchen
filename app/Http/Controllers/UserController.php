<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Traits\ManagesFiles;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponse, ManagesFiles;
    // Home Apis

    public function __construct(private UserRepository $repo)
    {
    }

    public function profile() {
        $user = User::where('id', Auth::id())->withCount('orders')->firstOrFail();
        if($user->orders_count > 0) {
            $this->repo->getUserProfile($user);
        }

        return $this->successResponse(new UserResource($user), 200);
    }

    public function update(UserRequest $request) {

        $user = Auth::user();
        $data = $request->validated();
        
        if($request->hasFile('image')) {
            $data['image'] = $this->updateFile($request->file('image'), 'users', $user->image, $user->id);
        }

        $user->update($data);
        return $this->successResponse(new UserResource($user), 200);

    }
}
