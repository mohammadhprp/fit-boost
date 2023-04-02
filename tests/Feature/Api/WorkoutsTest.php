<?php

namespace Tests\Feature\Api;

use App\Enums\WorkoutLevel;
use App\Models\User;
use App\Models\UserWorkout;
use App\Models\UserWorkoutItem;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->create_workout();
    }

    public function test_get_user_workouts(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/workouts");

        $response->assertStatus(200);

        $this->assertDatabaseHas(UserWorkout::class,
            ['user_id' => $this->user->id]
        );

        $response->assertJson(["title" > "1st Week"]);
    }

    public function test_unauthorized_user_can_not_get_workouts(): void
    {
        $response = $this->getJson("/{$this->apiRoute}/user/workouts");

        $response->assertStatus(401);
    }

    public function test_get_user_workout(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/workouts/1");

        $response->assertStatus(200);

        $this->assertDatabaseHas(UserWorkout::class,
            ['user_id' => $this->user->id]
        );
    }


    private function create_workout()
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
    }
}
