<?php

namespace Modules\Coupon\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Coupon\Events\CouponSendFinished;
use Modules\Coupon\Events\CouponSending;
use Modules\Coupon\Events\ShouldSendCoupon;
use Modules\Coupon\Listeners\SendCoupon;

class CouponServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/coupon.php' => config_path('coupon.php'),
        ], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/coupon.php', 'coupon');

        Event::listen(ShouldSendCoupon::class, SendCoupon::class);

        Event::listen(CouponSending::class, config('coupon.listener.sending'));

        Event::listen(CouponSendFinished::class, config('coupon.listener.sent'));
    }
}
