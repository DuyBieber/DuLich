<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCustomerTable extends Migration
{
    public function up()
{
    Schema::create('coupon_customer', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
        $table->timestamp('assigned_at')->useCurrent();
        $table->boolean('is_redeemed')->default(false);
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('coupon_customer');
    }
}
