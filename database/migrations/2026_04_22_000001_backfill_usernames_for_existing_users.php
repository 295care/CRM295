<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $users = DB::table('users')
            ->select(['id', 'name', 'email', 'username'])
            ->whereNull('username')
            ->orWhere('username', '')
            ->orderBy('id')
            ->get();

        foreach ($users as $user) {
            $candidate = Str::slug((string) ($user->email ?: $user->name), '_');
            $candidate = trim((string) $candidate, '_');

            if ($candidate === '') {
                $candidate = 'user';
            }

            $username = $candidate;
            $suffix = 1;

            while (
                DB::table('users')
                    ->where('username', $username)
                    ->where('id', '!=', $user->id)
                    ->exists()
            ) {
                $suffix++;
                $username = $candidate.'_'.$suffix;
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        }
    }

    public function down(): void
    {
        // Tidak di-rollback untuk menghindari menghapus username user yang sudah aktif dipakai.
    }
};
