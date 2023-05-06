<?php

namespace Tests\Feature\Api;

use App\Enums\WorkoutLevel;
use App\Models\Reminder;
use App\Models\User;
use App\Models\UserWorkout;
use App\Models\UserWorkoutItem;
use App\Models\Workout;
use App\Models\WorkoutProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserWorkoutReminderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_get_all_user_workout_reminders(): void
    {
        $workout = $this->create_workout();

        $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/$this->apiRoute/user/userWorkout/{$workout->id}/reminder");

        $response->assertStatus(200);
    }

    public function test_create_user_workout_reminder(): void
    {
        $workout = $this->create_workout();

        $data = [
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ];

        $response = $this->actingAs($this->user)
            ->postJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder",
                $data
            );

        $response->assertStatus(201);
    }

    public function test_get_user_workout_reminder_detail(): void
    {
        $workout = $this->create_workout();

        $reminder = $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder/{$reminder->id}"
            );

        $response->assertStatus(200);
    }

    public function test_user_can_not_see_other_user_reminders(): void
    {
        $workout = $this->create_workout();

        $reminder = $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->getJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder/{$reminder->id}"
            );

        $response->assertStatus(404);
    }

    public function test_update_user_workout_reminder(): void
    {
        $workout = $this->create_workout();

        $reminder = $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);


        $response = $this->actingAs($this->user)
            ->putJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder/{$reminder->id}",
                [
                    'title' => fake()->name,
                    'description' => fake()->text,
                    'remind_at' => fake()->date,
                    'is_completed' => fake()->boolean,
                ]
            );

        $response->assertStatus(200);
    }

    public function test_user_can_not_update_other_workout_reminder(): void
    {
        $workout = $this->create_workout();

        $reminder = $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->putJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder/{$reminder->id}",
                [
                    'title' => fake()->name,
                    'description' => fake()->text,
                    'remind_at' => fake()->date,
                    'is_completed' => fake()->boolean,
                ]
            );

        $response->assertStatus(404);
    }

    public function test_delete_user_workout_reminder(): void
    {
        $workout = $this->create_workout();

        $reminder = $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder/{$reminder->id}"
            );

        $response->assertStatus(204);
    }

    public function test_user_can_not_delete_another_user_workout_reminder(): void
    {
        $workout = $this->create_workout();

        $reminder = $workout->reminders()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'remind_at' => fake()->date,
        ]);

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->deleteJson(
                "/$this->apiRoute/user/userWorkout/{$workout->id}/reminder/{$reminder->id}"
            );

        $response->assertStatus(404);
    }

    private function create_workout(): UserWorkout
    {
        $workout = Workout::create([
            'name' => 'Bench Press',
            'description' => 'A classic chest exercise using a barbell.',
            'raps' => 10,
            'sets' => 3,
            'weekday' => 'Monday',
            'level' => WorkoutLevel::Intermediate,
        ]);

        $user_workout = UserWorkout::create([
            'user_id' => $this->user->id,
            'title' => '1st Week',
            'start_at' => now(),
            'end_at' => now()->addDays(7),
        ]);

        UserWorkoutItem::create([
            'user_workout_id' => $user_workout->id,
            'workout_id' => $workout->id,
        ]);

        return $user_workout;
    }
}
