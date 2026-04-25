<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@songotsamples.com'],
            [
                'name' => 'Super Admin',
                'password_hash' => Hash::make('admin@123'),
                'role' => 'admin',
                'status' => 'active',
                'plan_tier' => 'full',
            ]
        );
    }
}