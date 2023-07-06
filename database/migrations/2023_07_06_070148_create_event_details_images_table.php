<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_details_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eventdetails_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('eventdetails_id')
            ->references('id')->on('event_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_details_images');
    }
};
