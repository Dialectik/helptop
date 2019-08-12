<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');       			//ID автора сообщения
            $table->integer('recipient')->nullable();   //ID получателя сообщения
			$table->integer('service_id')->nullable();	//ID услуги
			$table->integer('deal_id')->nullable();		//ID сделки
			$table->integer('rating_id')->nullable();	//ID рейтинга
			$table->string('message');					//Сообщение
			$table->integer('hide')->nullable();		//Скрывать сообщение от пользователя (когда пользователь у себя ее удалит)
			$table->tinyInteger('unread')-> default(1);	//Не прочитано (по умолчанию 1) / Прочитано (2)
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
        Schema::dropIfExists('messages');
    }
}
