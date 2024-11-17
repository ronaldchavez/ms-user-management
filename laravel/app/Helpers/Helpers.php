<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helpers
{
    public static function calculateAge(string $birthDate): int
    {
        return Carbon::parse($birthDate)->age;
    }

}