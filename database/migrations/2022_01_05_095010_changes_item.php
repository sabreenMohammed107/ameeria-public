<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->change();
            $table->foreignId('storage_unit_id')->nullable()->change();
            $table->decimal('cost_price', 10, 2)->nullable()->change();
            $table->integer('request_limit')->nullable()->change();
            $table->integer('minimum')->nullable()->change();
            $table->integer('maximum')->nullable()->change();
            $table->integer('files_count')->nullable()->change();
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
