<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\ManagesFiles;
use Illuminate\Support\Facades\Hash;

class AuthService {
    use ManagesFiles;

    public function handleLogin(array $data, $type): string {



        $model = match ($type) {
            'owner' => Admin::class,
            'user' => User::class,
            default => User::class
        };

        if ($type ===  'owner') {
            $user = $model::where('email', $data['identifier'])->first();
        } else {
            $fieldType = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            $user = $model::where($fieldType, $data['identifier'])->first();
        }

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Challenge', 'Invalid login credentials');
        }

        return $user->createToken('web-token')->plainTextToken;
    }   

    public function handleRegister(array $data, $image): array {
        unset($data['image']);

        $user = User::create($data);
        if ($image) {
            $imgName = $this->uploadFile($image, 'users', $user->id);
            $user->update(['image' => $imgName]);
        }

        $token = $user->createToken('web-token')->plainTextToken;

        unset($data['password_confirmation'], $data['password']);

        return ['data' => $user, 'token' => $token];
    }

    public function handleLogout($user): void {
        $user->currentAccessToken()->delete();
    }

}