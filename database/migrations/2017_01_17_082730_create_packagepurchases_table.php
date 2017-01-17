<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagepurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packagepurchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('applicationpackage_id');
            $table->float('price_incl_discount');
            $table->boolean('paid');
            $table->string('path')->nullable();
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
        Schema::dropIfExists('packagepurchases');
    }
}
