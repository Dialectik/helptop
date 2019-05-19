<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id');							
            $table->tinyInteger('received_orders')->default(0);		//Полученные заказы (для покупателей) - 1 если это он
            $table->integer('deal_id');								//ID сделки
            $table->tinyInteger('orders_subm')->default(0);			//Предоставленные заказы (для продавцов) - 1 если это он
            $table->char('order_code', 32)->nullable();				//Номер заказа
            $table->string('title')->nullable();					//Название услуги
            $table->integer('total_cost')->nullable();				//Общая стоимость
            $table->integer('rating_id')->nullable();				//ID отзыва
            $table->integer('user_seller_id');       				//ID продавца
			$table->integer('user_buyer_id');      					//ID покупателя
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
        Schema::dropIfExists('histories');
    }
}
