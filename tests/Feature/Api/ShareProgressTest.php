<?php

namespace Tests\Feature\Api;

use App\Models\ShareProgress;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShareProgressTest extends TestCase
{

    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_get_user_share_progress()
    {
        $this->create_share();

        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/share");

        $response->assertStatus(200);
    }

    public function test_create_user_share_progress(): void
    {
        $data = [
            'user_progress_id' => $this->create_progress()->id,
            'title' => 'Checkout my day one workout',
            'notes' => 'Day 1/50'
        ];

        $response = $this->actingAs($this->user)
            ->postJson(
                "/{$this->apiRoute}/user/share",
                $data,
            );

        $response->assertStatus(201);

        $this->assertDatabaseHas(ShareProgress::class, $data);
    }

    public function test_get_user_share_progress_detail(): void
    {
        $this->create_share();

        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/share/1");

        $response->assertStatus(200);
    }

    public function test_update_user_share_progress(): void
    {
        $this->create_share();

        $data = [
            'notes' => 'Day 1/50 - Update'
        ];

        $response = $this->actingAs($this->user)
            ->putJson(
                "/{$this->apiRoute}/user/share/1",
                $data,
            );

        $response->assertStatus(200);

        $this->assertDatabaseHas(ShareProgress::class, $data);
    }

    public function test_delete_user_share_progress()
    {
        $this->create_share();

        $response = $this->actingAs($this->user)
            ->deleteJson("/{$this->apiRoute}/user/share/1");

        $response->assertStatus(204);
    }

    public function test_user_can_not_create_share_progress_with_invalid_data(): void
    {
        $data = [
            'title' => 'Checkout my day one workout',
            'notes' => 'Day 1/50'
        ];

        $response = $this->actingAs($this->user)
            ->postJson(
                "/{$this->apiRoute}/user/share",
                $data,
            );

        $response->assertStatus(422);
    }


    public function test_user_can_not_get_share_progress_not_owned()
    {
        $share = $this->create_share();

        $another_user = User::factory()->create();

        $response = $this->actingAs($another_user)
            ->getJson("/{$this->apiRoute}/user/share/{$share->id}");

        $response->assertStatus(404);
    }

    private function create_share(): ShareProgress
    {
        $data = [
            'user_id' => $this->user->id,
            'user_progress_id' => $this->create_progress()->id,
            'title' => 'Checkout my day one workout',
            'notes' => 'Day 1/50'
        ];

        return ShareProgress::create($data);
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
