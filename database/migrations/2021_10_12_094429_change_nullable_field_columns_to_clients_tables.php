<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFieldColumnsToClientsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('commercial_register')->nullable()->change();
            $table->foreignId('city_id')->nullable()->change();
            $table->string('address', 500)->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('notes', 500)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
