<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('postcode');
            $table->string('city');
            $table->string('province');
            $table->string('address1');
            $table->string('address2');
            $table->bigInteger('ship_id')->unsigned()->index()->nullable();
            $table->foreign('ship_id')->references('id')->on('shipping');
            $table->enum('status', ['Processing','Shipped','Delivered'])
            ->default('Processing');
            $table->bigInteger('pm_id')->unsigned()->index()->nullable();
            $table->foreign('pm_id')->references('id')->on('payment_methods');
            $table->string('message')->nullable();
            $table->timestamps();
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
