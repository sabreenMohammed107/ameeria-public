<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFieldColumnsToInvoiceItemsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {

            $table->foreignId('exchange_unit_id')->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->decimal('price', 10, 2)->nullable()->change();
            $table->string('note')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            //
        });
    }
}
