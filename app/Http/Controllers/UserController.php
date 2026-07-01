<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use App\Traits\ManagesFiles;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponse, ManagesFiles;
    // Start Home & Owner Apis

    public function __construct(private UserRepository $repo, private OrderService $order_service)
    {
    }

    public function profile() {
        $user = User::where('id', Auth::id())->withCount('orders')->firstOrFail();
        if($user->orders_count > 0) {
            $this->repo->getUserProfile($user);
        }
        return $this->successResponse(new UserResource($user), 200);
    }

    //Start Owner Api 

    public function index(IndexUserRequest $request) {
        $data = $request->validated();
        
        $users = $this->repo->getIndexUsers($data);

        return $this->successResponse(UserResource::collection($users), 200, $users);
    }


    // Start Home api
    public function update(UpdateUserRequest $request) {

        $user = Auth::user();
        $data = $request->validated();
        
        if($request->hasFile('image')) {
            $data['image'] = $this->updateFile($request->file('image'), 'users', $user->image, $user->id);
        }

        $user->update($data);
        return $this->successResponse(new UserResource($user), 200);

    }
}
