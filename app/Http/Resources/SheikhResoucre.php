<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SheikhResoucre extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => asset($this->image),
            'title' => $this->title,
            'experience' => $this->created_at->diffForHumans(),
            'description' => $this->description,
        ];
        if ($request->is('api/teacher/show/*')) {
            $data['email'] = $this->email;
            $data['phone'] = $this->phone;
            $data['age'] = $this->age;
            $data['gender'] = $this->gender;
            $data['level_of_english'] = $this->level_of_english;
            $data['education'] = $this->education;
            $data['links'] = $this->links;
            $data['recommendations'] = $this->recommendations;
            $data['time_available'] = $this->time_available;
            $data['cv'] = asset($this->cv);
            $data['date']= $this->created_at->format('Y-m-d h:m a');
        }
        return $data;
    }
}
