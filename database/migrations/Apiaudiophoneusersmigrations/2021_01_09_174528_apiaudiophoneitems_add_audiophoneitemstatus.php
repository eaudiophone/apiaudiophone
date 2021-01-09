<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneitemsAddAudiophoneitemstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiaudiophoneitems', function(Blueprint $table){

            $table->enum('apiaudiophoneitems_status', ['ACTIVO', 'INACTIVO'])->after('apiaudiophoneitems_price')->default('ACTIVO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apiaudiophoneitems', function(Blueprint $table){

            $table->dropColumn('apiaudiophoneitems_status');
        });
    }
}
