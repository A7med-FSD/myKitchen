<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Ahmed Ali',
            'email'    => 'ahmed@example.com',
            'phone'    => '01001234567',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Sara Mohamed',
            'email'    => 'sara@example.com',
            'phone'    => '01009876543',
            'password' => Hash::make('password123'),
        ]);
    }
}
