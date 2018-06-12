<?php

namespace App\Helpers\Traits;

trait RecipeModelShortcuts
{
	public function getTitle()
	{
		return $this->toArray()['title_' . locale()];
	}

	public function getIngredients()
	{
		return $this->toArray()['ingredients_' . locale()];
	}

	public function getIntro()
	{
		return $this->toArray()['intro_' . locale()];
	}

	public function getText()
	{
		return $this->toArray()['text_' . locale()];
	}

	public function getReady()
	{
		return $this->toArray()['ready_' . locale()];
	}

	public function getApproved()
	{
		return $this->toArray()['approved_' . locale()];
	}
}
