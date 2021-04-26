<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
  
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('title');
            $table->string('client');
            $table->string('client_address');
            $table->decimal('sub_total');
            $table->decimal('discount');
            $table->decimal('grand_total');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
