<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->string('entry_time');
            $table->string('lunch_entry_time');
            $table->string('lunch_out_time');
            $table->string('out_time');
            $table->string('password');
            $table->string('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->integer('status');
            $table->integer('admin')->default(0);
            $table->integer('manager')->default(0);
            $table->string('user_interpres_code');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
