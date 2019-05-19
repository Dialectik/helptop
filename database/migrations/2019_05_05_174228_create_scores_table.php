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
