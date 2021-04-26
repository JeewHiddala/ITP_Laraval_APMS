<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //creating table
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('leave_id');
            $table->string('emp_id');
            $table->string('emp_name');
            $table->string('leaveType');
            $table->string('toDate');
            $table->string('fromDate');
            $table->string('approval');
            $table->string('approveDate');
            $table->string('approvedBy');
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
        Schema::dropIfExists('leaves');
    }
}
