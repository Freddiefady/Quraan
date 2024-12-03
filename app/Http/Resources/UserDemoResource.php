<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDemoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email_user'=>$this->email,
            'phone_number'=>$this->phone,
            'country'=>$this->country,
            'city'=>$this->city,
            'the_cycle'=>$this->the_cycle,
            'favorites_days'=>$this->favorites_days,
            'favorites_time'=>$this->favorites_time,
            'age'=>$this->age,
            'student_gender'=>$this->student_gender,
            'teacher_gender'=>$this->teacher_gender,
            'message'=>$this->message,
            'date'=>$this->created_at->format('Y-m-d h:m a'),
        ];
    }
}
