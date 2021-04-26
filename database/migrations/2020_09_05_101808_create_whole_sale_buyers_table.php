<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWholeSaleBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whole_sale_buyers', function (Blueprint $table) {
            $table->increments('reg_no');
            $table->string('buyer_name');
            $table->string('company');
            $table->string('email');
            $table->string('address');
            $table->string('district');
            $table->string('mobile');
            $table->string('land');
            $table->string('bank_name');
            $table->string('acc_num');
            $table->string('credit_days');
            $table->string('discount');
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
        Schema::dropIfExists('whole_sale_buyers');
    }
}
