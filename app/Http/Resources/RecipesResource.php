<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipesResource extends JsonResource
{
    // Transform the resource into an array.
    public function toArray($request)
    {
        return [
			'id' => $this->id,
			'title' => $this->resource->toArray()['title_'.locale()],
			'image' => $this->image
		];
    }
}
