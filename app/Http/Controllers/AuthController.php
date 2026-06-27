<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    use ApiResponse;
    public function __construct(private AuthService $service)
    {
    }

    
    public function login(LoginRequest $request, $type) {
        $data = $request->validated();

        $token = $this->service->handleLogin($data, $type);

        return $this->successResponse($token, 200);
        
    }

    public function register(RegisterRequest $request) {
        try {
            $data = $request->validated();

            $result = $this->service->handleRegister($data, $request->file('image'));
            return $this->successResponse($result, 201);
        }
        catch (\Exception $e){
            return $this->errorResponse('Something went wrong.', 500);
        }
    }

    public function logout(Request $request) {
        try {
            $user = $request->user();
            $this->service->handleLogout($user);
            return $this->successResponse(null, 204);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong.', 500);
        }
    }
}
