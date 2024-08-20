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
        Schema::create('coupon_redeems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id')->comment('优惠券ID');
            $table->boolean('redeem_online')->default(0)->comment('1,线上核销');
            $table->boolean('redeem_offline')->default(0)->comment('1,线下核销');
            $table->string('product_url')->nullable()->comment('商品链接');
            $table->string('online_coupon_id', 200)->nullable()->comment('该优惠券对应到线上商城的券ID');
            $table->string('offline_coupon_id', 200)->nullable()->comment('该优惠券对应线下pos 的券ID');
            $table->string('qrcode_url')->nullable()->comment('二维码图片');
            $table->string('line_code_url')->nullable()->comment('条形码图片');
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
        Schema::dropIfExists('coupon_redeems');
    }
};
