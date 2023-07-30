<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAlbumeResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'item_id' => $this->table_id,
            'id' => $this->id,
            'file_name' => asset( \App\Models\File::FILES_PATH . $this->file_name ),
        ];
    }
}
