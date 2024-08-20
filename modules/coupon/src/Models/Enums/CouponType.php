<?php

namespace Modules\Coupon\Models\Enums;

enum CouponType: int
{
    case vouchers = 0; // 代金券
    case exchange = 1; // 兑换券
    case discount = 2; // 折扣券

    public static function getOptions()
    {
        return collect([
            self::vouchers->value => __('代金券'),
            self::exchange->value => __('兑换券'),
            self::discount->value => __('折扣券'),
        ]);
    }

    public function discountedPrice($originPrice, $freeFee, $discount)
    {
        return match ($this) {
            self::vouchers => $originPrice - $freeFee,
            self::discount => $originPrice * $discount,
        };
    }
}
