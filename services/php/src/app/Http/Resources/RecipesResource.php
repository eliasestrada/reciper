<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipesResource extends JsonResource
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
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->resource->getTitle(),
            'intro' => $this->resource->getIntro(),
            'time' => $this->time,
            'image' => $this->image,
        ];
    }
}
