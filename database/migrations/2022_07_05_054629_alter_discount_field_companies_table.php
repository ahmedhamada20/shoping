<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDiscountFieldCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'discount')) {
                $table->integer('discount')->unsigned()->nullable()->change();
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
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'discount')) {
                $table->decimal('discount', 10, 2)->unsigned()->nullable()->change();
            }
        });
    }
}
