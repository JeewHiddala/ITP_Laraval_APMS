<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineryMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machinery_maintenances', function (Blueprint $table) {
            $table->increments('maintenance_id');
            $table->integer('reg_id');
            $table->string('maintenance_type');
            $table->double('cost');
            $table->date('maintenance_date');
            $table->integer('employee_id');
            $table->string('company_name');
            $table->string('contact_no');
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
        Schema::dropIfExists('machinery_maintenances');
    }
}
