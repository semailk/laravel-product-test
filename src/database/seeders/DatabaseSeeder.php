<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory([
            User::USER_ROLE => User::USER_ROLE_ADMIN,
            User::USER_EMAIL => 'admin@mail.ru',
            User::USER_PASSWORD => Hash::make('adminadmin')
        ])->create();
        User::factory(10)->create();
        Product::factory(10)->create();
    }
}
