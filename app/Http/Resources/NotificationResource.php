<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'user_sender_id' => $this->user_sender_id,
            'user_sender_name' => $this->user_sender ?  $this->user_sender->name : null,
            'user_sender_image' => $this->user_sender ?  $this->user_sender->image : null,
            'user_reciever_id' => $this->user_reciever_id,
            //'item_type' => optional($this->item_type)->id,
            'item_id' => $this->table_id,
            'data' => __('messages.'.$this->data,$this->params),
            'title' => __('messages.'.$this->title,$this->params),
            'link' => $this->link,
            'type' => $this->type,
            'read_at' => $this->read_at,
            'order_status' => $this->order_status,
            'created_at' => $this->created_at,
        ];
    }


}
