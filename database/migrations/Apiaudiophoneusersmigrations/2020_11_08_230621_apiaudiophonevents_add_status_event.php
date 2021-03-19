<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneventsAddStatusEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('apiaudiophonevents', function(Blueprint $table){

            $table->enum('apiaudiophonevents_status', ['INGRESADO', 'ACEPTADO', 'POSPUESTO', 'RECHAZADO', 'CERRADO'])->default('INGRESADO')->after('apiaudiophonevents_description');
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

            $table->dropColumn('apiaudiophonevents_status');
        });
    }
}
