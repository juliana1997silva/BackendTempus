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
            $table->string('registry_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('link')->nullable();
            $table->integer('request_key');
            $table->dateTime('agreed_begin_time')->nullable();
            $table->dateTime('agreed_end_time')->nullable();
            $table->dateTime('begin_time')->nullable();
            $table->integer('category')->nullable();
            $table->integer('complexity')->nullable();
            $table->integer('current_department')->nullable();
            $table->integer('customer_key')->nullable();
            $table->integer('customer_priority')->nullable();
            $table->dateTime('department_begin_time')->nullable();
            $table->dateTime('department_end_time')->nullable();
            $table->dateTime('department_insertion')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->dateTime('insertion')->nullable();
            $table->string('long_description')->nullable();
            $table->dateTime('planned_begin_time')->nullable();
            $table->dateTime('planned_end_time')->nullable();
            $table->integer('priority')->nullable();
            $table->integer('severity')->nullable();
            $table->integer('status')->nullable();
            $table->text('status_description')->nullable();
            $table->string('summary_text')->nullable();
            $table->integer('task_type')->nullable();
            $table->boolean('documentation')->nullable();
            $table->boolean('revision')->nullable();
            $table->boolean('bug')->nullable();
            $table->boolean('daily')->nullable();
            $table->boolean('update')->nullable();
            $table->boolean('service_forecast')->nullable();
            $table->boolean('commit')->nullable();
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
