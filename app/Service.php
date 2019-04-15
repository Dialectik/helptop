<?php

namespace App;

use Carbon\Carbon;  //модуль конвертации дат
use \Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слагов

class Service extends Model
{
    use Sluggable;
    
    //const IS_DRAFT = 0;
    //const IS_PUBLIC = 1;
    
    //указание данных, которые будут добавляться при реализации функции add (добавление поста)
    //данный массив затем испол зуется методом fill при добавлении поста
    protected $fillable = ['title', 'content', 'period', 'section_id', 'category_id', 'kind_id', 'bidding_type', 'price_start', 'description'];
    
    //создание связи услуги с разделом
    public function section()
    {
		return $this->belongsTo(Section::class);  //принадлежит разделу
	}
    
    //создание связи услуги с категорией
    public function category()
    {
		return $this->belongsTo(Category::class);  //принадлежит категории
	}
	
	//создание связи услуги с видом услуг
    public function kind()
    {
		return $this->belongsTo(Kind::class);  //принадлежит виду услуг
	}
	
	
	
	//создание связи услуги с пользователем
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');  //принадлежит пользователю
	}
	
	
	
	//создание связи избранных услуг с пользователями
	public function favorites()
	{
		return $this->belongsToMany(  //принадлежит многим
			User::class,
			'favorites', //ссылка на отдельную таблицу связи многих пользователей со многими текстами
			'service_id',   //id услуг (данного класса) в указанной таблице
			'user_id'    //id пользователей (связанного класса) в указанной таблице
		);
	}
        
    //применение функции френдли-ссылок на страницы
	public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    //добавление услуги
    public static function add($fields)
    {
		
		$service = new static;   //создание экземпляра класса
		$service->fill($fields); //заполнение переменных класса значенимями из архива $fields
		$service->user_id = Auth::user()->id;
		
		
///!!!*** СДЕЛАТЬ:  Функция формирования товарного кода услуги 'product_code_id'
		
		
		
//		if(isset($fields['user_id'])){
//			$service->user_id = $fields['user_id'];
//		}else{
//			$service->user_id = 1;
//		}
		
		$service->save();
		
		return $service;
		
	}
	
	//изменение услуги
	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}
	
	//удаление услуги
	public function remove()
	{
		$this->removeImage();  //Удалить картинку услуги до удаления услуги
		$this->delete(); //Удалить сам текст
	}
	
	//загрузка картинки услуги
	public function uploadImage($image)
	{
		if($image == null){return;}   //если картинка не загружена - вернуться
		
		$this->removeImage();//удаление старой картинки перед заменой на новую
		
		$filename = str_random(20) . '.' . $image->extension();  //генерация имени картинки 
		$image->storeAs('uploads', $filename);  //загрузка картинки в папку uploads и присвоение файлу картинки сгенерированного названия
		$this->image = $filename;  //присвоение картинки услуге (присвоение картинки полю image в БД)
		$this->save();  //сохранение услуги
	}
    
    //удаление картинки
	public function removeImage()
	{
		if($this->image != null)    //если картинка была у услуги
		{
			Storage::delete('uploads/' . $this->image);  //удаление старой картинки
		}
	}
    
    //вывод картинки
	public function getImage()
	{
		if($this->image == null)
		{
			return '/img/no-image.png';     //если у услуги нет картинки - загрузить по умолчанию
		}
		
		return '/uploads/' . $this->image;  //если картинка есть - вывести картинку услуги
	}
	
	//присвоение категории услуге
	public function setCategory($id)
	{
		if($id == null) {return;}   //если не выбрана категория - вернуться
		$this->category_id = $id;   //сохранить айди выбранной категории
		$this->save();              //сохранить запись в базу
	}
	
	//синхронизация массивов идентификаторов тегов и постов
//	public function setTags($ids)
//	{
//		if($ids == null){return;}
//		
//		$this->tags()->sync($ids);
//	}
	
	//ПЕРЕКЛЮЧАТЕЛЬ РЕКОМЕНДОВАННЫХ УСЛУГ
	public function setFeatured()  //присвоение свойства "рекомендованные"
	{
		$this->is_featured = 1;
		$this->save();
	}
	public function setStandart()  //удаление свойства "рекомендованные"
	{
		$this->is_featured = 0;
		$this->save();
	}
	public function toggleFeatured($value)  //переключение свойства "рекомендованные"
	{
		if($value == null)
		{
			return $this->setStandart();
		}
		
		return $this->setFeatured();
	}
	
	
	//Увеличитель просмотров
	public function addViews()  
	{
		$this->views += 1;
		$this->save();
	}
	
	
	//Мутатор - изменяет фромат даты для записи в базу
	public function setDateAttribute($value)
	{
		$date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
		$this->attributes['date'] = $date;
	}
	
	//Аксессор - изменяет формат даты для вывода на странице
	public function getDateAttribute($value)
	{
		$date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
		return $date;
	}
	
	//Вывод категории услуги
	public function getCategoryTitle()
    {
        return ($this->category != null) 
                ?   $this->category->title
                :   'Нет категории';
    }
       
    //вывод айди категории для данной услуги
    public function getCategoryID()
    {
        return $this->category != null ? $this->category->id : null;
    }
    
   
    
    
    
    //вывод даты для на странице в определенном формате 
    public function getDate()
    {
		return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
	}
	
	
	// ++++++++
	//Проверка наличия максимального значения из предыдущих
	public function hasPrevious()
	{
		return self::where('id', '<', $this->id)->max('id');
	}
		
	//Вернуть максимальное значение из предыдущих
	public function getPrevious()
	{
		$postID = $this->hasPrevious();
		return self::find($postID);
	}
    	
    	
	//Проверка наличия минимального значения из следующих
	public function hasNext()
	{
		return self::where('id', '>', $this->id)->min('id');
	}
	
	//Вернуть минимальное значение из следующих
	public function getNext()
	{
		$postID = $this->hasNext();
		return self::find($postID);
	}
//	
//	
//	public function related()
//	{
//		return self::all()->except($this->id);
//	}
	// ++++++++
	
	
	//проверка наличия у услуги категории
//	public function hasCategory()
//	{
//		return $this->category != null ? true : false;
//	}
	
	//запрос данных по просмотрам
	public static function getPopularPosts()
	{
		return self::orderBy('views', 'desc')->take(3)->get();
	}
	
	//запрос данных по популярным услугам
	public static function getFeaturedPosts()
	{
		return self::where('is_featured', 1)->take(3)->get();
	}
	
	//запрос данных по последним услугам
	public static function getRecentPosts()
	{
		return self::orderBy('date_on', 'desc')->take(4)->get();
	}
	
	
	
	
	
	
    
    
    
}
