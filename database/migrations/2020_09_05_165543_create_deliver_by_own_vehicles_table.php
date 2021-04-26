<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverByOwnVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_by_own_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_id');
            $table->string('buyer_id');
            $table->string('driver_id');
            $table->string('vehicle_id');
            $table->date('date');
            $table->double('total');
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
        Schema::dropIfExists('deliver_by_own_vehicles');
    }
}
