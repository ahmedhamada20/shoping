<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllEmiatesRateAndSpecialCityRateAndKilogrtamRateAndAirConditionRateAndDeliveryTypeToRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function (Blueprint $table) {
            if (!Schema::hasColumn('rates', 'all_emirates_rate')) {
                $table->decimal('all_emirates_rate', 10, 2)->unsigned()->nullable()->after('north_emirates');
            }
            if (!Schema::hasColumn('rates', 'special_city_rate')) {
                $table->decimal('special_city_rate', 10, 2)->unsigned()->nullable()->after('all_emirates_rate');
            }
            if (!Schema::hasColumn('rates', 'per_kilogram_rate')) {
                $table->decimal('per_kilogram_rate', 10, 2)->unsigned()->nullable()->after('special_city_rate');
            }
            if (!Schema::hasColumn('rates', 'air_condition_rate')) {
                $table->decimal('air_condition_rate', 10, 2)->unsigned()->nullable()->after('per_kilogram_rate');
            }
            if (!Schema::hasColumn('rates', 'deliver_type')) {
                $table->enum('deliver_type', array('deliver_now', 'deliver_later'))->nullable();
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
            if (Schema::hasColumn('rates', 'all_emirates_rate')) {
                $table->dropColumn(['all_emirates_rate']);
            }
            if (Schema::hasColumn('rates', 'special_city_rate')) {
                $table->dropColumn(['special_city_rate']);
            }
            if (Schema::hasColumn('rates', 'per_kilogram_rate')) {
                $table->dropColumn(['per_kilogram_rate']);
            }
            if (Schema::hasColumn('rates', 'air_condition_rate')) {
                $table->dropColumn(['air_condition_rate']);
            }
            if (Schema::hasColumn('rates', 'deliver_type')) {
                $table->dropColumn(['deliver_type']);
            }
        });
    }
}
