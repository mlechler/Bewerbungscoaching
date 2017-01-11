<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberdiscounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('discount_id');
            $table->integer('validity');
            $table->date('startdate');
            $table->boolean('expired');
            $table->boolean('cashedin');
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
        Schema::dropIfExists('memberdiscounts');
    }
}
