<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonebudgetsAddForeignServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiaudiophonebudgets', function(Blueprint $table){

            $table->unsignedBigInteger('id_apiaudiophoneservices')->nullable(true)->after('id_apiaudiophoneusers');

            $table->foreign('id_apiaudiophoneservices')->references('apiaudiophoneservices_id')->on('apiaudiophoneservices');
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
