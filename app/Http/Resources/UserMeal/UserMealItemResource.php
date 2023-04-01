<?php

namespace App\Http\Resources\UserMeal;

use App\Http\Resources\Meal\MealResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMealItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meal' => MealResource::make($this->meal),
        ];
    }
}
