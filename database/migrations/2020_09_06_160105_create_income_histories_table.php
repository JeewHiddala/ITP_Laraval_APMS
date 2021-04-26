<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_number');
            $table->double('amount');
            $table->string('description')->nullable($value=true);
            $table->date('date_of_transaction');
            $table->double('discount_given')->nullable($value=true);
            $table->string('category');
            $table->string('action');
            $table->timestamps();
            $table->datetime('changed_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_histories');
    }
}
