<?php

namespace Modules\Coupon\Http\Controllers;

use Modules\Coupon\Http\Requests\DrawCouponRequest;
use Modules\Coupon\Http\Requests\UserCouponsRequest;
use Modules\Coupon\Models\Coupon;

class CouponController extends Controller
{
    /**
     * @param DrawCouponRequest $request
     * @param Coupon $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function drawCoupon(DrawCouponRequest $request, Coupon $coupon)
    {
        return response()->json([
            'result' => 'success',
            'code' => 200,
            'data' => $request->handle(),
        ]);
    }

    /**
     * @param UserCouponsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCoupons(UserCouponsRequest $request)
    {
        return response()->json([
            'result' => 'success',
            'code' => 200,
            'data' => $request->handle(),
        ]);
    }

    /**
     * @param Coupon $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Coupon $coupon)
    {
        return response()->json([
            'result' => 'success',
            'code' => 200,
            'data' => $coupon,
        ]);
    }
}
