<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_name',200);
            $table->string('rut',25)->unique();
            $table->string('email',100)->unique();
            $table->string('phone',20);
            $table->string('address',200);
            $table->double('latitude',10,8);
            $table->double('longitude',10,8);
            $table->unsignedBigInteger('id_state');
            $table->unsignedBigInteger('id_city');
            $table->unsignedBigInteger('id_status');

            $table->timestamps();
            $table->foreign('id_state')->references('id')->on('states');
            $table->foreign('id_city')->references('id')->on('cities');
            $table->foreign('id_status')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
