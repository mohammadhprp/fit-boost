<?php

namespace App\Http\Resources\Reminder\UserWorkout;

use App\Http\Resources\DateTime\DateTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class UserWorkoutReminderResource extends JsonResource
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
            'description' => $this->description,
            'remind_at' => DateTimeResource::make($this->remind_at),
            'is_completed' => $this->is_completed,
            'created_at' => DateTimeResource::make($this->created_at)
        ];
    }
}
