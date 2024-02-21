<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('registry_id');
            $table->foreign('registry_id')->references('id')->on('business_hours');
            $table->string('km');
            $table->string('coffe');
            $table->string('lunch');
            $table->string('dinner');
            $table->string('parking');
            $table->string('toll');
            $table->string('others');
            $table->string('total');
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
         Schema::dropIfExists('expenses');
    }
}
