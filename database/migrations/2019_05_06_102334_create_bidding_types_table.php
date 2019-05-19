<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiddingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');			//Название типа торгов
            $table->string('slug'); 			//Слаг названия торгов
            $table->tinyInteger('code');		//Код типа торгов
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidding_types');
    }
}
