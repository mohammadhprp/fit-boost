<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meal::create([
            'name' => 'Chicken Salad',
            'description' => 'A healthy salad with grilled chicken, mixed greens, and avocado.',
            'calories' => 350,
            'weekday' => 'AllDay',
        ]);

        Meal::create([
            'name' => 'Omelette',
            'description' => 'A classic breakfast dish with eggs, cheese, and vegetables.',
            'calories' => 300,
            'weekday' => 'Wednesday',
        ]);
    }
}
