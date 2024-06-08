<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'phone' => "0123456789",
            'city' => "Hà Nội",
            'district' => 'Thanh Xuan',
            'ward' => 'Nhân Chính',
            'address' => "Số 1, ngõ 1, phố 1",
            'role' => UserRoleEnum::ADMIN
        ]);
    }
}
