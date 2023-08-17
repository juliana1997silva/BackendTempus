<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('entry_time');
            $table->string('lunch_entry_time');
            $table->string('lunch_out_time');
            $table->string('out_time');
            $table->string('entry_time_nocommercial')->nullable();
            $table->string('lunch_entry_time_nocommercial')->nullable();
            $table->string('lunch_out_time_nocommercial')->nullable();
            $table->string('out_time_nocommercial')->nullable();
            $table->char('observation', 255)->nullable();
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
        Schema::dropIfExists('groups');
    }
}
