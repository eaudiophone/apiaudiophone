<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophonetermsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('apiaudiophoneterms', function (Blueprint $table) {

            //PrimaryKeyColumn
            $table->bigIncrements('apiaudiophoneterms_id');

            //ForeignKeyColumns
            $table->unsignedBigInteger('id_apiaudiophoneusers');
            //$table->foreignID('id_apiaudiophoneservices');

            //Columns
            $table->integer('apiaudiophoneterms_quantityeventsweekly')->required();
            $table->integer('apiaudiophoneterms_quantityeventsmonthly')->required();
            $table->string('apiaudiophoneterms_rankevents', 65)->required();
            $table->string('apiaudiophoneterms_daysevents', 65)->default(null);
            $table->time('apiaudiophoneterms_begintime', 4)->required();
            $table->time('apiaudiophoneterms_finaltime', 4)->required();
            $table->timestamps();
            $table->softDeletes();

            //Relationships
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
        Schema::dropIfExists('apiaudiophoneterms');
    }
}
