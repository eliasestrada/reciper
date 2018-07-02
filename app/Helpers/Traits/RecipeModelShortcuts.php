<?php

namespace App\Helpers\Traits;

trait RecipeModelShortcuts
{
	/**
	 * @return string
	 */
	public function getTitle() : ? string
	{
		return $this->toArray()['title_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getIngredients() : ? string
	{
		return $this->toArray()['ingredients_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getIntro() : ? string
	{
		return $this->toArray()['intro_' . locale()];
	}

	/**
	 * @return string
	 */
	public function getText() : ? string
	{
		return $this->toArray()['text_' . locale()];
	}

	/**
	 * @return string
	 */
	public function ready() : string
	{
		return $this->toArray()['ready_' . locale()];
	}

	/**
	 * @return string
	 */
	public function approved() : string
	{
		return $this->toArray()['approved_' . locale()];
	}

	/**
	 * @return bool
	 */
	public function done() : bool
	{
		return ($this->ready() && $this->approved()) ? true : false;
	}

	/**
	 * @return string
	 */
	public function getStatus() : string
	{
		if ($this->approved()) {
			return trans('users.checked');
		} elseif (!$this->ready()) {
			return trans('users.not_ready');
		} else {
			return trans('users.not_checked');
		}
	}
}
