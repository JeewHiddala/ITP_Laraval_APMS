<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('stock_id');
            $table->string('stock_description')->nullable();
            $table->string('stock_type')->nullable();
            $table->integer('st_quantity')->default(0);
            $table->integer('last_inserted_quantity')->default(0);
            $table->integer('rol')->nullable();
            $table->string('department')->nullable();
            $table->string('line_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
