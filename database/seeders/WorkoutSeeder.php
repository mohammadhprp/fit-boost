<?php

namespace Database\Seeders;

use App\Enums\WorkoutLevel;
use App\Models\Workout;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Workout::create([
            'name' => 'Bench Press',
            'description' => 'A classic chest exercise using a barbell.',
            'raps' => 10,
            'sets' => 3,
            'weekday' => 'Monday',
            'level' => WorkoutLevel::Intermediate,
        ]);

        Workout::create([
            'name' => 'Squats',
            'description' => 'A lower body exercise using a barbell.',
            'raps' => 12,
            'sets' => 4,
            'weekday' => 'Wednesday',
            'level' => WorkoutLevel::Advanced,
        ]);
    }
}
