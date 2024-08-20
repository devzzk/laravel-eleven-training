<?php

namespace Modules\Coupon\Listeners;

use Modules\Coupon\Events\ShouldSendCoupon;

class SendCoupon
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ShouldSendCoupon $event): void
    {
        \Modules\Coupon\Job\SendCoupon::dispatch($event->getUserUnionId(), $event->getCouponId());
    }
}
