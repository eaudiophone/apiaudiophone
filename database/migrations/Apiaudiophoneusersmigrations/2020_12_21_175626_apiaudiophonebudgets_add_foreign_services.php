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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('apiaudiophonebudgets', function(Blueprint $table){

            $table->dropForeign('apiaudiophonebudgets_id_apiaudiophoneservices_foreign');

            $table->dropColumn('id_apiaudiophoneservices');
        });
    }
}
