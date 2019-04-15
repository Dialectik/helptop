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
            $table->string('title');                      //название услуги
            $table->string('slug');                       //слаг названия
            $table->text('content');                      //полное описание услуги
            $table->text('description')->nullable();      //краткое описание услуги
            $table->integer('section_id');   //id раздела услуг
            $table->integer('category_id');   //id категории услуги
            $table->integer('kind_id');   //id вида услуг
            $table->integer('user_id');       //id автора услуги
            $table->integer('product_code_id');   //id товарного кода услуги
            $table->integer('bidding_type');   //тип торгов (бесплатная услуга, купить сейчас, продать сейчас, аукцион понижения, аукцион повышения)
            $table->datetime('date_on');             //дата добавления услуги
            $table->datetime('date_off');             //дата завершения публикации услуги вычисляется путем добавления к 'date_on' значения 'period'
            $table->integer('period');             //период публикации услуги; устанавливается в сутках (3, 7, 14, 21, 28 дней)
            $table->string('image')->nullable();          //картинка для услуги
            $table->integer('price_start')->default(0);   //начальная цена услуги
            $table->integer('blurb')->default(0);   //вид рекламы услуги
            $table->integer('is_featured')->default(0);   //рекомендуемое
            $table->integer('views')->default(0);         //количество просмотров
            $table->integer('status')->default(1);        //публикуемая услуга - 1, услуга в архиве - 0
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
