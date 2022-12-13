<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->longText('parcel_description')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('is_fragile')->nullable();
            $table->boolean('need_aircool')->nullable();
            $table->string('user_location')->nullable();
            $table->integer('delivery_address_id')->nullable();
            $table->string('vehicle_type')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
