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
        //
        Schema::table('programdetails', function (Blueprint $table) {
            $table->string('course_Name');
            $table->string('career_opportunity');
            $table->string('why_sumago');
            $table->string('trainee');
            $table->string('course_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('programdetails', function (Blueprint $table) {
            $table->dropColumn('course_Name');
            $table->dropColumn('career_opportunity');
            $table->dropColumn('why_sumago');
            $table->dropColumn('trainee');
            $table->dropColumn('course_level');
        });
    }
};
