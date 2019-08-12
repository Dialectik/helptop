<?php

namespace App;

use DateTime;
use DateTimeZone;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use \Storage;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    
    //РОДИТЕЛЬСКАЯ связь - основной клас пользователя
    public function users()
    {
		return $this->belongsTo(User::class);
	}
    

	//Мутатор - изменяет фромат даты для записи в базу  (предположительно часовой пояс пользователя 'Europe/Kiev')
	public function setDateBirthday($year, $month, $day)
	{
		$date = new DateTime($year."-".$month."-".$day);
		$date->format('Y-m-d');
		return $date;
	}    
    
    //Аксессор - изменяет формат даты для вывода на странице
//	public function getDateBirthday()
//	{
//		if($this->date_birthday){
//			$date = new Carbon($this->date_birthday);
//			$dt = Carbon::parse($date);  //Разделить дату на компоненты
//			$date_birthday = array("year" =>  $dt->year, "month" =>  $dt->month, "day" => $dt->day);
//			return $date_birthday;
//		}
//	}
    
    
    
    
    
}
