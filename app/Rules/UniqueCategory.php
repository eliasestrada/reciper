<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCategory implements Rule
{
    public function passes($attribute, $value)
    {
		if (count($value) === count(array_unique($value))) {
			return true;
		}
    }


    public function message()
    {
        return trans('recipes.categories_are_not_unique');
    }
}
