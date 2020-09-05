<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonetermsAddForeignUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('apiaudiophoneterms', function(Blueprint $table){

            $table->unsignedBigInteger('id_apiaudiophoneusers')->nullable(true)->after('id_apiaudiophoneservices');

            $table->foreign('id_apiaudiophoneusers')->references('apiaudiophoneusers_id')->on('apiaudiophoneusers');
        });
       

        //desactivamos momentaneamente la relacion entre terms y users
        Schema::disableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('apiaudiophoneterms', function(Blueprint $table){

            $table->dropColumn('id_apiaudiophoneusers');
        });
    }
}
