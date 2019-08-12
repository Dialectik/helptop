<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rating;

class RatingusersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function edit($user_id)
    {
        $ratings = Rating::where('user_rated_id', $user_id)->get();
        $rating_id = Rating::where('user_rated_id', $user_id)->pluck('id')->first();
        $rating = Rating::find($rating_id);
        if(null != $rating_id){
			$user_name = $rating->ratedUser->name;
			$deal_id = $rating->deal_id;
		    if($deal_id){
				if($deal_id < 10){
					$deal_code = '0' . '0' . '0' . '0' . '0' . '0' . '0' . $deal_id;
				}elseif($deal_id < 100){
					$deal_code = '0' . '0' . '0' . '0' . '0' . '0' . $deal_id;
				}elseif($deal_id < 1000){
					$deal_code = '0' . '0' . '0' . '0' . '0' . $deal_id;
				}elseif($deal_id < 10000){
					$deal_code = '0' . '0' . '0' . '0' . $deal_id;
				}elseif($deal_id < 100000){
					$deal_code = '0' . '0' . '0' . $deal_id;
				}elseif($deal_id < 1000000){
					$deal_code = '0' . '0' . $deal_id;
				}elseif($deal_id < 10000000){
					$deal_code = '0' . $deal_id;
				}else{
					$deal_code = $deal_id;
				}
			}
		}else{
			$user_name = null;
			$deal_code = null;
			$ratings = null;
		}
        
        //Установка Cookies со смещением часового пояса пользователя относительно 'UTC'
	    isset($_COOKIE["date_offset"]) ? $date_offset = $_COOKIE["date_offset"] : $date_offset =  10800;
        
        return view('admin.ratings.index', [
        	'ratings' => $ratings,
        	'user_name' => $user_name,
        	'date_offset' => $date_offset,
        	'deal_code' => $deal_code,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rating = Rating::find($id);
        //dd( $rating);
        $rating->status = 2; //Аннулируем отзыв (теперь он не будет учитваться в рейтинге)
        $rating->save();
        return redirect()->route('ratingusers.edit', $rating->user_rated_id);
    }
}
