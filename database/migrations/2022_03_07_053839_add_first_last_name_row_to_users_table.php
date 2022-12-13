<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstLastNameRowToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropIfExists('firstname');
            $table->dropIfExists('lastname');
            $table->dropIfExists('city');
        });
    }
}
