<?php

namespace App\Http\Resources\WorkoutProgress;

use App\Http\Resources\DateTime\DateResource;
use App\Http\Resources\DateTime\TimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkoutProgressResource extends JsonResource
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
            'title' => $this->title ?? 'workout #' . $this->id,
            'description' => $this->description ?? '',
            'started_at' => TimeResource::make($this->started_at),
            'ended_at' => TimeResource::make($this->ended_at),
        ];
    }
}
