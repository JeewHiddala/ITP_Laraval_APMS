<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
           
            Schema::create('local_suppliers', function (Blueprint $table) {
                $table->increments('reg_no');
                $table->string('name');
                $table->string('company');
                $table->string('email');
                $table->string('address');
                $table->string('district');
                $table->string('mobile');
                $table->string('land');
                $table->string('bank_name');
                $table->string('acc_num');
    
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
        Schema::dropIfExists('local_suppliers');
    }
}
