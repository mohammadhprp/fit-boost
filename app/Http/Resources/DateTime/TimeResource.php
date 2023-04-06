<?php

namespace App\Http\Resources\DateTime;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'time' => $this->format('H:i'),
            'timezone' => $this->getTimezone()
        ];
    }
}
