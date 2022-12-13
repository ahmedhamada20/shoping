<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIdColumnToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            if (!Schema::hasColumn('drivers', 'unique_id')) {
                $table->string('unique_id')->nullable();
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
            if (!Schema::hasColumn('drivers', 'unique_id')) {
                $table->string('unique_id')->nullable();
            }
        });
    }
}
