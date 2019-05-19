<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');						
            $table->string('name');								//Логин пользователя
            $table->string('first_name')->nullable();			//Имя пользователя
            $table->string('firm')->nullable();					//Организация
            $table->string('email')->unique();                  //Почта пользователя (уникальный идентификатор)
            $table->string('phone')->nullable();                //Телефон пользователя (уникальный идентификатор)
            $table->timestamp('email_verified_at')->nullable(); //Проверка почты
            $table->string('password')->nullable();				//Пароль
            $table->tinyInteger('is_admin')->default(0);            //Переключатель админ-неадмин
            $table->tinyInteger('is_moder')->default(0);            //Переключатель модератор-немодератор
            $table->tinyInteger('is_agent')->default(0);            //Агент: Продавец или загазчик (доп. Регистрация)
            $table->tinyInteger('status_ban')->default(0);          //Переключатель разбанен-забанен
            $table->boolean('activated')->default(0);           //Признак активированного пользователя (по умолчанию - не активирован)
            $table->string('avatar')->nullable();               //Аватарка пользователя
            $table->rememberToken();							//Маркер (токен) сессии пользователя
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
        Schema::dropIfExists('users');
    }
}
