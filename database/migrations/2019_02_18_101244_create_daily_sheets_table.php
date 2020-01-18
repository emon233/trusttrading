<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('daily_sheets'))
        {
            Schema::create('daily_sheets', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('daily_zone_deliverman_combo_id');
                $table->foreign('daily_zone_deliverman_combo_id')->references('id')->on('delivery_men')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('product_id');
                $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('product_out_amount');
                $table->integer('product_return_amount');
                $table->decimal('unit_price', 6,2);
                $table->decimal('total_price', 10,2);
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
        Schema::dropIfExists('daily_sheets');
    }
}
