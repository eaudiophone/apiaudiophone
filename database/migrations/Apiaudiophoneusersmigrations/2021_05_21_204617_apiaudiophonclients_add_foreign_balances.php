<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonclientsAddForeignBalances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiaudiophoneclients', function(Blueprint $table){

            $table->unsignedBigInteger('id_apiaudiophonebalances')->nullable(true)->after('apiaudiophoneclients_id');

            $table->foreign('id_apiaudiophonebalances')->references('apiaudiophonebalances_id')->on('apiaudiophonebalances');
        });

        Schema::disableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('apiaudiophoneclients', function(Blueprint $table){


            $table->dropForeign('apiaudiophoneclients_id_apiaudiophonebalances_foreign');

            $table->dropColumn('id_apiaudiophonebalances');
        });
    }
}
