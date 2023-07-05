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
        Schema::table('popularcourses_details', function (Blueprint $table) {
            $table->string('project');
            $table->string('average_salary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('popularcourses_details', function (Blueprint $table) {
            $table->dropColumn('project');
            $table->dropColumn('average_salary');
        });
    }
};
