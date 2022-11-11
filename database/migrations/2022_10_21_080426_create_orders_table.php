<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->string('status')->default('pending');
            $table->decimal('grand_total');
            $table->unsignedInteger('item_count');
            $table->boolean('payment_status')->default(1);
            $table->string('payment_method')->nullable();
            $table->foreignId('address_id')->constrained('addresses');
            $table->text('notes')->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->string('charge_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
