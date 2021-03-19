<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonebudgetsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apiaudiophonebudgets', function (Blueprint $table) {

            //PrimarykeyColumn
            $table->bigIncrements('apiaudiophonebudgets_id');


            //Columns
            $table->string('apiaudiophonebudgets_client_name', 60)->required();
            $table->string('apiaudiophonebudgets_client_email', 60)->required();
            $table->string('apiaudiophonebudgets_client_phone', 60)->required();
            $table->string('apiaudiophonebudgets_client_social', 60)->required();
            $table->float('apiaudiophonebudgets_total_price', 10, 2)->required();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        /*Schema::table('apiaudiophonebudgets', function(Blueprint $table){

            $table->dropForeign('apiaudiophonebudgets_id_apiaudiophoneservices_foreign');

            $table->dropColumn('id_apiaudiophoneservices');
        });*/


        Schema::dropIfExists('apiaudiophonebudgets');
    }
}
