<?php

namespace Modules\Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Coupon\Models\UserCoupon;

class UserCouponsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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

        return UserCoupon::filterUserAndCoupon($this->user()->{$userUnionColumn});
    }
}
