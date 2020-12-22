<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonebudgetsAddForeignUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiaudiophonebudgets', function(Blueprint $table){

            $table->unsignedBigInteger('id_apiaudiophoneusers')->nullable(true)->after('apiaudiophonebudgets_id');

            $table->foreign('id_apiaudiophoneusers')->references('apiaudiophoneusers_id')->on('apiaudiophoneusers');
        });
       

        //desactivamos momentaneamente la relacion entre events y users
        Schema::disableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
