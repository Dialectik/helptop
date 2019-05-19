<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    
    //РОДИТЕЛЬСКАЯ связь - основной клас пользователя
    public function users()
    {
		return $this->belongsTo(User::class);
	}
    
    
    
    
    
    
    
    
    
}
