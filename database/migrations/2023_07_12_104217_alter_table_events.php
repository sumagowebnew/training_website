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
        Schema::table('events', function (Blueprint $table) {
            $table->string('image');
            $table->string('start_time');
            $table->string('start_date');
            $table->string('duration');
            $table->string('registered_people');
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
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('start_time');
            $table->dropColumn('start_date');
            $table->dropColumn('duration');
            $table->dropColumn('registered_people');
        });
    }
};
