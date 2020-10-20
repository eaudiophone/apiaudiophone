<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonetermsDeleteForeignUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apiaudiophoneterms', function(Blueprint $table){

            //laravel usa esa convencion para crear el constraint entre tablas en este caso
            //agarra el nombre de la tabla + underscore + nombre del campo que se relaciona
            //con la otra tabla en este caso 'id_apiaudiophoneusers' + underscore + el sufijo foreign, alejecutar esta migración podemos intentar hacer roll back.
            $table->dropForeign('apiaudiophoneterms_id_apiaudiophoneusers_foreign');
        });
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
