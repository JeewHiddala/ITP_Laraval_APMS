<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverThroughCompanyVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_through_company_vehicles', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('delivery_id')->unsigned();
            $table->foreign('delivery_id')->references('id')->on('Deliveries')->onDelete('cascade');
            $table->string('driver_id');
            $table->string('vehicle_id');
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
        Schema::dropIfExists('deliver_through_company_vehicles');
    }
}
