<?php

namespace App;

use \Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //константы для значений забанен - разбанен
	const IS_BANNED = 1;
    const IS_ACTIVE = 0;
    
    //указание данных, которые будут добавляться при реализ. функции add (добавл. пользователя)
    //данный массив затем используется методом fill при добавлении пользователя
    protected $fillable = [
        'name', 'email', 'activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    //связь пользователя с услугами, которые он может предлагать на сайте
    /*public function services()
    {
		return $this->hasMany(Service::class);
	}*/
    
    //добавление нового пользователя
	public static function add($fields)
	{
		$user = new static;       //создать новый экземпляр класса
		$user->fill($fields);     //заполнить переменные экземпляра значениями из архива $fields
				
		$user->save();            //записать значения экземпляра в базу
		
		return $user;		      //вернуть ссылку на экземпляр класса
	}
    
    //редактирование пользователя
	public function edit($fields)
	{
		$this->fill($fields);     //обновить переменные экземпляра значениями из архива $fields
		
		$this->save();            //записать значения экземпляра в базу
	}
	
	//создание пароля
	public function generatePassword($password)
	{
		if($password != null)
		{
			$this->password = bcrypt($password);//хеширование пароля и присвоение
			$this->save();  //сохранение записи в ббазе
		}
	}
    
    //загрузка картинки аватара
	public function uploadAvatar($image)
	{
		if($image == null){return;}   //если картинка не загружена - вернутся
		
		$this->removeAvatar();//удаление старого аватара перед заменой на новый
		
		$filename = str_random(10) . '.' . $image->extension();  //генерация имени картинки 
		$image->storeAs('uploads', $filename);  //загрузка картинки в папку uploads и присвоение файлу картинки сгенерированного названия
		$this->avatar = $filename;  //присвоение картинки посту (присвоение картинки полю avatar в БД)
		$this->save();  //сохранение записи в базе
	}
	
	//удаление аватара
	public function removeAvatar()
	{
		if($this->avatar != null)    //если аватарка была у пользователя
		{
			Storage::delete('uploads/' . $this->avatar);  //удаление старой картинки
		}
	}
	
	//вывод картинки аватара
	public function getImage()
	{
		if($this->avatar == null)
		{
			return '/img/no-avatar.png';  //если нет аватарки выводить картинку по умолчанию
		}
		
		return '/uploads/' . $this->avatar;  //вывод аватарки на странице
	}
	
	//***ПЕРЕКЛЮЧАТЕЛЬ АДМИНА
	public function makeAdmin()  //назначение пользователя администратором
	{
		$this->is_admin = 1;
		$this->save();
	}
	public function makeNormal()//присвоения статуса обычного пользователя (не админа)
	{
		$this->is_admin = 0;
		$this->save();
	}
	public function toggleAdmin($value)//переключение административного статуса пользователя
	{
		if($value == null)
		{
			return $this->makeNormal();
		}
		
		return $this->makeAdmin();
	}
	
	//***ПЕРЕКЛЮЧАТЕЛЬ БАНА
	
	public function ban() //присвоения статуса забаненного пользователя
	{
		$this->status_ban = User::IS_BANNED;
		$this->save();
	}
	public function unbun() //разбанить пользователя
	{
		$this->status_ban = User::IS_ACTIVE;
		$this->save();
	}
	public function toggleBun($value) //переключатель "забанить/разбанить"
	{
		if($value == null)
		{
			return $this->unbun();
		}
		
		return $this->ban();
	}
    
       
    //удаление пользователя
	public function remove()
	{
		$this->removeAvatar();  //удаление аватара перед удалением пользов.
		$this->delete();
	}
    
    
    
    
}
