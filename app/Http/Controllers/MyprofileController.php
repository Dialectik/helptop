<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\User;
use App\Personal;
use App\Basket;
use App\Message;


class MyprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $months = array(' January (1) ', ' February (2) ', ' March (3) ', ' April (4) ', ' May (5) ', ' June (6) ', ' July (7) ', ' August (8) ', ' September (9)', ' October (10)', ' November (11) ', ' December (12) ');
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
        
        //Если есть непрочтенные сообщения
        $messages_u = Message::where('unread', 1)
			->where('recipient', Auth::user()->id)
        	->get();
		
		if(isset($messages_u)){foreach($messages_u as $mes){if($id_m = $mes->id){	}	};}
		if(isset($id_m)){
			$message_mark = 'id="testElement"';  //Есть сообщения со статусом "прочтено"
		}else{
			$message_mark = '';
		}
                
        return view('pages.users.index', [
	        'user' => $user,
	        'months' => $months,
	        'basket_mark' => $basket_mark,
	        'message_mark' => $message_mark,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $months = array(' January (1) ', ' February (2) ', ' March (3) ', ' April (4) ', ' May (5) ', ' June (6) ', ' July (7) ', ' August (8) ', ' September (9)', ' October (10)', ' November (11) ', ' December (12) ');
        
        //Проверка наличия в корзине услуг
		if(isset(Auth::user()->id)){$basket = Basket::where('initiator', Auth::user()->id)->pluck('id')->first();}else{$basket = null;}
		if(null != $basket){
			$basket_mark = 'id="testElement1"';
		}else{$basket_mark = '';}
		
		//Если есть непрочтенные сообщения
        $messages_u = Message::where('unread', 1)
			->where('recipient', Auth::user()->id)
        	->get();
		
		if(isset($messages_u)){foreach($messages_u as $mes){if($id_m = $mes->id){	}	};}
		if(isset($id_m)){
			$message_mark = 'id="testElement"';  //Есть сообщения со статусом "прочтено"
		}else{
			$message_mark = '';
		}
        
        return view('pages.users.edit', [
	        'user' => $user,
	        'months' => $months,
	        'basket_mark' => $basket_mark,
			'message_mark' => $message_mark,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, [
            'name'  =>  'required',
            'avatar'    =>  'nullable|image|max:300'
        ]);

        $user->edit($request->all()); //name,email
        $user->uploadAvatar($request->file('avatar'));
        $user->first_name = $request->first_name;
        $user->firm = $request->firm;
        	$healthy = array("+38(", "-", ")");
			$yummy   = array("", "", "");
        	$user_phone = str_replace($healthy, $yummy, $request->phone);
        if($request->phone && $user_phone != $user->phone) $user->phone = $user_phone;
        
        //Сохранение персональных данных пользователя в таблице Personal
        //Поиск в таблице персональных данных записи для текущего пользователя
        $existing_personal_find = Personal::where('user_id', $id)->pluck('user_id')->first(); 
        if($existing_personal_find){
			$id_sd = Personal::where('user_id', $id)->pluck('id')->first();
			$personal = Personal::find($id_sd);
			//Сохранение персональных данных пользователя в таблицу Personal
			$personal->patronymic = $request->get('patronymic');					
			$personal->last_name = $request->get('last_name');
			$personal->sex = $request->get('sex');
			$personal->marital_status = $request->get('marital_status');
			$personal->children = $request->get('children');
			$personal->car = $request->get('car');
			$personal->description = $request->get('description');
				$year = $request->get('year');
				$month = $request->get('month');
				$day = $request->get('day');
				$date_birthday = $personal->setDateBirthday($year, $month, $day);
			if($request->day && $date_birthday != $personal->date_birthday) $personal->date_birthday = $date_birthday;
			$personal->save();			//сохранение записи в таблице Personal
		}else{
			$personal = new Personal;         //Создание нового объекта Персональных данных для сохранения их и ID пользователя
			//Сохранение персональных данных пользователя в таблицу Personal
			$personal->patronymic = $request->get('patronymic');					
			$personal->last_name = $request->get('last_name');
			$personal->sex = $request->get('sex');
			$personal->marital_status = $request->get('marital_status');
			$personal->children = $request->get('children');
			$personal->car = $request->get('car');
			$personal->description = $request->get('description');
				$year = $request->get('year');
				$month = $request->get('month');
				$day = $request->get('day');
				$date_birthday = $personal->setDateBirthday($year, $month, $day);
			if($request->day) $personal->date_birthday = $date_birthday;
			$personal->user_id = $id;
			$personal->save();  //сохранение записи в таблице Personal
		}
        
        
        
		$user->save();

        return redirect()->route('myprofile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function changePassword()
    {
        Auth::logout();
		return redirect()->route('password.request');
    }
    
    
    	
    
}
