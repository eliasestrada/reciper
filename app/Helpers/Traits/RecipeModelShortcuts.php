<?php

namespace App\Helpers\Traits;

trait RecipeModelShortcuts
{
	/**
	 * @return string
	 */
	public function getTitle() : string
	{
		return $this->toArray()['title_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getIngredients() : string
	{
		return $this->toArray()['ingredients_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getIntro() : string
	{
		return $this->toArray()['intro_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getText() : string
	{
		return $this->toArray()['text_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getReady() : string
	{
		return $this->toArray()['ready_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getApproved() : string
	{
		return $this->toArray()['approved_' . locale()];
	}
}
