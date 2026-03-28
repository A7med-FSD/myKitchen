<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name'          => 'Ahmed Owner',
            'email'         => 'owner@mykitchen.com',
            'phone_numbers' => ['+201001234567', '+201009876543'],
            'password'      => Hash::make('password123'),
        ]);
    }
}

