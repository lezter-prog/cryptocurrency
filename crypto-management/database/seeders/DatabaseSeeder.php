<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@cryptoadmin.com',
            'password' => '$2y$10$E9f0LdzEcqZfjESZcoAwJO0mtlAaSkhYr0e3R2cXsdVH35WZC44zq',//password
        ]);
        UserRole::create([
            'user_id' => 1,
            'role' => 'ADMIN',
        ]);
    }
}
