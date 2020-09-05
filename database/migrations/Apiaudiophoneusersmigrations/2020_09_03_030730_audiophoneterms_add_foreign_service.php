<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AudiophonetermsAddForeignService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        

        Schema::table('apiaudiophoneterms', function(Blueprint $table){

            $table->unsignedBigInteger('id_apiaudiophoneservices')->nullable(true)->after('apiaudiophoneterms_id');

            $table->foreign('id_apiaudiophoneservices')->references('apiaudiophoneservices_id')->on('apiaudiophoneservices');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('apiaudiophoneterms', function(Blueprint $table){

            $table->dropColumn('id_apiaudiophoneservices');
        });
    }
}
