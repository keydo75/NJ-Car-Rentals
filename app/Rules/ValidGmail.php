<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidGmail implements Rule
{
    public function passes($attribute, $value)
    {
        // Allow any valid email address (not just Gmail)
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function message()
    {
        return 'Please enter a valid email address.';
    }
}
