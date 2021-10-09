<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->string('code');
            $table->string('name');
            $table->string('general_account');
            $table->string('help_account');
            $table->foreignId('exchange_unit_id');
            $table->foreignId('storage_unit_id');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->integer('request_limit');
            $table->integer('minimum');
            $table->integer('maximum');
            $table->integer('files_count');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('exchange_unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('storage_unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
