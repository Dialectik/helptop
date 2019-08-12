<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');							//ID пользователя
            $table->string('patronymic')->nullable();			//Отчетво пользователя
            $table->string('last_name')->nullable();			//Фамилия пользователя
            $table->tinyInteger('sex')->nullable();				//Пол (не указан – 0)
            $table->tinyInteger('marital_status')->nullable();	//Семейное положение
            $table->tinyInteger('children')->nullable();		//Наличие детей
            $table->tinyInteger('car')->nullable();				//Наличие автомобиля
            $table->date('date_birthday')->nullable();			//День рождения
            $table->text('description')->nullable();      		//Краткое описание фирмы (пользователя)
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
        Schema::dropIfExists('personals');
    }
}
