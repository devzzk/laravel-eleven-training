<?php

namespace Modules\Coupon\Models\Enums;

enum FailureType: int
{
    case fixedDate = 1;
    case relativeDate = 2;

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getOptions()
    {
        return collect([
            self::fixedDate->value => __('固定日期'),
            self::relativeDate->value => __('相对日期'),
        ]);
    }
}
