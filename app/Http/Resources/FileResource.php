<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'type_id' => $this->file_type_id,
            'file_name' => $this->filePath(),
            'is_active' => $this->is_active,
        ];
    }
}
