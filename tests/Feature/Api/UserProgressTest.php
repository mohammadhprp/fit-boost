<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProgressTest extends TestCase
{

    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_get_user_progress()
    {
        $this->create_progress();

        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/progress");

        $response->assertStatus(200);
    }

    public function test_create_user_progress(): void
    {
        $data = [
            'weight' => 81.5,
            'height' => 173,
            'body_fat' => 23.1,
            'notes' => 'Day 1/50'
        ];

        $response = $this->actingAs($this->user)
            ->postJson(
                "/{$this->apiRoute}/user/progress",
                $data,
            );

        $response->assertStatus(201);

        $this->assertDatabaseHas(UserProgress::class, $data);
    }

    public function test_get_user_progress_detail(): void
    {
        $this->create_progress();

        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/progress/1");

        $response->assertStatus(200);
    }

    public function test_update_user_progress(): void
    {
        $this->create_progress();

        $data = [
            'notes' => 'Day 1/50 - Update'
        ];

        $response = $this->actingAs($this->user)
            ->putJson(
                "/{$this->apiRoute}/user/progress/1",
                $data,
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas(UserProgress::class, $data);
    }

    public function test_delete_user_workout_progress()
    {
        $this->create_progress();

        $response = $this->actingAs($this->user)
            ->deleteJson("/{$this->apiRoute}/user/progress/1");

        $response->assertStatus(204);
    }

    public function test_user_can_not_create_progress_with_invalid_data(): void
    {
        $data = [
            'weight' => 'invalid weight',
            'height' => 173,
            'body_fat' => 23.1,
            'notes' => 'Day 1/50'
        ];

        $response = $this->actingAs($this->user)
            ->postJson(
                "/{$this->apiRoute}/user/progress",
                $data,
            );

        $response->assertStatus(422);
    }


    public function test_user_can_not_get_progress_not_owned()
    {
        $progress = $this->create_progress();

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->getJson("/{$this->apiRoute}/user/progress/{$progress->id}");

        $response->assertStatus(404);
    }

    private function create_progress(): UserProgress
    {
        $data = [
            'user_id' => $this->user->id,
            'weight' => 81.5,
            'height' => 173,
            'body_fat' => 23.1,
            'notes' => 'Day 1/50'
        ];

        return UserProgress::create($data);
    }
}
