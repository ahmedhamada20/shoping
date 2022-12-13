<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('apartment')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropIfExists('city');
            $table->dropIfExists('street');
            $table->dropIfExists('building');
            $table->dropIfExists('apartment');
            $table->dropIfExists('longitude');
            $table->dropIfExists('latitude');
        });
    }
}
