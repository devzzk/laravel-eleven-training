<?php

namespace App\Models\Enums;

enum Gender: int
{
    case unknown = 0;

    case male = 1;

    case female = 2;

    public static function getOptions()
    {
        return collect([
            self::unknown->value => __('Unknown'),
            self::male->value => __('Male'),
            self::female->value => __('Female'),
        ]);
    }
}
