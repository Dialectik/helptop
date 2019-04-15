<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\CodeController;
use App\ActivateAccount;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Code;
use App\Mail\NewUserWelcome;


use App\Events\Auth\UserRegistered;
use App\Jobs\DeleteUnactivatedAccount;


class AuthController extends Controller
{
    public function registerForm()
    {
		return view('auth.register');
	}
	
	public function register(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => [
				'required', 
               	'min:8', 
               	'regex:/^.*(?=.{3,})(?=.*[A-Z])(?=.*[a-z]).*$/',
               	'confirmed'
               	],
            'accept' => 'required'
		]);
		
		$user = User::add($request->all());
		$user->status_ban = 0;//Присвоение изначально статуса разбаненного пользователя
//		$user->email_verified_at = 1;//Присвоение информации о том, что проверен email
		$user->generatePassword($request->get('password'));
		
		
		// Send user message for activation account.
		//создаем код и записываем код
		$code = CodeController::generateCode(8);
		Code::create([
			'user_id' => $user->id,
			'code' => $code,
		]);
		
		//Генерируем ссылку и отправляем письмо на указанный адрес
		$url = url('/').'/activate?id='.$user->id.'&code='.$code;

		Mail::to($request->email)->send(new NewUserWelcome($url));
		
		return view('auth.activ');
		
	}
	
	public function loginForm()
	{
		return view('auth.login');
	}
	
	
	
	public function login(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required'
		]);
		
//		$remember = (Input::has('remember')) ? true : false;
		
		
		
		
		
		if($request->get('remember'))
		{
			$remember = true;
		} else {
			$remember = false;
		}
		
				
		if(Auth::attempt([
			'email' => $request->get('email'),
			'password' => $request->get('password'),
			'activated' => 1,     //проверка что пользователь активирован
			'status_ban' => 0     //проверка, что пользователь не забанен
		], $remember))             //запомнить пользователя до его выхода из сессии
		{
			return redirect('/');
		}
		
		return redirect()->back()->with('status', 'Неправильный логин или пароль');
	}
	
	public function logout()
	{
		Auth::logout();
		return redirect('/login');
	}
	
	//Активация нового зарегистрированного пользователя
	public function activate(Request $request)
	{
	    $res = Code::where('user_id',$request->id)
	        ->where('code',$request->code)
	        ->first();
	    if($res) {
	        //Удаляем использованный код           
	        $res->delete();
	        //активируем аккаунт пользователя           
	        User::find($request->id)
	                ->update([                   
	                    'activated'=>1,
	                ]);
	        //редиректим на страницу авторизации с сообщением об активации
	        	        
	        return redirect()->to('/login');
	    }
	    return abort(404);
	}
	
	
}
