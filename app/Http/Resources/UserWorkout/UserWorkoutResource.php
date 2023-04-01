<?php

namespace App\Http\Resources\UserWorkout;

use App\Http\Resources\DateTime\DateResource;
use App\Http\Resources\DateTime\DateTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWorkoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'items' => UserWorkoutItemResource::collection($this->items),
            'start_at' => DateResource::make($this->start_at),
            'end_at' => DateResource::make($this->end_at),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
