<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_has_items', function (Blueprint $table) {
            $table->increments('stock_item_id');
            $table->integer('st_id')->unsigned();
            $table->integer('it_id')->unsigned();
            $table->foreign('st_id')->references('stock_id')->on('stocks');
            $table->foreign('it_id')->references('id')->on('items');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_has_items');
    }
}
