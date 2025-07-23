<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = ['Planta', 'Fuego', 'Veneno'];
        foreach ($cats as $name) {
            \App\Models\Category::updateOrCreate(['name' => $name]);
        }
    }
}
