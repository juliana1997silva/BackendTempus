<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonBusinessHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_business_hours', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('registry_id');
            $table->foreign('registry_id')->references('id')->on('business_hours');
            $table->string('entry_time');
            $table->string('lunch_entry_time')->nullable()->default(NULL);
            $table->string('lunch_out_time')->nullable()->default(NULL);
            $table->string('out_time');
            $table->string('total_time');
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
        Schema::dropIfExists('non_business_hours');
    }
}
