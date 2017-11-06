<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRepository implements Rule
{
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value == null) {
            return true;
        }

        return in_array($value, config('issues.repositories'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The repository must in the available repositories';
    }
}
