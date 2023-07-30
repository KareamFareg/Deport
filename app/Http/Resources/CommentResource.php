<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'main_parent_id' => $this->main_parent_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'user_image' => $this->user->imagePath(),
            'comment' => $this->comment,
            'created_at' =>  $this->created_at,
            'childs_count' => $this->childs_count,
            'ip' => $this->ip,
            'approved' => $this->approved,
            'mention_user_id' => $this->mention_user_id,
            'mention_user_name' => $this->mention_user_name,
        ];
    }


}
