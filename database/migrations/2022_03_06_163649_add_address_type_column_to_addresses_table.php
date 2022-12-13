<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressTypeColumnToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->text('address_type')->nullable();
            $table->text('recipient_name')->nullable();
            $table->bigInteger('recipient_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropIfExists('address_type');
            $table->dropIfExists('recipient_name');
            $table->dropIfExists('recipient_phone');
        });
    }
}
