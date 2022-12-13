<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderstatuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->string('initial_status')->nullable();
            $table->string('approved_status')->nullable();
            $table->string('driver_status')->nullable();
            $table->string('driver_collected_status')->nullable();
            $table->string('delivery_status')->nullable();
            $table->integer('driver_id')->nullable();
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
        Schema::dropIfExists('orderstatuses');
    }
}
