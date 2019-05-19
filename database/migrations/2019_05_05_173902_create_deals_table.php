<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('price_fin');   					//Конечная цена услуги
            $table->integer('number_unit')->default(1);			//Количество единиц (сеансов) услуги
            $table->integer('total_cost')->nullable();   		//Общая стоимость
            $table->integer('service_id');     					//ID продаваемой услуги
            $table->integer('user_seller_id');       			//ID продавца
            $table->integer('user_buyer_id');       			//ID покупателя
            $table->tinyInteger('bidding_type');   				//ID Типа торгов
            $table->char('order_code', 32)->nullable();			//Номер заказа
            $table->tinyInteger('sig_pay_seller')->default(0);	//Заверка сделки продавцом (оплата получена)
            $table->tinyInteger('sig_pay_buyer')->default(0);	//Заверка сделки покупателем (оплата выполнена)            
            $table->tinyInteger('sig_serv_seller')->default(0);	//Заверка сделки продавцом (услуга предоставлена)
			$table->tinyInteger('sig_serv_buyer')->default(0);	//Заверка сделки покупателем (услуга получена)
            $table->tinyInteger('status_deal')->default(0);		//Статус сделки (В процессе - 0; Успешная - 1; Заверена продавцом - 2; Заверена покупателем - 3; Аннулирована - 4;….)            
            $table->datetime('date_initial')->nullable();		//Начальная дата предоставления услуги
			$table->datetime('date_deadline')->nullable();		//Конечная дата, когда может быть предоставлена услуга
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
        Schema::dropIfExists('deals');
    }
}
