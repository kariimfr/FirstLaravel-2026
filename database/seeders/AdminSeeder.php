<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kariim Faidlurrahman',
            'email' => 'rm@gmail.com',
            'password' => Hash::make('0987654321'),
            'role' => 'admin',
        ]);
    }
}
