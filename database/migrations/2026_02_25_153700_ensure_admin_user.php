<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Ensure admin user exists and has a known password.
 */
return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $admin = DB::table('users')->where('email_user', 'admin@admin.com')->first();

        if ($admin) {
            // Admin exists — reset password to 'password'
            DB::table('users')
                ->where('email_user', 'admin@admin.com')
                ->update([
                    'password_user' => Hash::make('password'),
                    'role_user' => 'admin',
                    'updated_at' => now(),
                ]);
        } else {
            // Admin doesn't exist — create one
            DB::table('users')->insert([
                'nama_user' => 'Administrator',
                'email_user' => 'admin@admin.com',
                'password_user' => Hash::make('password'),
                'role_user' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Data seeder — nothing to reverse
    }
};
