<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('inventory.admin_email');
        $password = config('inventory.admin_password');

        if (! $email || ! $password || strlen($password) < 12) {
            throw new RuntimeException('Atur ADMIN_EMAIL dan ADMIN_PASSWORD minimal 12 karakter pada .env sebelum menjalankan db:seed.');
        }

        if (User::query()->where('email', $email)->exists()) {
            return;
        }

        $admin = new User([
            'name' => 'Administrator',
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $admin->forceFill(['role' => 'admin'])->save();
    }
}
