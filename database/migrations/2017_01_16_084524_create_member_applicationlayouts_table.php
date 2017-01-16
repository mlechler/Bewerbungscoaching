<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberApplicationlayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberapplicationlayouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('applicationlayout_id');
            $table->float('price_incl_discount');
            $table->boolean('paid');
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
        Schema::dropIfExists('memberapplicationlayouts');
    }
}
