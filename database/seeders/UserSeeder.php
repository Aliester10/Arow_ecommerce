<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'nama_user' => 'Admin Arow',
            'email_user' => 'admin@arow.com',
            'password_user' => Hash::make('password'),
            'role_user' => 'admin',
        ]);

        // Customer User
        User::create([
            'nama_user' => 'John Doe',
            'email_user' => 'customer@example.com',
            'password_user' => Hash::make('password'),
            'role_user' => 'user',
        ]);
        
        // Another Customer
        User::create([
            'nama_user' => 'Jane Smith',
            'email_user' => 'jane@example.com',
            'password_user' => Hash::make('password'),
            'role_user' => 'user',
        ]);
    }
}
