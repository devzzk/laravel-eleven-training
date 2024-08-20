<?php

namespace Modules\Coupon\Nova;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Modules\Coupon\Models\Enums\CouponType;
use Modules\Coupon\Models\Enums\FailureType;
use Modules\Coupon\Nova\Actions\SendCoupon;

class Coupon extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Modules\Coupon\Models\Coupon>
     */
    public static $model = \Modules\Coupon\Models\Coupon::class;

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
    public static $search = [
        'id', 'name', 'title',
    ];

    /**
     * The column display for index
     *
     * @return array
     */
    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            Text::make(__('优惠券标题'), 'title'),
            Select::make(__('优惠券类型'), 'coupon_type')
                ->options(CouponType::getOptions()),
            Text::make(__('状态'), 'status')
                ->displayUsing(function () {
                    if ($this->failure_type === FailureType::fixedDate && $this->validity_end_time < now()) {
                        return __('已失效');
                    }

                    return __('可投放');
                }),

            Number::make(__('库存'), 'stock'),

        ];
    }

    /**
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            Select::make(__('优惠券类型'), 'coupon_type')
                ->readonly(function (NovaRequest $request) {
                    return ! $request->isCreateOrAttachRequest();
                })
                ->options(CouponType::getOptions()),

            Text::make(__('优惠券标题'), 'title')
                ->rules('required'),

            Text::make(__('优惠券浮标题'), 'subtitle'),

            Select::make(__('失效类型'), 'failure_type')
                ->readonly(function (NovaRequest $request) {
                    return ! $request->isCreateOrAttachRequest();
                })
                ->default(FailureType::fixedDate->value)
                ->displayUsingLabels()
                ->options(FailureType::getOptions()),

            DateTime::make(__('生效时间'), 'validity_start_time')
                ->readonly(function (NovaRequest $request) {
                    return ! $request->isCreateOrAttachRequest();
                })
                ->dependsOn('failure_type', function (DateTime $field, $request, $formData) {
                    if ($formData->failure_type !== FailureType::fixedDate->value) {
                        $field->hide();
                    }
                }),

            DateTime::make(__('失效时间'), 'validity_end_time')
                ->readonly(function (NovaRequest $request) {
                    return ! $request->isCreateOrAttachRequest();
                })
                ->dependsOn('failure_type', function (DateTime $field, $request, $formData) {
                    if ($formData->failure_type !== FailureType::fixedDate->value) {
                        $field->hide();
                    }
                }),

            Number::make(__('X 天后生效'), 'effective_days')
                ->readonly(function (NovaRequest $request) {
                    return ! $request->isCreateOrAttachRequest();
                })
                ->dependsOn('failure_type', function (Number $field, $request, $formData) {
                    if ($formData->failure_type !== FailureType::relativeDate->value) {
                        $field->hide();
                    }
                }),

            Number::make(__('有效天数'), 'validity_days')
                ->readonly(function (NovaRequest $request) {
                    return ! $request->isCreateOrAttachRequest();
                })
                ->dependsOn('failure_type', function (Number $field, $request, $formData) {
                    if ($formData->failure_type !== FailureType::relativeDate->value) {
                        $field->hide();
                    }
                }),

            Textarea::make(__('使用须知'), 'note')
                ->maxlength(400),

            Number::make(__('库存'), 'stock')
                ->rules('required')
                ->step(1),

            Number::make(__('每人限领'), 'draw_limit')
                ->rules('required')
                ->step(1),

            Number::make(__('抵扣金额'), 'free_fee')
                ->step(0.01)
                ->dependsOn('coupon_type', function (Number $field, $request, $formData) {
                    if ($formData->coupon_type !== CouponType::vouchers->value) {
                        $field->hide();
                    }
                }),

            Number::make(__('折扣额度'), 'discount')
                ->dependsOn('coupon_type', function (Number $field, $request, $formData) {
                    if ($formData->coupon_type !== CouponType::discount->value) {
                        $field->hide();
                    }
                }),

            Number::make(__('满多少可用'), 'amount_limit')
                ->rules('required'),

            Textarea::make(__('可用商品'), 'product')
                ->placeholder('请输入商品ID')
                ->help('不同商品之间用 ‘;’ 隔开'),

            KeyValue::make(__('附加字段'), 'additional'),

            HasOne::make(__('核销规则'), 'redeem', CouponRedeem::class),
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

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            SendCoupon::make()
                ->canSee(function ($request) {
                    return $request->user()->canSendCoupon();
                })->canRun(function ($request) {
                    return $request->user()->canSendCoupon();
                }),
        ];
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        $model->created_by = $request->user()->id;
        $model->updated_by = $request->user()->id;
        $model->save();
    }

    public static function afterUpdate(NovaRequest $request, Model $model)
    {
        $model->updated_by = $request->user()->id;
        $model->save();
    }
}
