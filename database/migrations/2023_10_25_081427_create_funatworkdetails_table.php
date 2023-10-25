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
        Schema::create('funatworkdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('funatworkcategoryid');
            $table->string('title');
            $table->string('image');
            $table->string('description');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('funatworkcategoryid')
            ->references('id')->on('funatworkcategory')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funatworkdetails');
    }
};
