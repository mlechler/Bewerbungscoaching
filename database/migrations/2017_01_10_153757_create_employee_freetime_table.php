<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeFreetimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeefreetimes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('starttime');
            $table->time('endtime');
            $table->integer('hourlyrate');
            $table->string('services');
            $table->integer('employee_id');
            $table->integer('address_id');
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
        Schema::dropIfExists('employeefreetimes');
    }
}
