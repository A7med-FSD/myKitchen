<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;
    
    public function login(LoginRequest $request, $type) {
        $data = $request->validated();

        $model = match($type) {
            'owner' => Admin::class,
            'user' => User::class,
            default => User::class
        };

        if($type ===  'owner') {
            $user = $model::where('email', $data['identifier'])->first();
        } else {
            $fieldType = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    
            $user = $model::where($fieldType, $data['identifier'])->first();
        }

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->errorResponse('Invalid login credentials', 401);
        }

        $token = $user->createToken('web-token')->plainTextToken;

        return $this->successResponse($token, 200);
        
    }
}
