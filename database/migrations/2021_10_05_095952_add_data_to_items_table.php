<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {

            $table->datetime('balance_start_date')->nullable()->after('files_count');
            $table->integer('balance_start_qty')->nullable();
            $table->double('balance_start_value',8,2)->nullable();
            $table->integer('balance_qty')->nullable();
            $table->double('balance_value',8,2)->nullable();
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
