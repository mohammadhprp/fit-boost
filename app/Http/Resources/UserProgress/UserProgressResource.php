<?php

namespace App\Http\Resources\UserProgress;

use App\Http\Resources\DateTime\DateTimeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProgressResource extends JsonResource
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
            'weight' => $this->weight,
            'height' => $this->height,
            'body_fat' => $this->body_fat,
            'notes' => $this->notes,
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
