<?php

namespace Modules\Coupon\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class CouponRedeem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Modules\Coupon\Models\Coupon>
     */
    public static $model = \Modules\Coupon\Models\CouponRedeem::class;

    public static $displayInNavigation = false;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Boolean::make(__('线上核销'), 'redeem_online')
                ->default(false),

            Text::make(__('商品链接'), 'product_url'),

            Text::make(__('对应线上优惠券ID'), 'online_coupon_id'),

            Boolean::make(__('线下核销'), 'redeem_offline'),

            Text::make(__('对应线下优惠券ID'), 'offline_coupon_id'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }
}
