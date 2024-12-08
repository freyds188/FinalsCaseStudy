<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',  // Make sure this is a valid email
            'password' => Hash::make('adminpassword'),  // Ensure a strong password
            'role' => 'admin',  // Assuming 'role' is the column that distinguishes admin users
        ]);
    }
}
