<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneservicesAddNameservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiaudiophonebudgets', function(Blueprint $table){

            $table->string('apiaudiophonebudgets_nameservice', 60)->required()->after('id_apiaudiophoneservices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        Schema::table('apiaudiophonebudgets', function(Blueprint $table){

            $table->dropColumn('apiaudiophonebudgets_nameservice');
        });        
    }
}
