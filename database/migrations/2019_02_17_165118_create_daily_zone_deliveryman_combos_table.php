<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyZoneDeliverymanCombosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('daily_zone_deliveryman_combos'))
        {
            Schema::create('daily_zone_deliveryman_combos', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('zone_id');
                $table->foreign('zone_id')->references('id')->on('zones')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('delivery_man_id');
                $table->foreign('delivery_man_id')->references('id')->on('delivery_men')->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_zone_deliveryman_combos');
    }
}
