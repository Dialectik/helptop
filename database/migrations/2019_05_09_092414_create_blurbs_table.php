<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlurbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blurbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');							//ID пользователя, заказавшего рекламу
            $table->integer('service_id')->nullable();			//ID рекламируемой услуги
            $table->tinyInteger('blurb_type')->nullable();		//ID Вида рекламы услуги
            $table->integer('blurb_cost')->nullable();			//Стоимость рекламы
            $table->datetime('date_on_blurb')->nullable();		//Начальная дата предоставления рекламы
            $table->datetime('date_off_blurb')->nullable();		//Конечная дата предоставления рекламы
            $table->tinyInteger('status')->default(1);			//Статус рекламы (по умолчанию 1 - действующая; 0 - архив)
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
        Schema::dropIfExists('blurbs');
    }
}
