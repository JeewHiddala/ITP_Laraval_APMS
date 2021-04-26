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
            $table->increments('id');
            $table->string('item_no')->nullable();
            $table->string('item_description')->nullable();
            $table->string('m_category')->nullable();
            $table->string('s_category')->nullable();
            $table->string('brand')->nullable();
            $table->string('country')->nullable();
            $table->string('quality')->nullable();
            $table->string('warranty')->nullable();
            $table->string('v_model_no')->nullable();
            $table->string('v_model_name')->nullable();
            $table->string('v_class')->nullable();
            $table->year('year')->nullable();
            $table->integer('quantity')->default(0);
            $table->double('cost')->nullable();
            $table->double('selling_price')->nullable();
            $table->timestamps();
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
