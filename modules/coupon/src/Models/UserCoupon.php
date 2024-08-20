<?php

namespace Modules\Coupon\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Coupon\Models\Enums\CouponType;

class UserCoupon extends Pivot
{
    protected $casts = [
        'coupon_type' => CouponType::class,
        'validity_start_time' => 'date',
        'validity_end_time' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('coupon.relation.user_model'), 'user_union_id', config('coupon.relation.user_union_id_column'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * @return array
     */
    public function discountedPrice($price)
    {
        if (! is_null($this->used_at) || $price < $this->amount_limit) {
            return [
                'origin_price' => $price,
                'discounted_price' => $price,
            ];
        }

        $this->used();

        return [
            'origin_price' => $price,
            'discounted_price' => $this->coupon_type->discountedPrice($price, $this->free_fee, $this->discount),
        ];
    }

    /**
     * @return bool
     */
    public function used()
    {
        $this->used_at = now();

        return $this->save();
    }

    public function scopeFilterUserAndCoupon(Builder $query, $userUnionId = null, $couponId = null)
    {
        return $query->when($userUnionId, function ($query) use ($userUnionId) {
            return $query->where('user_union_id', $userUnionId);
        })->when($couponId, function ($query) use ($couponId) {
            return $query->where('coupon_id', $couponId);
        });
    }
}
