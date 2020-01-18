<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('debit_claims'))
        {
            Schema::create('debit_claims', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('brand_id');
                $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
                $table->decimal('claimable_amount', 10,2);
                $table->decimal('debit_received', 10,2);
                $table->decimal('remaining_claim', 10,2);
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
        Schema::dropIfExists('debit_claims');
    }
}
