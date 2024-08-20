<?php

namespace App\Models\Enums;

enum AttrType: string
{
    case string = 'string';

    case integer = 'integer';

    case date = 'date';

    case datetime = 'datetime';

    public static function getOptions()
    {
        return collect([
            self::string->value => __('String'),
            self::integer->value => __('Integer'),
            self::date->value => __('Date'),
            self::datetime->value => __('DateTime'),
        ]);
    }
}
