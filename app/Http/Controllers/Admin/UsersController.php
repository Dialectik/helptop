<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Personal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users'   =>  $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = array(' January (1) ', ' February (2) ', ' March (3) ', ' April (4) ', ' May (5) ', ' June (6) ', ' July (7) ', ' August (8) ', ' September (9)', ' October (10)', ' November (11) ', ' December (12) ');
        return view('admin.users.create', ['months'   =>  $months]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required',
            'email' =>  'required|email|unique:users',
            'password'  =>  'required',
            'avatar'    =>  'nullable|image|max:300'
        ]);

        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));
        $user->uploadAvatar($request->file('avatar'));
        $user->first_name = $request->first_name;
        $user->firm = $request->firm;
        	$healthy = array("+38(", "-", ")");
			$yummy   = array("", "", "");
        	$user_phone = str_replace($healthy, $yummy, $request->phone);
        if($request->phone) $user->phone = $user_phone;
        
        //Сохранение персональных данных пользователя в таблице Personal
        $personal = new Personal;	//Создание нового объекта Персональных данных для сохранения их и ID пользователя
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
		$personal->user_id = $user->id;
		$personal->save();  //сохранение записи в таблице Personal
        
        
        $user->save();

        return redirect()->route('users.index');
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
        return view('admin.users.edit', compact('user'), ['months'   =>  $months]);
    }

    
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, [
            'name'  =>  'required',
            'email' =>  [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar'    =>  'nullable|image|max:300'
        ]);

        $user->edit($request->all()); //name,email
        $user->generatePassword($request->get('password'));
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

        return redirect()->route('users.index');
    }

    //Показать - изменить статусы пользователя
    public function editstatus($id)
    {
		$user = User::find($id);

		return view('admin.users.editstatus', [
			'user'   =>  $user,
		]);
	}
    
    //Сохранить измененные статусы пользователя
    public function updatestatus(Request $request)
    {
		$user = User::find($request->user_id);
		if($request->is_admin == 1){$user->is_admin = 1;}else{$user->is_admin = 0;}
		if($request->is_moder == 1){$user->is_moder = 1;}else{$user->is_moder = 0;}
		if($request->is_agent == 1){$user->is_agent = 1;}else{$user->is_agent = 0;}
		if($request->status_ban == 1){$user->status_ban = 1;}else{$user->status_ban = 0;}
		if($request->activated == 1){$user->activated = 1;}else{$user->activated = 0;}

		$user->save();
		
		return redirect()->route('users.index');
	}
    
    //Удалить пользователя
    public function destroy($id)
    {
        User::find($id)->remove();

        return redirect()->route('users.index');
    }
}
