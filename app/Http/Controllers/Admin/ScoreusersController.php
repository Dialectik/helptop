<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Score;
use App\User;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;  //модуль конвертации дат

class ScoreusersController extends Controller
{
    public function index($id)
    {
        
    }

    public function create(Request $request)
    {
        $user_id = $request->user_id;
        $balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); //Баланс по последней сделке
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        
        return view('admin.scores.create', [
			'user_id' => $user_id,
			'date_offset' => $date_offset,
			'balance0' => $balance0,
		]);
    }

    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $sum0 = $request->sum0;
        $balance0 = $request->balance0;
        $sum = $request->sum;
        $delta = $sum - $sum0;
        $date = new DateTime();
        $operation = $request->operation;
        if($operation == 1){
			$score = Score::create($request->all());
			$score->balance = $balance0 + $delta;
			$refill0 = $score->refill;
			$score->refill = $refill0 + $delta;
			$score->cause = $request->cause;
			$score->date_trans = $score->updated_at;
			$status = 'Новая тразакция создана. Счет успешно увеличен на '.$delta.' грн. Текущий баланс: '.$score->balance.' грн';
			$score->save();
		}elseif($operation == 2 && ($balance0 - $sum > 0)){
			$score = Score::create($request->all());
			$score->balance = $balance0 - $delta;
			$expense0 = $score->expense;
			$score->expense = $expense0 + $delta;
			$score->cause = $request->cause;
			$score->date_trans = $score->updated_at;
			$status = 'Новая тразакция создана. Счет успешно уменьшен на '.$delta.' грн. Текущий баланс: '.$score->balance.' грн';
			$score->save();
		}elseif($operation == 2 && ($balance0 - $sum < 0)){
			$status = 'Не достаточно средств на счету пользователя для создания новой транзакции по текущей операции'; //Не достаточно средств на счету пользователя
		}elseif($operation == 0){
			$score = Score::create($request->all());
			$score->balance = $balance0;
			$score->cause = 6;
			$score->date_trans = $score->updated_at;
			$status = 'Новая ПУСТАЯ тразакция создана. Счет не изменялся. Текущий баланс: '.$score->balance.' грн';
			$score->save();
		}else{
			$status = 'Новая транзакция не создавалась'; //Транзакция оставлена без изменений
		}
        
        return redirect()->route('scoreusers.show', $user_id)->with('status', $status);
    }
	
	//Показать перечень транзакций по счету пользователя
    public function show($id)
    {
        $user_id = $id;
        $score_id = Score::where('user_id', $user_id)->orderBy('date_trans', 'desc')->pluck('id')->first();
        $score = Score::find($score_id);
        $scores = Score::where('user_id', $user_id)->orderBy('date_trans', 'desc')->get();
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        
        return view('admin.scores.index', [
			'user_id' => $user_id,
			'score' => $score,
			'scores' => $scores,
			'date_offset' => $date_offset,
		]);
    }

    public function edit($score_id)
    {
        $score = Score::find($score_id);
        $user_id = $score->user_id;
        $balance0 = Score::orderBy('date_trans', 'desc')->where('user_id', $user_id)->whereNotNull('cause')->whereNotNull('date_trans')->pluck('balance')->first(); //Баланс по последней сделке
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        
        return view('admin.scores.edit', [
			'user_id' => $user_id,
			'score' => $score,
			'date_offset' => $date_offset,
			'balance0' => $balance0,
		]);
    }

    public function update(Request $request, $score_id)
    {
        $score = Score::find($score_id);
        $user_id = $score->user_id;
        $sum0 = $request->sum0;
        $balance0 = $request->balance0;
        $sum = $request->sum;
        $delta = $sum - $sum0;
        $date = new DateTime();
        $operation = $request->operation;
        if($operation == 1 && $delta != 0){
			$score->update($request->all());
			$score->balance = $balance0 + $delta;
			$refill0 = $score->refill;
			$score->refill = $refill0 + $delta;
			$score->cause = $request->cause;
			$score->date_trans = $date;
			$score->updated_at = $date;
			$status = 'Счет успешно увеличен на '.$delta.' грн. Текущий баланс: '.$score->balance.' грн';
			$score->save();
		}elseif($operation == 2 && ($balance0 - $sum > 0) && $delta != 0){
			$score->update($request->all());
			$score->balance = $balance0 - $delta;
			$expense0 = $score->expense;
			$score->expense = $expense0 + $delta;
			$score->cause = $request->cause;
			$score->date_trans = $date;
			$score->updated_at = $date;
			$status = 'Счет успешно уменьшен на '.$delta.' грн. Текущий баланс: '.$score->balance.' грн';
			$score->save();
		}elseif($operation == 2 && ($balance0 - $sum < 0) && $delta != 0){
			$status = 'Не достаточно средств на счету пользователя для текущей операции'; //Не достаточно средств на счету пользователя
		}else{
			$score = Score::find($score_id);
			$score->cause = $request->cause;
			$score->save();
			$status = 'Транзакция оставлена без изменений'; //Транзакция оставлена без изменений
		}
        
        return redirect()->route('scoreusers.show', $user_id)->with('status', $status);
    }

    public function destroy($id)
    {
        $score = Score::find($id);
        $user_id = $score->user_id;
        $score->delete();
        $status = 'Транзакция №'.$id.' удалена';
        
        return redirect()->route('scoreusers.show', $user_id)->with('status', $status);
    }
    
    //Показать одну транзакцию
    public function showone($score_id)
    {
        $score = Score::find($score_id);
        $user_id = $score->user_id;
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
        isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        
        return view('admin.scores.show', [
			'user_id' => $user_id,
			'score' => $score,
			'date_offset' => $date_offset,
		]);
    }
    
    
}
