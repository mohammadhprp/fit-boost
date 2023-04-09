<?php

namespace Tests\Feature\Api;

use App\Enums\WorkoutLevel;
use App\Models\User;
use App\Models\UserWorkout;
use App\Models\UserWorkoutItem;
use App\Models\Workout;
use App\Models\WorkoutProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutProgressTest extends TestCase
{

    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_get_user_workouts_progress(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/workout/progress");

        $response->assertStatus(200);
    }

    public function test_create_user_workout_progress(): void
    {
        $user_workout = $this->create_workout();
        $data = [
            'user_workout_id' => $user_workout->id,
            'title' => 'Day 1',
            'description' => 'Testing User workout progress',
            'started_at' => now(),
            'ended_at' => now()->addMinutes(65)
        ];

        $response = $this->actingAs($this->user)
            ->postJson(
                "/{$this->apiRoute}/user/workout/progress",
                $data,
            );

        $response->assertStatus(201);

        $this->assertDatabaseHas(WorkoutProgress::class, $data);
    }

    public function test_get_user_workout_progress(): void
    {
        $this->create_workout_progress();

        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/workout/progress/1");

        $response->assertStatus(200);
    }

    public function test_update_user_workout_progress(): void
    {
        $this->create_workout_progress();

        $data = [
            'title' => 'Day 1 - update',
            'description' => 'Testing User workout progress',
            'started_at' => now(),
            'ended_at' => now()->addMinutes(65)
        ];

        $response = $this->actingAs($this->user)
            ->putJson(
                "/{$this->apiRoute}/user/workout/progress/1",
                $data,
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas(WorkoutProgress::class, $data);
    }

    public function test_delete_user_workout_progress()
    {
        $this->create_workout_progress();

        $response = $this->actingAs($this->user)
            ->deleteJson("/{$this->apiRoute}/user/workout/progress/1");

        $response->assertStatus(204);
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

        return $user_workout;
    }

    private function create_workout_progress()
    {
        $user_workout = $this->create_workout();

        $data = [
            'user_workout_id' => $user_workout->id,
            'title' => 'Day 1',
            'description' => 'Testing User workout progress',
            'started_at' => now(),
            'ended_at' => now()->addMinutes(65)
        ];

        WorkoutProgress::create($data);

        return $data;
    }


}
