<?php

namespace App\Http\Resources\UserWorkout;

use App\Http\Resources\Workout\WorkoutResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWorkoutItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'workout' => WorkoutResource::make($this->workout)
        ];
    }
}
