<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVanratesColumnToRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            if (!Schema::hasColumn('rates', 'van_rate')) {
                $table->string('van_rate')->nullable();
            }
            if (!Schema::hasColumn('rates', 'car_rate')) {
                $table->string('car_rate')->nullable();
            }
            if (!Schema::hasColumn('rates', 'bike_rate')) {
                $table->string('bike_rate')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rates', function (Blueprint $table) {
            if (Schema::hasColumn('rates', 'van_rate')) {
                $table->dropColumn(['van_rate']);
            }
            if (Schema::hasColumn('rates', 'car_rate')) {
                $table->dropColumn(['car_rate']);
            }
            if (Schema::hasColumn('rates', 'bike_rate')) {
                $table->dropColumn(['bike_rate']);
            }
        });
    }
}
