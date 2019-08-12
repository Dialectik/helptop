<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use DateInterval;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use App\User;
use App\Service;
use App\Message;


class Message extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['message', 'user_id'];
    
    //РОДИТЕЛЬСКАЯ связь - создание связи сделки с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
	//РОДИТЕЛЬСКАЯ связь - создание связи сделки с пользователем
    public function userR()
    {
		return $this->belongsTo(User::class, 'recipient');  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи рекламы с услугой
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}
    
    
    //вывод названия услуги
    public function getServiceTitle() {
		return $this->Service != null ? $this->Service->title : null;
	}
	
	//вывод сообщения
    public function getMessage($id) {
		return Message::find($id) != null ? Message::find($id)->message : null;
	}
	
	//получение даты
    public function getDate($id) {
		return Message::find($id) != null ? Message::find($id)->updated_at : null;
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
	//Аксессор - изменяет формат даты для вывода на странице в формате Y-m-d
	public function getDateAttributeYmd($value, $offset)
	{
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('Y-m-d H:i:s ');
		return $dt;
	}
    //Аксессор - изменяет формат даты для вывода на странице - только дата
	public function getDateWH($value, $offset)
	{
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('d-m-Y');
		return $dt;
	}
    
    
    
}
