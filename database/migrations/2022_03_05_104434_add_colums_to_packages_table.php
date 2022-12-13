<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('parcel_id')->nullable();
            $table->bigInteger('recipient_phone')->nullable();
            $table->string('status')->nullable();
            $table->string('recipient_name')->nullable();
            $table->longText('additional_notes')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('amount')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropIfExists('parcel_id');
            $table->dropIfExists('recipient_phone');
            $table->dropIfExists('status');
            $table->dropIfExists('recipient_name');
            $table->dropIfExists('additional_notes');
            $table->dropIfExists('image');
            $table->dropIfExists('amount');
        });
    }
}
