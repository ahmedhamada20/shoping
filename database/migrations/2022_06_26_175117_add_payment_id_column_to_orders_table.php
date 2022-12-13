<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentIdColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_id')) {
                $table->decimal('payment_id', 10, 2)->unsigned()->nullable()->after('payment_type');
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
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_id')) {
                $table->dropColumn(['payment_id']);
            }
        });
    }
}
