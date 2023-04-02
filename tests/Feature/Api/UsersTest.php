<?php

namespace Tests\Feature;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    public function test_create_user()
    {
        $this->assertDatabaseHas(User::class, [
            'id' => $this->user->id
        ]);
    }

    public function test_get_user()
    {
        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/profile");

        $response->assertStatus(200);
    }

    public function test_update_user()
    {
        $data = [
            'first_name' => 'user',
            'last_name' => 'updated',
        ];

        $response = $this->actingAs($this->user)
            ->putJson(
                "/{$this->apiRoute}/user/profile",
                $data
            );

        $response->assertStatus(200);
        $this->assertDatabaseHas(User::class, $data);
    }

    private function createUser()
    {
        return User::factory()->create();
    }
}
