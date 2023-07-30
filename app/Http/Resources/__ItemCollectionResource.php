<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemCollectionResource extends ResourceCollection
{

    public function toArray($request)
    {

        return [
              'data' => \App\Http\Resources\ItemResource::collection($this->collection),
          //     'pagination' => [
          //     'total' => $this->total(),
          //     'count' => $this->count(),
          //     'current_page' => $this->currentPage(),
          //     'per_page' => $this->perPage(),
          //     'total_pages' => $this->lastPage()
          // ],
        ];
    }
}
