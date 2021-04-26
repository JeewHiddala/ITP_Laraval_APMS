<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_number');
            $table->double('amount');
            $table->string('description')->nullable($value=true);
            $table->date('date_of_transaction');
            $table->double('discount_received')->nullable($value=true);
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
        Schema::dropIfExists('expense_histories');
    }
}
