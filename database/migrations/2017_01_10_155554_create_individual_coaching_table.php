<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualCoachingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individualcoaching', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('services');
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->float('price');
            $table->boolean('trial');
            $table->boolean('paid');
            $table->integer('employee_id');
            $table->integer('member_id');
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
        Schema::dropIfExists('individualcoaching');
    }
}
