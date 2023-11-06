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
        Schema::table('our_office', function (Blueprint $table) {
            $table->string('mobile_no')->after('title');
            $table->string('email')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('our_office', function (Blueprint $table) {
            $table->dropColumn('mobile_no');
            $table->dropColumn('email');
        });
    }
};
