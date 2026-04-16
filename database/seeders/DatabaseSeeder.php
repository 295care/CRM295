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
        // Update / buat akun berdasarkan email (aman untuk data yang sudah ada)
        User::updateOrCreate(
            ['email' => 'superadmin@295.com'],
            [
                'name'     => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('Rewdcxz@admin'),
                'role'     => 'superadmin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'bos@295.com'],
            [
                'name'     => 'Bos',
                'username' => 'bos',
                'password' => Hash::make('Rewdcxz@roy'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'restu@295.com'],
            [
                'name'     => 'Restu',
                'username' => 'restu',
                'password' => Hash::make('Rewdcxz@dm'),
                'role'     => 'sales',
            ]
        );

        User::updateOrCreate(
            ['email' => 'husna@295.com'],
            [
                'name'     => 'Husna',
                'username' => 'husna',
                'password' => Hash::make('Rewdcxz@sales'),
                'role'     => 'sales',
            ]
        );

        User::updateOrCreate(
            ['email' => 'agus@295.com'],
            [
                'name'     => 'Agus',
                'username' => 'agus',
                'password' => Hash::make('Rewdcxz@sales1'),
                'role'     => 'sales',
            ]
        );
    }
}
