<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'admin123';

        Admin::updateOrCreate(
            ['ci_admin' => '1234567'],
            [
                'user_admin' => 'admin',
                'pass_admin' => Hash::make($password),
                'tel_admin'  => '0981123456',
            ]
        );
    }
}
