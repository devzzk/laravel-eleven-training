<?php

namespace Modules\Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Coupon\Exceptions\NotEnoughCouponsException;
use Modules\Coupon\Models\UserCoupon;

class DrawCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->coupon->draw_limit > $this->coupon->users()->where('user_id', $this->user()->id)->count();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function handle()
    {
        $userUnionColumn = config('coupon.relation.user_union_id_column');

        DB::transaction(function () use ($userUnionColumn) {

            if ($this->coupon->stock < 1) {
                throw new NotEnoughCouponsException;
            }

            $this->coupon->users()->attach($this->user()->{$userUnionColumn}, [
                'validity_start_time' => $this->coupon->getStartTime(),
                'validity_end_time' => $this->coupon->getEndTime(),
                'coupon_type' => $this->coupon->coupon_type,
                'free_fee' => $this->coupon->free_fee,
                'discount' => $this->coupon->discount,
                'product' => $this->coupon->product,
                'code' => Str::ulid(),
                'amount_limit' => $this->coupon->amount_limit,
            ]);

            $this->coupon->decrement('stock');

        });

        return UserCoupon::filterUserAndCoupon($this->user()->{$userUnionColumn}, $this->coupon->id)->get();
    }
}
