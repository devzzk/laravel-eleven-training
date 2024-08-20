<?php

namespace Modules\Coupon\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Coupon\Models\Enums\FailureType;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'validity_start_time' => 'datetime',
        'validity_end_time' => 'datetime',
        'failure_type' => Enums\FailureType::class,
        'coupon_type' => Enums\CouponType::class,
        'additional' => 'json',
    ];

    public function users()
    {
        return $this->belongsToMany(
            related: config('coupon.relation.user_model'),
            table: 'user_coupon',
            foreignPivotKey: 'coupon_id',
            relatedPivotKey: 'user_union_id',
            relatedKey: config('coupon.relation.user_union_id_column')
        )->withPivot([
            'validity_start_time', 'validity_end_time', 'coupon_type', 'free_fee', 'discount', 'product', 'code', 'amount_limit',
        ])->withTimestamps()
            ->using(UserCoupon::class);
    }

    public function redeem()
    {
        return $this->hasOne(CouponRedeem::class);
    }

    /**
     * @return \Illuminate\Support\Carbon|mixed
     */
    public function getStartTime()
    {
        if ($this->failure_type === FailureType::fixedDate) {
            return $this->validity_start_time;
        }

        return now()->addDays($this->effective_days);
    }

    /**
     * @return \Illuminate\Support\Carbon|mixed
     */
    public function getEndTime()
    {
        if ($this->failure_type === FailureType::fixedDate) {
            return $this->validity_end_time;
        }

        return now()->addDays($this->effective_days)->addDays($this->validity_days);
    }

    /**
     * 判断用户领取的券是否超出数量
     */
    public function canGiveUser($userId): bool
    {
        return $this->users()->where('user_coupon.user_union_id', $userId)->count() < $this->draw_limit;
    }
}
