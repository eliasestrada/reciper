<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipesRandomResource extends JsonResource
{
    // Transform the resource into an array.
    public function toArray($request)
    {
		if (locale() === 'ru') {
			$title = $this->title_ru;
		} elseif (locale() === 'en') {
			$title = $this->title_en;
		}

        return [
			'id' => $this->id,
			'title' => $title,
			'image' => $this->image
		];
    }
}
