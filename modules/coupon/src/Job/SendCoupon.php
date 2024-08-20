<?php

namespace Modules\Coupon\Job;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Coupon\Events\CouponSendFinished;
use Modules\Coupon\Events\CouponSending;
use Modules\Coupon\Exceptions\NotEnoughCouponsException;
use Modules\Coupon\Models\Coupon;

class SendCoupon implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected mixed $userId,
        protected $couponId
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($this->couponId);

        event(new CouponSending($coupon, $this->userId));

        $userModel = config('coupon.relation.user_model');
        $userIdColumn = config('coupon.relation.user_union_id_column');

        $users = $userModel::whereIn($userIdColumn, $this->generaliUserIds())->get();

        $users->each(function ($user) use ($coupon, $userIdColumn) {
            if ($coupon->canGiveUser($user->{$userIdColumn})) {
                $this->sendCoupon($coupon, $user->{$userIdColumn});

                event(new CouponSendFinished($coupon, $user));
            }
        });

    }

    /**
     * @return void
     */
    protected function sendCoupon($coupon, $userId)
    {
        DB::transaction(function () use ($coupon, $userId) {

            if ($coupon->stock < 1) {
                throw new NotEnoughCouponsException;
            }

            $coupon->users()->attach($userId, [
                'validity_start_time' => $coupon->getStartTime(),
                'validity_end_time' => $coupon->getEndTime(),
                'coupon_type' => $coupon->coupon_type,
                'free_fee' => $coupon->free_fee,
                'discount' => $coupon->discount,
                'product' => $coupon->product,
                'code' => Str::ulid(),
                'amount_limit' => $coupon->amount_limit,
            ]);

            $coupon->decrement('stock');

        });

    }

    protected function generaliUserIds()
    {
        if (is_array($this->userId)) {
            return $this->userId;
        }
        if (is_numeric($this->userId)) {
            return [$this->userId];
        }
        if (is_string($this->userId)) {
            return explode(';', $this->userId);
        }

    }
}
