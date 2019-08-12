<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use DateInterval;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use App\ServiceDesc;
use \Storage;

class Deal extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['service_id', 'bidding_type', 'price_fin', 'number_unit', 'user_seller_id', 'user_buyer_id'];
    
    //РОДИТЕЛЬСКАЯ связь - создание связи сделки с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - принадлежит услуге
    public function service()
    {
		return $this->belongsTo(Service::class);
	}
	
	//РОДИТЕЛЬСКАЯ связь - типы торгов
	public function biddingType()
	{
		return $this->belongsTo(BiddingType::class, 'bidding_type');  //принадлежит типу торгов
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи услуги с автором услуги
	public function authorUser()
	{
		return $this->belongsTo(User::class, 'author');  //принадлежит пользователю
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи услуги с инициатором сделки
	public function initiatorUser()
	{
		return $this->belongsTo(User::class, 'initiator');  //принадлежит пользователю
	}
	
	
    
    //ДОЧЕРНЯЯ связь - история
	public function history()
    {
		return $this->hasOne(History::class);
	}
	
	//ДОЧЕРНЯЯ связь - описание услуг
	public function serviceDesc()
    {
		return $this->hasOne(ServiceDesc::class, 'service_id');	//имеет одного
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
	
	//Аксессор - изменяет формат даты для вывода на странице - только дата
	public function getDateWH($value, $offset)
	{
		
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('d-m-Y');
		return $dt;
	}
	//Поиск даты середины периода между начальной и конечной датами
	public function getDateMiddle($strStart, $strEnd)
	{
		$from = Carbon::parse($strStart);		//Начальная дата
    	$to = Carbon::parse($strEnd);			//Конечная дата
    	$dteDiff = $to->diffInDays($from)/2;	//Половина разинцы между датами
    	$dteMiddle = $from->addDays($dteDiff);	//Дата середины периода между начальной и конечной датами
		
		return $dteMiddle;
	}
	
	//вывод названия типа торгов
    public function biddingTypeTitle()
    {
		return $this->biddingType != null ? $this->biddingType->title : null;
	}
	
	//вывод картинки
	public function getImage()
	{
		$id = $this->service_id;
		$image = ServiceDesc::where('service_id', $id)->pluck('image')->first();
		
		if($image == null)
		{
			return '/img/no-image.png';     //если у услуги нет картинки - загрузить по умолчанию
		}

		return '/uploads/services/' . $image;  //если картинка есть - вывести картинку услуги
	}
	
	//вывод краткого описания услуги
	public function getDescription()
	{
		$id = $this->service_id;
		$description = ServiceDesc::where('service_id', $id)->pluck('description')->first();
		
		if($description == null)
		{
			return '-';     //если у услуги нет краткого описания - прочерк
		}

		return $description;  //если краткое описание есть - вывести описание
	}
	
	//вывод дополнительных материалов к услуге из связанной таблицы serviceDesc
    public function getTermsPayment()  {
		$id = $this->service_id;
		$terms_payment = ServiceDesc::where('service_id', $id)->pluck('terms_payment')->first();
		if($terms_payment == null)
		{
			return '-';     //прочерк
		}
		
		return $terms_payment;
	}
	
	//Функции проверки сроков и статусов по сделкам
	public function verDateColor($date0, $nick){	//Для цвета рамочек этапов сделки
		$date_c = new DateTime();
		
		$date = new DateTime($date0, new DateTimeZone('UTC'));
		
		if($nick && $date && $nick >0 ){
			return '#2ECC3D';
		}else{
			if($date < $date_c){
				return '#E3210D';
			}else{
				return '#F7F72B';
			}
		}
	}
	public function verSwitchWarn($date0, $nick){	//Для показа/скрытия карточек предупреждения
		$date_c = new DateTime();
		$date = new DateTime($date0, new DateTimeZone('UTC'));
		if($nick && $date && $nick >0 ){
			return '';			//Нет карточки предупреждения
		}else{
			if($date < $date_c){
				return 'alert-warning';		//Красная карточка предупреждения
			}else{
				return 'alert-info';		//Синяя каротчка сообщения
			}
		}
	}
	public function verSwitchButton($end_date, $nick){	//Для показа/скрытия кнопок подтверждения действий
		$date_c = new DateTime();
		$date = new DateTime($end_date, new DateTimeZone('UTC'));
		if($date < $date_c || $nick > 0){
			return false;
		}else{
			return true;
		}
	}
	
	
	
    
    
}
