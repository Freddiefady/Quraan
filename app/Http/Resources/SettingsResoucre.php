<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResoucre extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'site_name'=>$this->site_name,
            'favicon'=>asset($this->favicon),
            'logo'=>asset($this->logo),
            'email'=>$this->email,
            'facebook'=>$this->facebook,
            'youtube'=>$this->youtube,
            'phone'=>$this->phone,
            'country'=>$this->country,
            'city'=>$this->city,
            'street'=>$this->street,
            'location'=>$this->street. ', ' .$this->city. ', ' .$this->country,
        ];
    }
}
