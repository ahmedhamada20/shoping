<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewColumnToOrderstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderstatuses', function (Blueprint $table) {
            $table->integer('customer_rating')->nullable()->default(0);
            $table->string('customer_comment')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderstatuses', function (Blueprint $table) {
            if (Schema::hasColumn('orderstatuses', 'customer_rating')) {
                $table->dropColumn(['customer_rating']);
            }
            if (Schema::hasColumn('orderstatuses', 'customer_comment')) {
                $table->dropColumn(['customer_comment']);
            }
        });
    }
}
