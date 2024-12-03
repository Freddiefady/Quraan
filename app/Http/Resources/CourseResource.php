<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'price' => $this->price,
                'media' => VideoResource::collection($this->video),
                // 'instructor' => new SheikhResoucre($this->sheikh),
                'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
