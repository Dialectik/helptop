<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use DateInterval;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат

class Rating extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['title', 'kind_id', 'user_rated_id', 'user_auditor_id', 'user_role'];
    
    
    //РОДИТЕЛЬСКАЯ связь - создание связи рейтинга с пользователем - носителем рейтинга
    public function ratedUser()
    {
		return $this->belongsTo(User::class, 'user_rated_id');  //принадлежит 
	}
    
    //РОДИТЕЛЬСКАЯ связь - создание связи рейтинга с пользователем, который давал оценку
    public function auditorUser()
    {
		return $this->belongsTo(User::class, 'user_auditor_id');  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи рейтинга с услугой, которая фигурировала в сделке
    public function service()
    {
		return $this->belongsTo(Service::class, 'service_id');  //принадлежит 
	}
    
    
    
    
    
    //Аксессор - изменяет формат даты для вывода на странице
	public function getDateAttribute($value, $offset)
	{
		
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('d-m-Y H:i:s ');
		return $dt;
	}
    
    
    
    
}
