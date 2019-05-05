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
            $table->text('content');                      	//Полное описание услуги
            $table->text('description')->nullable();      	//Краткое описание услуги
            $table->text('value_service')->nullable();      //Объем одной единицы услуги (описательно)
            integer('number_total')->default(1);			//Количество единиц (сеансов) услуги в наличии
            $table->integer('place_id')->nullable();      	// ID Места предоставления услуги (По адресу заказчика, По адресу исполнителя, Выезд в другой город)
            $table->integer('address_id')->nullable();      // ID Адреса предоставления услуги (опционально)
            $table->integer('distance_id')->nullable();     //ID Периода предоставления услуги 
            $table->integer('section_id');   			  	//ID раздела услуг
            $table->integer('category_id');   				//ID категории услуги
            $table->integer('kind_id');   					//ID вида услуг
            $table->integer('user_id');       				//ID автора услуги
            $table->char('product_code_id', 32)->nullable(); //ID товарного кода услуги
            $table->integer('bidding_type');   				//Тип торгов (Бесплатная услуга, Купить сейчас, Продать сейчас, Аукцион, Тендер, Аукцион + Купить сейчас, Тендер + Продать сейчас)
            $table->datetime('date_on')->nullable();   		//Дата добавления услуги
            $table->datetime('date_off')->nullable();   	//Дата завершения публикации услуги вычисляется путем добавления к 'date_on' значения 'period'
            $table->integer('period');             			//Период публикации услуги; устанавливается в сутках (3, 7, 14, 21, 28 дней)
            $table->string('image')->nullable();          	//Картинка для услуги
            $table->integer('price_start')->default(0);   	//Начальная цена услуги
            $table->integer('price_buy_now')->default(0);   //Цена "Купить сразу"
            $table->integer('price_sell_now')->default(0);   //Цена "Продать сразу"
            $table->integer('price_lower')->default(0);     //Нижняя граница цены (для Тендеров)
            $table->integer('blurb')->default(0);   		//Вид рекламы услуги
            $table->integer('is_featured')->default(0);   	//Рекомендуемое
            $table->integer('views')->default(0);         	//Количество просмотров
            $table->integer('status')->default(1);        	//Публикуемая услуга - 1, услуга в архиве - 0
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
