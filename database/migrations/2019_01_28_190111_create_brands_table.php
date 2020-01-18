<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('brands'))
        {
            Schema::create('brands', function (Blueprint $table) {
                $table->integer('id', true);
                $table->string('brand_name')->unique();
                $table->text('brand_contact_detail');
                $table->timestamps();
                $table->unique(['brand_name']);
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
        Schema::dropIfExists('brands');
    }
}
