<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //РОДИТЕЛЬСКАЯ связь - пользователь
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - услуга
    public function service()
    {
		return $this->belongsTo(Service::class, 'service_id');  //принадлежит 
	}
    
    
    
    
    
    
    
}
