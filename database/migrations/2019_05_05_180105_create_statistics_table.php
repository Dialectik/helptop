<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('history_switch')->default(0);		//Переключатель опций таблицы (Рег. польз - 1; Рег. Услуг - 2; Заключ. сделок - 3; Аннул. Сделок - 4; Не заверш. сделок - 5…)
            $table->integer('reg_users')->default(0);				//Регистрация новых пользователей
            $table->integer('reg_services')->default(0);			//Регистрация новых услуг
            $table->integer('make_deals')->default(0);				//Заключено сделок (сделано заказов)
            $table->integer('completed_deals')->default(0);			//Завершено сделок (выполнено заказов)
            $table->integer('canceled_deals')->default(0);			//Аннулировано сделок (по инициативе пользователей)
            $table->integer('incomplete_deals')->default(0);		//Не завершено сделок (не выполнены обязательства одной или обеих сторон)
            $table->integer('user_id')->nullable();					//ID регистрируемого пользователя
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
        Schema::dropIfExists('statistics');
    }
}
