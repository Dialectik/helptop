<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_descs', function (Blueprint $table) {
            $table->bigIncrements('id');				
            $table->integer('service_id');					//ID услуги
            $table->text('content')->nullable();                      	//Полное описание услуги
            $table->text('description')->nullable();      	//Краткое описание услуги
            $table->text('value_service')->nullable();      //Объем одной единицы услуги (описательно)
            $table->text('add_materials')->nullable();      //Дополнительные материалы, не входящие в стоимость услуги (количество и приблизительная стоимость на единицу услуги)
            $table->string('image')->nullable();          	//Картинка для услуги
            $table->integer('views')->default(0);         	//Количество просмотров
            $table->decimal('duration', 5, 2)->nullable();	//Длительность процесса предоставления услуги в часах
			$table->string('result')->nullable();			//Результат получения услуги
			$table->tinyInteger('availability')->nullable();	//Доступность услуги (В наличии – 1; Под заказ -2)
			$table->tinyInteger('terms_payment')->nullable();	//Условия оплаты ("предоплата" - 1, "оплата после/в момент получения услуги" - 2 , "аванс" - 3, "поэтапная" - 4)
			$table->string('terms_provision')->nullable();		//Условия предоставления
			$table->text('add_terms')->nullable();				//Дополнительные условия
			$table->tinyInteger('status')->default(0);        	//Публикуемая услуга - 1, услуга в архиве - 0  (дублируется)
			$table->tinyInteger('scalable')->nullable();        //Масштабируемая услуга - 1, услуга обычная - 0
			$table->tinyInteger('expandable')->nullable();      //Расширяемая услуга - 1, услуга обычная - 0
			$table->text('slogan')->nullable();					//Слоган
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
        Schema::dropIfExists('service_descs');
    }
}
