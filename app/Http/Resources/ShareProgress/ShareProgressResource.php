<?php

namespace App\Http\Resources\ShareProgress;

use App\Http\Resources\DateTime\DateTimeResource;
use App\Http\Resources\UserProgress\UserProgressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShareProgressResource extends JsonResource
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
            'user_progress' => UserProgressResource::make($this->progress),
            'url' => config('app.url') . '/' . $this->url,
            'notes' => $this->notes,
            'visits_count' => $this->visits->count(),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
