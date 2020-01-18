<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDamageClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('damage_claims'))
        {
            Schema::create('damage_claims', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('brand_id');
                $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
                $table->decimal('damage_amount', 10,2);
                $table->decimal('damage_received', 10,2);
                $table->decimal('remaining_damage', 10,2);
                $table->date('date_till');
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
        Schema::dropIfExists('damage_claims');
    }
}
