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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('name')->nullable();
            $table->string('union_id')->nullable();
            $table->json('openid')->nullable();
            $table->integer('point')->default(0);
            $table->integer('experience')->default(0);
            $table->string('source_code', 50)->nullable();
            $table->string('login_id', 32)->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('level')->default(0);
            $table->json('other_data')->nullable();
            $table->timestamps();
        });

        Schema::create('member_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->tinyInteger('gender')->default(0)->comment('0:保密，1：男，2:女');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->text('phone_number')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_infos');

    }
};
