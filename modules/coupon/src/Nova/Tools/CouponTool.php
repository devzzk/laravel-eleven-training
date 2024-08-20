<?php

namespace Modules\Coupon\Nova\Tools;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Modules\Coupon\Nova\Coupon;
use Modules\Coupon\Nova\CouponRedeem;

class CouponTool extends Tool
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        Nova::resources([
            Coupon::class,
            CouponRedeem::class,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function menu(Request $request)
    {
        return MenuSection::resource(Coupon::class);
    }
}
