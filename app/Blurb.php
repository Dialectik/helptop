<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blurb extends Model
{
    //РОДИТЕЛЬСКАЯ связь - создание связи рекламы с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи рекламы с услугой
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}
    
    //РОДИТЕЛЬСКАЯ связь - Вид рекламы услуги
    public function blurbType()
    {
		return $this->belongsTo(BlurbType::class, 'blurb_type');  //принадлежит 
	}
    
    
    
}
