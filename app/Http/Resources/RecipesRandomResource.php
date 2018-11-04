<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipesRandomResource extends JsonResource
{
    // Transform the resource into an array.
    public function toArray($request)
    {
        return [
            'slug' => $this->slug,
            'title' => $this->resource->getTitle(),
            'image' => $this->image,
        ];
    }
}
