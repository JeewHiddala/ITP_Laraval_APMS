<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_suppliers', function (Blueprint $table) {
           
            $table->increments('reg_no');
            $table->string('foreign_sup_name');
            $table->string('f_company');
            $table->string('f_email');
            $table->string('f_address');
            $table->string('f_mobile');
            $table->string('f_land');
            $table->string('f_bank_name');
            $table->string('f_acc_num');
            $table->string('f_credit_days');
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
        Schema::dropIfExists('foreign_suppliers');
    }
}
