<?php

namespace Modules\Coupon\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Modules\Coupon\Models\Coupon;

class SendCoupon extends Action
{
    use InteractsWithQueue, Queueable;

    public $showInline = true;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Coupon $model) use ($fields) {
            \Modules\Coupon\Job\SendCoupon::dispatch(explode(';', $fields->users), $model->id);
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Textarea::make(__('用户'), 'users')
                ->placeholder('用户唯一ID')
                ->rules('required')
                ->help('多个用户使用 ‘;’ 隔开'),
        ];
    }

    protected function afterValidation(NovaRequest $request, $validator)
    {
        $users = explode(';', $request->input('users'));
        $request->selectedResources()->each(function ($model) use ($users, $validator) {
            if ($model->stock < count($users)) {
                $validator->errors()->add('users', sprintf('优惠券 %s 剩余库存不足，请补足优惠券后再发放', $model->title));
            }
        });
    }

    public function getName(): string
    {
        return __('发送优惠券');
    }
}
