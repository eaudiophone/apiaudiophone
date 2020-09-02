<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneservicesCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('apiaudiophoneservices', function (Blueprint $table) {

            //PrimaryKeyColumn
            $table->bigIncrements('apiaudiophoneservices_id');

            //ForeignKeyColumns
            //$table->unsignedBigInteger('id_apiaudiophoneusers');
            $table->unsignedBigInteger('id_apiaudiophoneterms');

            //Columns
            $table->string('apiaudiophoneservices_name', 65)->nullable(true);
            $table->string('apiaudiophoneservices_description', 65)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            //Relationships
            $table->foreign('id_apiaudiophoneterms')->references('apiaudiophoneterms_id')->on('apiaudiophoneterms');
            //$table->foreign('id_apiaudiophoneusers')->references('apiaudiophoneusers_id')->on('apiaudiophoneusers');
        });

        //desactivamos momentaneamente para pruebas iniciales.
        Schema::disableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('apiaudiophoneservices');
    }
}
