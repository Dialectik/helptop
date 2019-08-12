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
            $table->tinyInteger('status_deal')->default(0);		//Статус сделки (В процессе - 1; Успешная - 2; Заверена продавцом - 3; Заверена покупателем - 4; Аннулирована - 5;….)            
            $table->datetime('date_initial')->nullable();		//Начальная дата предоставления услуги
			$table->datetime('date_deadline')->nullable();		//Конечная дата, когда может быть предоставлена услуга
            $table->datetime('date_pay_seller')->nullable();	//Дата заверки сделки продавцом (оплата получена)
			$table->datetime('date_pay_buyer')->nullable();		//Дата заверки сделки покупателем (оплата выполнена)
			$table->datetime('date_serv_seller')->nullable();	//Дата заверки сделки продавцом (услуга предоставлена)
			$table->datetime('date_serv_buyer')->nullable();	//Дата заверки сделки покупателем (услуга получена)
			$table->string('initiator')->nullable();			//ID Инициатора сделки (нажавшего кнопку)
			$table->string('author')->nullable();				//ID Автора объявления (выставившего)
			$table->tinyInteger('sig_pay0_seller')->default(0);	//Заверка сделки продавцом (предоплата получена)
			$table->tinyInteger('sig_pay0_buyer')->default(0);	//Заверка сделки покупателем (предоплата выполнена)
			$table->datetime('date_pay0_seller')->nullable();	//Дата заверки сделки продавцом (предоплата получена)
			$table->datetime('date_pay0_buyer')->nullable();	//Дата заверки сделки покупателем (предоплата выполнена)
			$table->tinyInteger('sig_approved_seller')->default(0);	//Заверка условий сделки продавцом
			$table->tinyInteger('sig_approved_buyer')->default(0);	//Заверка условий сделки покупателем
			$table->datetime('date_approved_seller')->nullable();	//Дата условий заверки сделки продавцом
			$table->datetime('date_approved_buyer')->nullable();	//Дата условий заверки сделки покупателем
			$table->integer('hide')->nullable();					//Скрывать сделку от пользователя (когда пользователь у себя ее удалит)
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
