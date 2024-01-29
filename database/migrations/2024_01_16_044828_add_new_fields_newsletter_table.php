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
        Schema::table('newsletter', function (Blueprint $table) {
            $table->string('newsletter_month')->after('image');
            $table->string('newsletter_year')->after('image');
            $table->string('deleted_at')->default(false);
            $table->boolean('is_active')->default(true);
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newsletter', function (Blueprint $table) {
            $table->dropColumn('newsletter_month');
            $table->dropColumn('newsletter_year');
            $table->string('deleted_at')->default(false);
            $table->boolean('is_active')->default(true);
            
        });
    }
};
