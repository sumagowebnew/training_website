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
        Schema::table('funatworkcategory', function (Blueprint $table) {
            $table->string('image')->after('title');
        });
        Schema::table('moucategory', function (Blueprint $table) {
            $table->string('image')->after('title');
        });
        Schema::table('recognitioncategory', function (Blueprint $table) {
            $table->string('image')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funatworkcategory', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('moucategory', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('recognitioncategory', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
