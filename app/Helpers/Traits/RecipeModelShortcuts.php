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
    public function isReady(): string
    {
        return $this->toArray()['ready_' . lang()];
    }

    /**
     * @return string
     */
    public function isApproved(): string
    {
        return $this->toArray()['approved_' . lang()];
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return ($this->isReady() && $this->isApproved()) ? true : false;
    }

    /**
     * @return string
     */
    public function getStatus(string $icon = null): string
    {
        if ($this->isApproved() && $this->isReady()) {
            return $icon ? 'check' : trans('users.checked');
        } elseif (!$this->isReady()) {
            return $icon ? 'create' : trans('users.not_ready');
        } else {
            return $icon ? 'cancel' : trans('users.not_checked');
        }
    }
}
