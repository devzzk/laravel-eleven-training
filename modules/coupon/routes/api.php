<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\CouponController;

Route::prefix('vendor-api/v1/coupon')
    ->middleware(config('coupon.http.middleware.with_auth'))
    ->name('vendor.api.v1.with_auth.coupon.')
    ->group(function () {
        Route::post('/{coupon}/draw-coupon', [CouponController::class, 'drawCoupon'])->name('draw');
        Route::get('/user/coupons', [CouponController::class, 'userCoupons'])->name('user_coupons');
    });

Route::prefix('vendor-api/v1/coupon')
    ->middleware(config('coupon.http.middleware.without_auth'))
    ->name('vendor.api.v1.without_auth.coupon.')
    ->group(function () {
        Route::get('/{coupon}', [CouponController::class, 'detail'])->name('detail');
    });
