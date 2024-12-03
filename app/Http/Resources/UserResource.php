<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->name,
            'email' => $this->email,
            'user_image' => ImagesResource::collection($this->images),
            'status' =>$this->status(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
