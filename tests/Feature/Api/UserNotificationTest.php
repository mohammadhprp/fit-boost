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

class UserNotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_get_all_user_notifications(): void
    {
        $user = $this->user;

        $user->notifications()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'notify_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)->getJson("/$this->apiRoute/user/notifications");

        $response->assertStatus(200);
    }

    public function test_create_user_notification(): void
    {

        $response = $this->actingAs($this->user)
            ->postJson(
                "/$this->apiRoute/user/notifications",
                [
                    'title' => fake()->name,
                    'description' => fake()->text,
                    'notify_at' => fake()->date,
                ]
            );

        $response->assertStatus(201);
    }

    public function test_get_user_notification_detail(): void
    {

        $user = $this->user;

        $notification = $user->notifications()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'notify_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(
                "/$this->apiRoute/user/notifications/{$notification->id}",
            );

        $response->assertStatus(200);
    }

    public function test_update_user_notification(): void
    {

        $user = $this->user;

        $notification = $user->notifications()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'notify_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)
            ->putJson(
                "/$this->apiRoute/user/notifications/{$notification->id}",
                [
                    'title' => fake()->name,
                    'description' => fake()->text,
                    'notify_at' => fake()->date,
                ]
            );

        $response->assertStatus(200);
    }

    public function test_update_user_notification_fails_with_invalid(): void
    {

        $user = $this->user;

        $notification = $user->notifications()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'notify_at' => fake()->date,
        ]);

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->putJson(
                "/$this->apiRoute/user/notifications/{$notification->id}",
                [
                    'title' => fake()->name,
                    'description' => fake()->text,
                    'notify_at' => fake()->date,
                ]
            );

        $response->assertStatus(403);
    }

    public function test_delete_user_notification(): void
    {

        $user = $this->user;

        $notification = $user->notifications()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'notify_at' => fake()->date,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson(
                "/$this->apiRoute/user/notifications/{$notification->id}",
            );

        $response->assertStatus(204);
    }
    public function test_delete_user_notification_fails_with_invalid_data(): void
    {

        $user = $this->user;

        $notification = $user->notifications()->create([
            'title' => fake()->name,
            'description' => fake()->text,
            'notify_at' => fake()->date,
        ]);

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->deleteJson(
                "/$this->apiRoute/user/notifications/{$notification->id}",
            );

        $response->assertStatus(403);
    }
}
