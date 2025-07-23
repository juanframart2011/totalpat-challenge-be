<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'juan@totalpat.com'],          // evita duplicar al reseedear
            [
                'name'     => 'Demo',
                'password' => Hash::make('12345'), // contraseña que usarás en Postman
            ]
        );
    }
}
