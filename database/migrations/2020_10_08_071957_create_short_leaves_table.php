<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_leaves', function (Blueprint $table) {
            $table->increments('leave_id');
            $table->string('emp_id');
            $table->string('emp_name');
            $table->string('shortleaveType');
            $table->string('Date');
            $table->string('fromtime');
            $table->string('totime');
            $table->boolean('isApproved')->default(0);
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
        Schema::dropIfExists('short_leaves');
    }
}
