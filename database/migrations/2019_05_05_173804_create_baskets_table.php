<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('price_fin');   					//Конечная цена услуги
            $table->integer('number_unit')->default(1);			//Количество единиц (сеансов) услуги
            $table->integer('total_cost')->nullable();   		//Общая стоимость
            $table->integer('service_id');     					//ID продаваемой услуги
            $table->integer('user_seller_id');       			//ID продавца
            $table->integer('user_buyer_id');       			//ID покупателя
            $table->tinyInteger('bidding_type');   				//ID Типа торгов
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
        Schema::dropIfExists('baskets');
    }
}
