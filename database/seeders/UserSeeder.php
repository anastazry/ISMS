<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'anas-admin',
            'email' => 'john.doe@example.com',
            'worker_id' => 'jci200089',
            'phone_no' => '011111111',
            'role' => 'Admin',
            'username' => 'anas-adminz',
            'password' => Hash::make('12341234'), // Ensure the password is hashed
        ]);
    }
}
