<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneventsAddForeignTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('apiaudiophonevents', function(Blueprint $table){

            $table->unsignedBigInteger('id_apiaudiophoneterms')->nullable(true)->after('id_apiaudiophoneusers');

            $table->foreign('id_apiaudiophoneterms')->references('apiaudiophoneterms_id')->on('apiaudiophoneterms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('apiaudiophonevents', function(Blueprint $table){

             $table->dropForeign('apiaudiophonevents_id_apiaudiophoneterms_foreign');

            $table->dropColumn('id_apiaudiophoneterms');
        });
    }
}
