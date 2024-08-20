<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Illuminate\Support\Carbon;

class NotEnoughCouponsException extends Exception
{
    protected $message = '优惠券数量不足，请联系管理员更新库存';

    /** The error code */
    protected $code = 400;

    public function render()
    {
        return response()->json([
            'desc' => $this->message,
            'code' => $this->code,
            'obj' => null,
            'timestamp' => Carbon::now()->getPreciseTimestamp(3),
        ]);
    }
}
