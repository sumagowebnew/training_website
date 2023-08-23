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
        Schema::create('sub_course_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_course_id');
            $table->unsignedBigInteger('course_id');
            $table->string('title');
            $table->longText('description');
            $table->string('custome_text');
            $table->string('banner');
            $table->timestamps();
            $table->foreign('course_id')
            ->references('id')->on('coursecategory')->onDelete('cascade');
            $table->foreign('sub_course_id')
            ->references('id')->on('subcourses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_course_details');
    }
};
