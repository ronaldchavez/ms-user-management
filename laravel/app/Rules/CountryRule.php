<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CountryRule implements Rule
{
    protected $countries = [
        'Venezuela', 'Colombia', 'Peru', 'United States', 'Canada', 'Mexico', 'Argentina', 'Brazil', 'Spain', 'France',
    ];

    public function passes($attribute, $value)
    {
        return in_array($value, $this->countries);
    }

    public function message()
    {
        return 'The selected country is not valid.';
    }
}