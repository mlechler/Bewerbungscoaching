<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lastname');
            $table->string('firstname');
            $table->date('birthday');
            $table->string('phone');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('job')->nullable();
            $table->string('employer')->nullable();
            $table->string('university')->nullable();
            $table->string('courseofstudies')->nullable();
            $table->string('password');
            $table->string('remember_token');
            $table->timestamp('last_login_at')->nullable();
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
        Schema::dropIfExists('members');
    }
}
