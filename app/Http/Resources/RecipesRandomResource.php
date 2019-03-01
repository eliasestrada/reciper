<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipesRandomResource extends JsonResource
{
    /**
     * Transform the resource into an array
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->resource->getTitle(),
            'image' => $this->image,
        ];
    }
}
