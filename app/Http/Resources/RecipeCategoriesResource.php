<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeCategoriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
			'id' => $this->id,
			'name' => $this->resource->toArray()['name_'.locale()],
		];
    }
}