<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin already exists
        if (User::where('email', 'admin@bowlzone.com')->exists()) {
            $this->command->info('Admin user already exists!');
            return;
        }

        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@bowlzone.com',
            'password' => Hash::make('Admin@123'), // Change this password!
            'is_admin' => true,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@bowlzone.com');
        $this->command->info('Password: Admin@123');
        $this->command->warn('⚠️  IMPORTANT: Change this password after first login!');
    }
}
