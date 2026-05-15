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
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@gmail.com',
                'role'     => 'admin',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
            ]
        );
    }
}
