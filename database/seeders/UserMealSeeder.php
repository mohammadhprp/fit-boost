<?php

namespace Database\Seeders;

use App\Models\UserMeal;
use App\Models\UserMealItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meal = UserMeal::create([
            'user_id' => 1,
            'title' => '1st Month',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        UserMealItem::create([
            'user_meal_id' => $meal->id,
            'meal_id' => 1
        ]);

        UserMealItem::create([
            'user_meal_id' => $meal->id,
            'meal_id' => 2
        ]);
    }
}
