<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'type_id' => $this->type_id,
            // 'client_id' => $this->client_id,
            // 'parent_id' => $this->parent_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            //'description' => !$this->client->client_info->isEmpty() ? $this->client->client_info->first()->description : null,
            'gender' => $this->gender,
            'id_number' => $this->id_number,
            'image' => $this->imagePath(),
            'id_card' => asset('storage/app/'.$this->id_card),
            'license' => asset('storage/app/'.$this->license),
            //'banner' => $this->bannerPath(),
            'rate' => $this->rate,
            // 'address' => $this->address,
            'rate_count' => $this->rate_count,
            // 'is_available' => $this->is_available,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified , //\App\Http\Resources\UserOrderItem::collection($this->items),
            'unseen_notifications_count' => $this->unseen_notifications_count ?? 0,
            //'likes_count' => $this->likes_count ?? 0,
            // 'lat' => $this->lat,
            // 'lng' => $this->lng,
            // 'access_user_id' => $this->access_user_id,
            'ip' => $this->ip,
            'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // 'subscription_status' => $this->subscription_status,
            // 'subscription_end_date' => $this->subscription_end_date,
             'city' => $this->city,
             'area' => $this->area,
             'amount' => $this->amount,
             'approved' => $this->approved,
            // 'categories' => $this->categories,
            // 'files' => $this->files,
        ];
    }
}
