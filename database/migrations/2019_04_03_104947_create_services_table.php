<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');                      	//Название услуги
            $table->string('slug');                       	//Слаг названия
            $table->integer('number_total')->default(1);			//Количество единиц (сеансов) услуги в наличии
            $table->integer('place_id')->nullable();      	// ID Места предоставления услуги (По адресу заказчика, По адресу исполнителя, Выезд в другой город)
            $table->integer('section_id');   			  	//ID раздела услуг
            $table->integer('category_id');   				//ID категории услуги
            $table->integer('kind_id');   					//ID вида услуг
            $table->integer('user_id');       				//ID автора услуги
            $table->char('product_code_id', 32)->nullable(); //ID товарного кода услуги
            $table->tinyInteger('bidding_type');   			//ID Типа торгов (Купить сейчас, Продать сейчас, Аукцион, Тендер, Аукцион + Купить сейчас, Тендер + Продать сейчас)
            $table->datetime('date_on')->nullable();   		//Дата добавления услуги
            $table->datetime('date_off')->nullable();   	//Дата завершения публикации услуги вычисляется путем добавления к 'date_on' значения 'period'
            $table->tinyInteger('period');             		//Период публикации услуги; устанавливается в сутках (3, 7, 14, 21, 28 дней)
            $table->integer('price_start')->default(0);   	//Начальная цена услуги            
            $table->integer('price_current')->default(0);   //Текущая цена (для Аукционов и Тендеров)            
            $table->integer('price_buy_now')->default(0);   //Цена "Купить сразу"
            $table->integer('price_sell_now')->default(0);   //Цена "Продать сразу"
            $table->integer('price_lower')->default(0);     //Нижняя граница цены (для Тендеров и Аукционов)
            $table->integer('bet_step')->nullable();     	//Шаг ставки (для Аукционов и Тендеров)
            $table->integer('blurb_type_id')->nullable();   	//ID рекламы для услуги
            $table->integer('rate_bidding_id')->nullable();		//ID платной опции
            $table->tinyInteger('is_featured')->default(0);   	//Рекомендуемое
            $table->tinyInteger('status')->default(0);        	//Публикуемая услуга - 1, услуга в архиве - 0
            $table->integer('city_id')->nullable();				//ID первой записи в Таблице адресов для данного города
            $table->integer('region_id')->nullable();			//ID первой записи в Таблице адресов для данной области
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
        Schema::dropIfExists('services');
    }
}
