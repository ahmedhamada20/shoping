<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->decimal('all_emirates_rate_bike', 10, 2)->unsigned()->nullable();
            $table->decimal('all_emirates_rate_car', 10, 2)->unsigned()->nullable();
            $table->decimal('all_emirates_rate_van', 10, 2)->unsigned()->nullable();
            $table->decimal('special_city_rate_bike', 10, 2)->unsigned()->nullable();
            $table->decimal('special_city_rate_car', 10, 2)->unsigned()->nullable();
            $table->decimal('special_city_rate_van', 10, 2)->unsigned()->nullable();
            $table->decimal('per_kilogram_rate', 10, 2)->unsigned()->nullable();
            $table->decimal('air_condition_rate', 10, 2)->unsigned()->nullable();
            $table->enum('deliver_type', array('deliver_now', 'deliver_later'))->nullable();
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
        Schema::dropIfExists('rates');
    }
}
