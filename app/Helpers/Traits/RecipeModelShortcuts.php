<?php

namespace App\Helpers\Traits;

trait RecipeModelShortcuts
{
    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->toArray()['title_' . lang()];
    }

    /**
     * @return string
     */
    public function getIngredients(): ?string
    {
        return $this->toArray()['ingredients_' . lang()];
    }

    /**
     * @return string
     */
    public function getIntro(): ?string
    {
        return $this->toArray()['intro_' . lang()];
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->toArray()['text_' . lang()];
    }

    /**
     * @return string
     */
    public function ready(): string
    {
        return $this->toArray()['ready_' . lang()];
    }

    /**
     * @return string
     */
    public function approved(): string
    {
        return $this->toArray()['approved_' . lang()];
    }

    /**
     * @return bool
     */
    public function done(): bool
    {
        return ($this->ready() && $this->approved()) ? true : false;
    }

    /**
     * @return string
     */
    public function getStatus(string $icon = null): string
    {
        if ($this->approved() && $this->ready()) {
            return $icon ? 'check' : trans('users.checked');
        } elseif (!$this->ready()) {
            return $icon ? 'create' : trans('users.not_ready');
        } else {
            return $icon ? 'cancel' : trans('users.not_checked');
        }
    }
}
