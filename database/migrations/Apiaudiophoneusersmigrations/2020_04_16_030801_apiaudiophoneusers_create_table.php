<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneusersCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apiaudiophoneusers', function (Blueprint $table) {

            //PrimarykeyColumn
            $table->bigIncrements('apiaudiophoneusers_id');

            /*ForeignKeysColumns
            $table->unsignedBigInteger('id_apiaudiophonemeetings');
            $table->unsignedBigInteger('id_apiaudiophonebudgets');
            */

            //Columns
            $table->string('apiaudiophoneusers_fullname', 60)->required();
            $table->string('apiaudiophoneusers_email', 60)->unique()->required();
            $table->string('apiaudiophoneusers_password', 60)->required();
            $table->enum('apiaudiophoneusers_role', ['ADMIN_ROLE', 'USER_ROLE'])->default('USER_ROLE');
            $table->boolean('apiaudiophoneusers_status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            /*Relationships
            $table->foreign('id_apiaudiophonemeetings')->references('apiaudiophonemeetings_id')->on('apiaudiophonemeetings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_apiaudiophonebudgets');->references('apiaudiophonebudgets_id')->on('apiaudiophonebudgets')->onDelete('cascade')->onUpdate('cascade');
            */
        });

        /* Desactivar llaves foráneas
        Schema::disableForeignKeyConstraints();
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apiaudiophoneusers');
    }
}
