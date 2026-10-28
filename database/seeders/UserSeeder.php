<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create or update Admin User
        User::updateOrCreate(
            ['email' => 'admin@tshirtstore.com'],
            [
                'name' => 'Admin Manager',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+1 (800) 555-TEES',
                'address' => '742 Evergreen Blvd, Apt 4B',
                'city' => 'Los Angeles',
                'postal_code' => '90014',
                'country' => 'United States',
            ]
        );

        // Create or update Regular Customer
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1 (555) 234-5678',
                'address' => '120 Sunset Strip, Suite 300',
                'city' => 'West Hollywood',
                'postal_code' => '90069',
                'country' => 'United States',
            ]
        );
    }
}