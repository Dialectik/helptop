<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rating_star')->default(0);				//Текущий общий рейтинг (в звездах)
            $table->integer('rating_pull')->default(0);				//Текущий рейтинг по суммарным показателям (цена, наличие, описание, сроки)
            $table->tinyInteger('local_star')->default(0);			//Оценка общего рейтинга (позитивная оценка: max 5 звезд)
            $table->tinyInteger('local_price')->default(0);			//Актуальность цены (нейтр. "0"; поз. "1"; нег. "-1")
            $table->tinyInteger('local_availab')->default(0);		//Актуальность наличия (нейтр. "0"; поз. "1"; нег. "-1")
            $table->tinyInteger('local_descr')->default(0); 		//Актуальность описания (нейтр. "0"; поз. "1"; нег. "-1")     
            $table->tinyInteger('local_term')->default(0);			//Выполнение заказа в срок (нейтр. "0"; поз. "1"; нег. "-1")
            $table->datetime('date_reting')->nullable();   			//Дата оценки
            $table->string('title')->nullable();					//Название услуги, связанной с отзывом
			$table->integer('kind_id')->nullable();					//ID вида услуг
            $table->integer('user_rated_id')->nullable();       	//ID оцениваемого пользователя
            $table->integer('user_auditor_id')->nullable();       	//ID пользователя дающего оценку
            $table->tinyInteger('user_role')->nullable();       	//Роль оцениваемого пользователя (Заказчик - 1; Продавец - 2)
            $table->tinyInteger('local_contact')->default(0);		//Скорость связи (В течение 30 минут … Не дождался - звонил сам)
            $table->tinyInteger('local_recom')->default(0);			//Рекомендую/Не рекомендую (не . "0"; поз. "1"; нег. "-1")
            $table->text('review')->nullable();   		        	//Отзыв о пользователе (Заказчике или Продавце)          
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
        Schema::dropIfExists('ratings');
    }
}
