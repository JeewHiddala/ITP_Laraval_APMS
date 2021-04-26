<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('i_no')->unsigned();
            $table->Integer('f_sup_no')->unsigned();
            $table->string('grn_no');
            $table->date('grn_date')->nullable();
            $table->Integer('receive_quantity')->default(0);
            $table->foreign('i_no')->references('id')->on('items');
            $table->foreign('f_sup_no')->references('reg_no')->on('foreign_suppliers');
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
        Schema::dropIfExists('goods_receives');
    }
}
