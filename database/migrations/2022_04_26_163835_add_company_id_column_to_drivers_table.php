<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdColumnToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            if (!Schema::hasColumn('drivers', 'company_id')) {
                $table->string('company_id')->nullable();
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
        Schema::table('drivers', function (Blueprint $table) {
            if (Schema::hasColumn('drivers', 'company_id')) {
                $table->dropColumn(['company_id']);
            }
        });
    }
}
