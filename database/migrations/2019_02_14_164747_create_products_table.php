<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('products'))
        {
            Schema::create('products', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('brand_id');
                $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('category_id');
                $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
                $table->string('product_name');
                $table->timestamps();
                $table->unique(['brand_id','category_id','product_name']);
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
        Schema::dropIfExists('products');
    }
}
