<?php

namespace Database\Seeders;

use App\Enums\WorkoutLevel;
use App\Models\Meal;
use App\Models\Plan;
use App\Models\PlanItem;
use App\Models\PlanType;
use App\Models\Workout;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan_1 = Plan::create([
            'user_id' => 1,
            'plan_type_id' => PlanType::WORKOUT,
            'title' => 'Week 1',
            'start_at' => now(),
            'end_at' => now()->addDays(7),
        ]);


        PlanItem::create([
            'plan_id' => $plan_1->id,
            'plan_itemable_type' => Workout::class,
            'plan_itemable_id' => 1,
        ]);

        PlanItem::create([
            'plan_id' => $plan_1->id,
            'plan_itemable_type' => Workout::class,
            'plan_itemable_id' => 2,
        ]);


        $plan_2 = Plan::create([
            'user_id' => 1,
            'plan_type_id' => PlanType::MEAL,
            'title' => 'Month 1',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);


        PlanItem::create([
            'plan_id' => $plan_2->id,
            'plan_itemable_type' => Meal::class,
            'plan_itemable_id' => 1,
        ]);

        PlanItem::create([
            'plan_id' => $plan_2->id,
            'plan_itemable_type' => Meal::class,
            'plan_itemable_id' => 2,
        ]);
    }
}
