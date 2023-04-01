<?php

namespace Database\Seeders;

use App\Models\UserWorkout;
use App\Models\UserWorkoutItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserWorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workout = UserWorkout::create([
            'user_id' => 1,
            'title' => '1st Week',
            'start_at' => now(),
            'end_at' => now()->addDays(7),
        ]);

        UserWorkoutItem::create([
            'user_workout_id' => $workout->id,
            'workout_id' => 1
        ]);

        UserWorkoutItem::create([
            'user_workout_id' => $workout->id,
            'workout_id' => 2
        ]);
    }
}
