<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineryUsageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinery_usage_logs', function (Blueprint $table) {
            $table->increments('log_no');
            $table->integer('reg_id');
            $table->integer('employee_id');
            $table->string('section');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('estimated_end_date');
            $table->time('estimated_end_time');
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
        Schema::dropIfExists('machinery_usage_logs');
    }
}
