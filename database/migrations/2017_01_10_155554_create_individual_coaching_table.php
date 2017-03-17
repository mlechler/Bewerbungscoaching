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
        Schema::create('individualcoachings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('services');
            $table->date('date');
            $table->time('time');
            $table->float('duration');
            $table->float('price_incl_discount');
            $table->boolean('trial');
            $table->boolean('paid');
            $table->integer('employee_id');
            $table->integer('member_id');
            $table->integer('address_id');
            $table->boolean('reminderSend');
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
        Schema::dropIfExists('individualcoachings');
    }
}
