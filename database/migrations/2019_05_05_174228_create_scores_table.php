<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('balance')->default(0);				//Остаток средств
            $table->integer('refill')->nullable();				//Пополнение
            $table->datetime('date_trans')->nullable();   		//Дата транзакции
            $table->integer('expense')->nullable();				//Расходы
            $table->integer('user_id');       					//ID пользователя
            $table->integer('service_id')->nullable();			//ID услуги (публикация которой оплачена)
			$table->integer('blurb_id')->nullable();			//ID рекламы услуги
			$table->integer('cause')->nullable();				//Причина изменения счета (1-пополнение пользователем, 2-возврат, 3-бонусная программа, 4-оплата публикации, 5-оплата рекламы, 6-не проведен, 7-корректировка)
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
        Schema::dropIfExists('scores');
    }
}
