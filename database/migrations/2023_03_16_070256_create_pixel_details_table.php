<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePixelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pixel_details', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->nullable(true);
            $table->string('pixel_title')->nullable(true);
            $table->string('pixel_id')->nullable(true);
            $table->string('event_api_status')->default(0);
            $table->string('tiktok_access_token')->nullable(true);
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
        Schema::dropIfExists('pixel_details');
    }
}
