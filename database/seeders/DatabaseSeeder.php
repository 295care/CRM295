<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
       User::updateOrCreate(
            ['email' => 'admin@crm.test'],
            [
                'name' => 'Admin CRM',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'sales1@crm.test'],
            [
                'name' => 'Sales 1',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'sales2@crm.test'],
            [
                'name' => 'Sales 2',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
