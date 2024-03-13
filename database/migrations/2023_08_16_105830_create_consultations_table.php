<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('registry_id');
            $table->foreign('registry_id')->references('id')->on('business_hours');
            $table->string('queries');
            $table->string('link');
            $table->number('request_key');
            $table->dateTime('agreed_begin_time');
            $table->dateTime('agreed_end_time');
            $table->dateTime('begin_time');
            $table->number('category');
            $table->number('complexity');
            $table->number('current_department');
            $table->number('customer_key');
            $table->number('customer_priority');
            $table->dateTime('department_begin_time');
            $table->dateTime('department_end_time');
            $table->dateTime('department_insertion');
            $table->string('description');
            $table->dateTime('end_time');
            $table->dateTime('insertion');
            $table->string('long_description');
            $table->dateTime('planned_begin_time');
            $table->dateTime('planned_end_time');
            $table->number('priority');
            $table->number('severity');
            $table->number('status');
            $table->string('status_description');
            $table->string('summary_text');
            $table->number('task_type');
            $table->boolean('documentation');
            $table->boolean('revision');
            $table->boolean('bug');
            $table->boolean('daily');
            $table->boolean('update');
            $table->boolean('service_forecast');
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
        Schema::dropIfExists('consultations');
    }
}
