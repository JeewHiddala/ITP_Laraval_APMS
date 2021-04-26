<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_details', function (Blueprint $table) {
            $table->increments('employee_id');
            $table->string('name');
            $table->string('address');
            $table->string('birthday');
            $table->string('gender');
            $table->string('designation');
            $table->string('Salary');
            $table->string('mobile');
            $table->string('email');
            $table->string('nic');
            $table->string('password');
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
        Schema::dropIfExists('emp_details');
    }
}
