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
        Schema::create('programdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->longText('introduction');
            $table->longText('course_overview');
            $table->longText('learning_outcome');
            $table->longText('prerequisite');
            $table->string('duration');
            $table->string('training_period');
            $table->string('batch');
            $table->string('project');
            $table->string('average_salary');
            $table->timestamps();
            $table->foreign('program_id')
                ->references('id')->on('ourprograms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programdetails');
    }
};
