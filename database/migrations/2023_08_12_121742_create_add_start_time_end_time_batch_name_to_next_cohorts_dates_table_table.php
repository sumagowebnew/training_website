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
        Schema::table('next_cohorts_dates', function (Blueprint $table) {
            $table->boolean('start_time')->nullable();
            $table->text('end_time')->nullable();
            $table->text('batch_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('next_cohorts_dates', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('batch_date');
        });
    }
};
