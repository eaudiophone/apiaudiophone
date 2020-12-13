<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApiaudiophoneitemsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apiaudiophoneitems', function (Blueprint $table) {

            //PrimarykeyColumn
            $table->bigIncrements('apiaudiophoneitems_id');


            //Columns
            $table->string('apiaudiophoneitems_name', 60)->required();
            $table->string('apiaudiophoneitems_description', 60)->required();
            $table->float('apiaudiophoneitems_price', 10, 2)->required();
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
        Schema::dropIfExists('apiaudiophoneitems');
    }
}
