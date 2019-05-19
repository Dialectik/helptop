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
            $table->integer('service_id');						//ID рекламируемой услуги
            $table->tinyInteger('blurb_type')->nullable();		//Вид рекламы услуги
            $table->integer('blurb_cost')->nullable();			//Стоимость рекламы
            $table->datetime('date_on_blurb')->nullable();		//Начальная дата предоставления рекламы
            $table->datetime('date_off_blurb')->nullable();		//Конечная дата предоставления рекламы
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
