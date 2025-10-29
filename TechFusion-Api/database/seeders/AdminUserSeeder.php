<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

User::updateOrCreate(
    ['email' => 'admin@techfusion.com'],
    [
        'name' => 'Administrador',
        'password' => Hash::make('123456'),
        'is_admin' => true,
    ]
);

