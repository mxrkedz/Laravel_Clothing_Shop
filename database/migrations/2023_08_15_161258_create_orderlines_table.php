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
        Schema::create('orderlines', function (Blueprint $table) {
            $table->bigInteger('item_id')->unsigned()->index()->nullable();
            $table->foreign('item_id')->references('id')->on('items');
            $table->bigInteger('orderinfo_id')->unsigned()->index()->nullable();
            $table->foreign('orderinfo_id')->references('id')->on('orders');
            $table->bigInteger('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderlines');
    }
};
