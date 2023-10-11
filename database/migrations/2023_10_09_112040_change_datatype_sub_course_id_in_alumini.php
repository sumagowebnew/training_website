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
        Schema::table('alumini', function (Blueprint $table) {
            $table->renameColumn('course_id', 'sub_course_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumini', function (Blueprint $table) {
            $table->renameColumn('sub_course_id', 'course_id');
        });
    }
};
