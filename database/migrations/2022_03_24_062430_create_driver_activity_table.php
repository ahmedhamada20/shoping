<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_activity', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->enum('status',['active','deactive'])->nullable();
            $table->enum('activity_type',['check_in','check_out'])->nullable();
            $table->integer('total_time')->nullable()->default(0);
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
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
        Schema::dropIfExists('driver_activity');
    }
}
