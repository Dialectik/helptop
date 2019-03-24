<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Events\Auth\UserRegistered;
use App\Jobs\DeleteUnactivatedAccount;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Переменная для генерации временного пароля
     */
    protected $generatedPassword;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $this->password = str_random(8);
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($this->password),
        ]);
    }
    
    protected function registered(Request $request, $user)
	{
	    
	    $id = $user->id;
	    //Отправка задачи по удалению не активированного пользователя в отложенную очередь
	    $job = (new DeleteUnactivatedAccount($id))->delay(60*60*24);
	    $this->dispatch($job);
	    
	    //Инициация события отправки сообщения пользователю с временным паролем
	    event(new UserRegistered($user, $this->password));
	    
	    $this->guard()->logout();
	    
	    
	    

	    return redirect($this->redirectPath())
	        ->with('status', 'Дякуємо за реєстрацію! Пароль надіслано на вашу електронну пошту (Thanks for registration! The password has been sent to your email)');
	}
    
    
}
