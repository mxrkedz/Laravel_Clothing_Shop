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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('item_name');
            $table->bigInteger('sellprice');
            $table->text('img_path');
            $table->bigInteger('sup_id')->unsigned()->index()->nullable();
            $table->foreign('sup_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->bigInteger('cat_id')->unsigned()->index()->nullable();
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('items');
    }
};
