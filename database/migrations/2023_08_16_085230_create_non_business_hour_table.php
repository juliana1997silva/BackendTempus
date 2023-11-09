<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonBusinessHourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_business_hour', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('registry_id');
            $table->foreign('registry_id')->references('id')->on('business_hour');
            $table->string('entry_time');
            $table->string('lunch_entry_time');
            $table->string('lunch_out_time');
            $table->string('out_time');
            $table->char('observation', 255);
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
        Schema::dropIfExists('non_business_hour');
    }
}
