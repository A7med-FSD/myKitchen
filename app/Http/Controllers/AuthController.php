<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function register(RegisterRequest $request) {
        try {
            $data = $request->validated();

            if($request->hasFile('image')) {
                $imgExt = $request->image->getClientOriginalExtension();
                $imgName = time() . '.' . $imgExt;
                $request->file('image')->storeAs('users', $imgName, 'public');
                $data['image'] = $imgName;
            }

            $user = User::create($data);
            $token = $user->createToken('web-token')->plainTextToken;
            
            unset($data['password_confirmation'], $data['password']);
            return $this->successResponse(['data' => $user, 'token' => $token], 201);
        }
        catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse(null, 204, 'Logout successful');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
