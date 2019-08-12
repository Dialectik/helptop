<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiddingRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('bidding_type');			//ID Типа торгов
            $table->integer('price_start')->nullable();		//Начальная цена диапазона
            $table->integer('price_end')->nullable();		//Конечная цена диапазона
            $table->integer('rate_bidding')->nullable();	//Тариф выставления услуги
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
        Schema::dropIfExists('bidding_rates');
    }
}
