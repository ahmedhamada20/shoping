<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileColumnToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->integer('distance')->nullable();
            $table->string('emirates_id')->nullable();
            $table->string('profile')->nullable();
            $table->longText('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropIfExists('distance');
            $table->dropIfExists('emirates_id');
            $table->dropIfExists('profile');
            $table->dropIfExists('address');
        });
    }
}
