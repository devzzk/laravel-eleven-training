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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('coupon_type')->default(0)->comment('0 代金券，1，兑换券，2, 折扣券');
            $table->string('name')->comment('优惠券名称')->nullable();
            $table->string('title')->comment('优惠券标题')->nullable();
            $table->string('subtitle')->comment('优惠券副标题')->nullable();
            $table->tinyInteger('failure_type')->comment('优惠券失效类型 1:固定日期失效，2:相对日期失效')->default(1);
            $table->dateTime('validity_start_time')->nullable()->comment('有效期开始时间');
            $table->dateTime('validity_end_time')->nullable()->comment('有效期结束时间');
            $table->integer('effective_days')->default(0)->comment('生效时间');
            $table->integer('validity_days')->default(0)->comment('有效时间');
            $table->string('note', 400)->comment('使用须知');
            $table->unsignedTinyInteger('stock')->default(0)->comment('库存');
            $table->unsignedTinyInteger('draw_limit')->default(0)->comment('每人限领数量');
            $table->decimal('amount_limit')->default(0)->comment('满多少可用');
            $table->decimal('free_fee')->default(0)->comment('代金券 当coupon_type 为0 时，根据当前金额 进行优惠');
            $table->decimal('discount', 3, 2)->default(0)->comment('当 coupon_type 为2 时，根据当前折扣进行优惠');
            $table->text('product')->nullable()->comment('可用商品');
            $table->boolean('can_with_other')->default(false)->comment('是否可以和其他券一起使用');
            $table->json('additional')->nullable()->comment('附加字段');
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
        Schema::dropIfExists('coupons');
    }
};
