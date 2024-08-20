<?php

return [
    'relation' => [
        'user_model' => App\Models\User::class,
        'user_union_id_column' => 'id',
    ],

    'http' => [
        'middleware' => [
            'with_auth' => [
                'api',
                'auth',
            ],
            'without_auth' => [
                'api',
            ],
        ],
    ],

    'listener' => [

        // event = \Modules\Coupon\Events\CouponSending::class
        'sending' => [
            // do something before send coupon;
        ],

        // event = \Modules\Coupon\Events\CouponSendFinished::class
        'sent' => [
            // do something after send coupon;
        ],
    ],
];
