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
        Schema::table('users', function (Blueprint $table) {
            $table->string('lname')->after('name');
            $table->string('country');
            $table->string('address1');
            $table->string('address2');
            $table->string('postcode');
            $table->string('city');
            $table->string('province');
            $table->string('phone');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'lname',
                'country',
                'address1',
                'address2',
                'postcode',
                'city',
                'province',
                'phone'
            ]);
        });
    }
};
