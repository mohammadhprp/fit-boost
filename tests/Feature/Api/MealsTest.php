<?php

namespace Tests\Feature\Api;

use App\Models\Meal;
use App\Models\User;
use App\Models\UserMeal;
use App\Models\UserMealItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MealsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->create_meal();
    }

    public function test_get_user_meals(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/meals");

        $response->assertStatus(200);

        $this->assertDatabaseHas(UserMeal::class,
            ['user_id' => $this->user->id]
        );

        $response->assertJson(['title' > '1st Month']);
    }

    public function test_unauthorized_user_can_not_get_meals(): void
    {
        $response = $this->getJson("/{$this->apiRoute}/user/meals");

        $response->assertStatus(401);
    }

    public function test_get_user_workout(): void
    {
        $response = $this->actingAs($this->user)
            ->getJson("/{$this->apiRoute}/user/meals/1");

        $response->assertStatus(200);

        $this->assertDatabaseHas(UserMeal::class,
            ['user_id' => $this->user->id]
        );
    }

    private function create_meal()
    {
        $meal = Meal::create([
            'name' => 'Chicken Salad',
            'description' => 'A healthy salad with grilled chicken, mixed greens, and avocado.',
            'calories' => 350,
            'weekday' => 'AllDay',
        ]);

        $user_meal = UserMeal::create([
            'user_id' => $this->user->id,
            'title' => '1st Month',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        UserMealItem::create([
            'user_meal_id' => $user_meal->id,
            'meal_id' => $meal->id,
        ]);

        UserMealItem::create([
            'user_meal_id' => $user_meal->id,
            'meal_id' => $meal->id,
        ]);
    }

}
