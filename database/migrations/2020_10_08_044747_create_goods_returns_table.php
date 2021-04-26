<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('it_id')->unsigned();
            $table->string('gre_no');
            $table->date('gre_date')->nullable();
            $table->string('damage_status')->nullable();
            $table->integer('return_quantity')->default(0);
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
        Schema::dropIfExists('goods_returns');
    }
}
