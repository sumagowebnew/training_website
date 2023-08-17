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
        Schema::create('course_fee_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pro_max_id');
            $table->bigInteger('course_id');
            $table->bigInteger('sub_course_id');
            $table->bigInteger('sub_course_fee');
            $table->bigInteger('sub_course_duration');
            $table->string('job_assistance');
            $table->string('live_class_subscription');
            $table->string('lms_subscription');
            $table->string('job_referrals');
            $table->string('industry_projects');
            $table->string('capstone_projects');
            $table->string('domain_training');
            $table->string('project_certification_from_companies');
            $table->string('adv_ai_dsa');
            $table->string('microsoft_certification');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_fee_details');
    }
};
