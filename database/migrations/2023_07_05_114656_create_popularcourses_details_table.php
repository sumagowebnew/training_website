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
        Schema::create('popularcourses_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('popularcourses_id');
            $table->string('name');
            $table->string('image');
            $table->string('duration');
            $table->string('training_period');
            $table->string('batch');
            $table->timestamps();
            $table->foreign('popularcourses_id')
            ->references('id')->on('popularcourses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('popularcourses_details');
    }
};
