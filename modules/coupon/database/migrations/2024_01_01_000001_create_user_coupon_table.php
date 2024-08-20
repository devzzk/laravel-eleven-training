<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_coupon', function (Blueprint $table) {
            $table->string('user_union_id')->comment('用户唯一ID');
            $table->unsignedBigInteger('coupon_id');
            $table->timestamp('validity_start_time')->comment('优惠券有效期开始时间');
            $table->timestamp('validity_end_time')->comment('优惠券有效期结束时间');
            $table->tinyInteger('coupon_type')->comment('优惠券类型');
            $table->decimal('free_fee')->default(0)->comment('代金券 当coupon_type 为0 时，根据当前金额 进行优惠');
            $table->decimal('discount', 3, 2)->default(0)->comment('当 coupon_type 为2 时，根据当前折扣进行优惠');
            $table->text('product')->nullable()->comment('可用商品');
            $table->timestamp('used_at')->nullable()->comment('使用时间');
            $table->decimal('amount_limit')->default(0)->comment('满多少可用');
            $table->string('code')->nullable()->unique()->comment('优惠券code');
            $table->unsignedBigInteger('created_by')->nullable()->comment('创建人');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('更新人');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coupon');
    }
};
