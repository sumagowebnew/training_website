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
        Schema::table('popularcourses', function (Blueprint $table) {
            $table->string('image')->nullable()->default(null);
            $table->string('price')->nullable()->default(null);
            $table->string('enrolled_students')->nullable()->default(null);
            $table->string('info')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('popularcourses', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('price');
            $table->dropColumn('enrolled_students');
            $table->dropColumn('info');
        });
    }
};
