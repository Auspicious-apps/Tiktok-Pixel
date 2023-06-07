<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePixelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pixel_products', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->nullable(true);
            $table->string('pixel_id')->nullable(true);
            $table->string('collections')->nullable(true);
            $table->string('types')->nullable(true);
            $table->string('tags')->nullable(true);
            $table->string('products')->nullable(true);
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
        Schema::dropIfExists('pixel_products');
    }
}
