<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFieldColumnsToInvoicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {

            $table->foreignId('client_id')->nullable()->change();

            $table->decimal('subtotal', 10, 2)->nullable()->change();
            $table->decimal('tax', 10, 2)->nullable()->change();
            $table->decimal('total', 10, 2)->nullable()->change();

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
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
}
