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

            $table->unsignedBigInteger('id_apiaudiophoneusers')->nullable(true)->after('apiaudiophoneterms_id');

            $table->foreign('id_apiaudiophoneusers')->references('apiaudiophoneusers_id')->on('apiaudiophoneusers');
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

             $table->dropForeign('apiaudiophoneterms_id_apiaudiophoneusers_foreign');

            $table->dropColumn('id_apiaudiophoneusers');
        });
    }
}
