<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInsideCityColumnToRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            if (!Schema::hasColumn('rates', 'inside_city')) {
                $table->string('inside_city')->nullable();
            }
            if (!Schema::hasColumn('rates', 'outside_city')) {
                $table->string('outside_city')->nullable();
            }
            if (!Schema::hasColumn('rates', 'between_emirates')) {
                $table->string('between_emirates')->nullable();
            }
            if (!Schema::hasColumn('rates', 'north_emirates')) {
                $table->string('north_emirates')->nullable();
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
            if (Schema::hasColumn('rates', 'inside_city')) {
                $table->dropColumn(['inside_city']);
            }
            if (Schema::hasColumn('rates', 'outside_city')) {
                $table->dropColumn(['outside_city']);
            }
            if (Schema::hasColumn('rates', 'between_emirates')) {
                $table->dropColumn(['between_emirates']);
            }
            if (Schema::hasColumn('rates', 'north_emirates')) {
                $table->dropColumn(['north_emirates']);
            }
        });
    }
}
