<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class itemResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'type_id' => $this->type_id,
            'type' => $this->item_type->title,
            'adv_period_id' => $this->adv_period_id,
            'description' => !$this->item_info->isEmpty() ? $this->item_info->first()->description : null,
            'links' => $this->links,
            'created_at' => $this->created_at,
            'comments_count' => $this->comments,
            'likes_count' => $this->likes,
            'views_count' => $this->views,
            'liked_by_user' => !$this->liked->isEmpty() ? true : false,
            'images' => \App\Http\Resources\FileResource::collection($this->files),
            'user_id' => $this->user->id,
            'user_image' => $this->user->imagePath(),
            'user_name' =>  $this->user->name,
            'user_created_at' =>  $this->user->created_at,
            'is_active' => $this->is_active,
        ];
    }


}
