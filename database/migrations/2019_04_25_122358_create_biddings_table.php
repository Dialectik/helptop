<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');                      	//Название торгов
            $table->string('slug');                       	//Слаг названия торгов
            $table->integer('service_id');     				//ID продаваемой услуги
            $table->tinyInteger('bidding_type')->nullable();   	//ID Типа торгов (Бесплатная услуга, Купить сейчас, Продать сейчас, Аукцион, Тендер, Аукцион + Купить сейчас, Тендер + Продать сейчас)
            $table->integer('number_unit')->default(1);     //Количество единиц (сеансов) услуги
            $table->integer('price_rate')->default(0);     	//Цена ставки       
            $table->datetime('date_bid_on')->nullable();   	//Дата начала торгов
            $table->datetime('date_bid_off')->nullable();   //Дата завершения торгов по данной услуге
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
        Schema::dropIfExists('biddings');
    }
}
