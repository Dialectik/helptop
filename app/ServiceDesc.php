<?php

namespace App;

use \Storage;
use Auth;
use Illuminate\Database\Eloquent\Model;

class ServiceDesc extends Model
{
    
    //РОДИТЕЛЬСКАЯ связь - основной класс услуги
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}
   

    
}
