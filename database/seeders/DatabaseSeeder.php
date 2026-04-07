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
            ['email' => 'superadmin@295.com'],
            [
                'name' => 'Super Admin CRM',
                'password' => Hash::make('Rewdcxz@295'),
                'role' => 'superadmin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@295.com'],
            [
                'name' => 'Admin CRM',
                'password' => Hash::make('Rewdcxz@admin'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sales1@295.com'],
            [
                'name' => 'Sales 1',
                'password' => Hash::make('Rewdcxz@sales'),
                'role' => 'sales',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sales2@295.com'],
            [
                'name' => 'Sales 2',
                'password' => Hash::make('Rewdcxz@sales'),
                'role' => 'sales',
            ]
        );
    }
}
