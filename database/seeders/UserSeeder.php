<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::create([
            'name' => 'Abrar Khan',
            'email' => 'abrar@gmail.com',
            'is_admin'=> 0,
            'password' => Hash::make('12345678')
        ]);
        User::create([
            'name' => 'Admin Khan',
            'email' => 'admin@gmail.com',
            'is_admin'=>1,
            'password' => Hash::make('12345678')
        ]);
    }
}
