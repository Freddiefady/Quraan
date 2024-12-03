<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'media' =>is_object($this->image) ? new ImagesResource($this->image) : ['path' => $this->image],
            'status' => $this->status(),
            // 'content_article' => $this->content,
            'publisher'=>$this->user_id == null ?  new AdminResource($this->admin) : new UserResource($this->user),
        ];
        if ($request->is('api/dashboard/articles/*')){
            $data['content_article'] = $this->content;
            $data['satisfied'] = $this->satisfied == 0 ? true : false;
            $data['publisher']= $this->AdminResource::collection($this->admin);
        }
        return $data;
    }
}
