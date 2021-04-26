<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProductsTable extends Migration
{
    
    public function up()
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_id')->unsigned();
            $table->string('name');
            $table->integer('qty');
            $table->decimal('price');
            $table->decimal('total');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('invoice_products');
    }
}
