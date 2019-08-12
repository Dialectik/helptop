<?php

namespace App;

use App\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
   

	
	/**
	* Функция поиска по нескольким условиям и четким фразам
	* 
	* @param undefined $model_search
	* @param undefined $select_columns
	* @param undefined $sort_column
	* @param undefined $sort_direction
	* @param undefined $chunk
	* @param undefined $where_2d_arr
	* 
	* @return
	*/
	public static function hardSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr = null){
		$services_q = '$services = App\\'.$model_search.'::orderBy("'.$sort_column.'", "'.$sort_direction.'")->select(';
		foreach($select_columns as $s_col){
			$services_q .= '"'.$s_col.'", ';
		}
		$services_q .= '"id")';
		foreach($where_2d_arr as list($a, $b, $c)){
			$pr = $b == "LIKE" ? '%' : '';
			$services_q .= '->where("'.$a.'", "'.$b.'", "'.$pr.$c.$pr.'")';
		}
		//Поиск по датам
		if(!empty($where_date_arr)){
			foreach($where_date_arr as list($a, $b, $c)){
				$services_q .= '->whereDate("'.$a.'", "'.$b.'", "'.$c.'")';
			}
		}		
	
		$services_q .= '->take('.$chunk.')->get();';
		eval($services_q);
//		dd($services_q);
		return $services;
	}
	
	/**
	* Функция поиска по нескольким условиям и отдельным словам, которые ВСЕ должны присутствовать в столюце запроса в любом порядке
	* 
	* @param undefined $model_search
	* @param undefined $select_columns
	* @param undefined $sort_column
	* @param undefined $sort_direction
	* @param undefined $chunk
	* @param undefined $where_2d_arr
	* @param undefined $where_date_arr
	* 
	* @return
	*/
	public static function middleSearch($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_date_arr = null){
		$services_q = '$services = App\\'.$model_search.'::orderBy("'.$sort_column.'", "'.$sort_direction.'")->select(';
		foreach($select_columns as $s_col){
			$services_q .= '"'.$s_col.'", ';
		}
		$services_q .= '"id")';
		//Найти строку поиска в архиве и разбить ее на архив, затем собрать новый архив, где каждое слово будет отдельным условием where "LIKE"
		$rowarr = 0;
		$services_title = ""; //Инициализация строчной переменной
		

		foreach($where_2d_arr as list($a, $b, $c)){
			if($b == "LIKE" || $b == "like"){
				$table_q = $a;  //****Тут подумать - как сделать так, чтобы можно было задавать разные фразы для поиска в разных столбцах
				$services_title .= ' '.$c; //Добавляем все фразы поиска, найденные в архиве
			}else{
				$explode_2d_arr[$rowarr][0] = $a;
				$explode_2d_arr[$rowarr][1] = $b;
				$explode_2d_arr[$rowarr][2] = $c;
				$rowarr++;
			}
		}
		$services_title_arr0 = explode(' ', $services_title);
		$services_title_arr = array_unique($services_title_arr0); //Удалить повторы
		sort($services_title_arr);  //Сортируем массив
		//Создаем тот самый новый архив, где каждое слово будет отдельным условием where "LIKE"
		foreach($services_title_arr as $s_title){
			$explode_2d_arr[$rowarr][0] = $table_q;
			$explode_2d_arr[$rowarr][1] = "LIKE";
			$explode_2d_arr[$rowarr][2] = $s_title;
			$rowarr++;
		}
		//Теперь по расширенному массиву формируем запрос
		foreach($explode_2d_arr as list($a, $b, $c)){
			$pr = $b == "LIKE" ? '%' : '';
			$services_q .= '->where("'.$a.'", "'.$b.'", "'.$pr.$c.$pr.'")';
		}
		//Поиск по датам
		if(!empty($where_date_arr)){
			foreach($where_date_arr as list($a, $b, $c)){
				$services_q .= '->whereDate("'.$a.'", "'.$b.'", "'.$c.'")';
			}
		}
//	dd($services_q);	
		$services_q .= '->take('.$chunk.')->get();';
		eval($services_q);
		return $services;
	}

    
    /**
	* Функция поиска по нескольким условиям и четким фразам - с условием "Купить/Продать"
	* 
	* @param undefined $model_search
	* @param undefined $select_columns
	* @param undefined $sort_column
	* @param undefined $sort_direction
	* @param undefined $chunk
	* @param undefined $where_2d_arr
	* @param undefined $where_bs_arr
	* 
	* @return
	*/
	public static function hardSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr = null){
		$services_q = '$services = App\\'.$model_search.'::orderBy("'.$sort_column.'", "'.$sort_direction.'")->select(';
		foreach($select_columns as $s_col){
			$services_q .= '"'.$s_col.'", ';
		}
		$services_q .= '"id")';
		foreach($where_2d_arr as list($a, $b, $c)){
			$pr = $b == "LIKE" ? '%' : '';
			$services_q .= '->where("'.$a.'", "'.$b.'", "'.$pr.$c.$pr.'")';
		}
		//Поиск по датам
		if(!empty($where_date_arr)){
			foreach($where_date_arr as list($a, $b, $c)){
				$services_q .= '->whereDate("'.$a.'", "'.$b.'", "'.$c.'")';
			}
		}	
		//Поиск по условию "Купить/Продать"
		if(!empty($where_bs_arr)){
			$services_q .= '->whereIn("'.$where_bs_arr[0][0].'", ["'.$where_bs_arr[0][2].'"';
			if(isset($where_bs_arr[1][2])){
				$services_q .=  ', "'.$where_bs_arr[1][2].'"';
			}
			if(isset($where_bs_arr[2][2])){
				$services_q .=  ', "'.$where_bs_arr[2][2].'"';
			}
			$services_q .='])';
		}
		
		$services_q .= '->take('.$chunk.')->get();';
		eval($services_q);
//	dd($services_q);	
		return $services;
	}
	
	
	/**
	* Функция поиска по нескольким условиям и отдельным словам, которые ВСЕ должны присутствовать в столюце запроса в любом порядке - с условием "Купить/Продать"
	* 
	* @param undefined $model_search
	* @param undefined $select_columns
	* @param undefined $sort_column
	* @param undefined $sort_direction
	* @param undefined $chunk
	* @param undefined $where_2d_arr
	* @param undefined $where_date_arr
	* @param undefined $where_bs_arr
	* 
	* @return
	*/
	public static function middleSearchBS($model_search, $select_columns, $sort_column, $sort_direction, $chunk, $where_2d_arr, $where_bs_arr, $where_date_arr = null){
		$services_q = '$services = App\\'.$model_search.'::orderBy("'.$sort_column.'", "'.$sort_direction.'")->select(';
		foreach($select_columns as $s_col){
			$services_q .= '"'.$s_col.'", ';
		}
		$services_q .= '"id")';
		//Найти строку поиска в архиве и разбить ее на архив, затем собрать новый архив, где каждое слово будет отдельным условием where "LIKE"
		$rowarr = 0;
		$services_title = ""; //Инициализация строчной переменной
		

		foreach($where_2d_arr as list($a, $b, $c)){
			if($b == "LIKE" || $b == "like"){
				$table_q = $a;  //****Тут подумать - как сделать так, чтобы можно было задавать разные фразы для поиска в разных столбцах
				$services_title .= ' '.$c; //Добавляем все фразы поиска, найденные в архиве
			}else{
				$explode_2d_arr[$rowarr][0] = $a;
				$explode_2d_arr[$rowarr][1] = $b;
				$explode_2d_arr[$rowarr][2] = $c;
				$rowarr++;
			}
		}
		$services_title_arr0 = explode(' ', $services_title);
		$services_title_arr = array_unique($services_title_arr0); //Удалить повторы
		sort($services_title_arr);  //Сортируем массив
		//Создаем тот самый новый архив, где каждое слово будет отдельным условием where "LIKE"
		foreach($services_title_arr as $s_title){
			$explode_2d_arr[$rowarr][0] = $table_q;
			$explode_2d_arr[$rowarr][1] = "LIKE";
			$explode_2d_arr[$rowarr][2] = $s_title;
			$rowarr++;
		}
		//Теперь по расширенному массиву формируем запрос
		foreach($explode_2d_arr as list($a, $b, $c)){
			$pr = $b == "LIKE" ? '%' : '';
			$services_q .= '->where("'.$a.'", "'.$b.'", "'.$pr.$c.$pr.'")';
		}
		//Поиск по датам
		if(!empty($where_date_arr)){
			foreach($where_date_arr as list($a, $b, $c)){
				$services_q .= '->whereDate("'.$a.'", "'.$b.'", "'.$c.'")';
			}
		}
		//Поиск по условию "Купить/Продать"
		if(!empty($where_bs_arr)){
			$services_q .= '->whereIn("'.$where_bs_arr[0][0].'", ["'.$where_bs_arr[0][2].'"';
			if(isset($where_bs_arr[1][2])){
				$services_q .=  ', "'.$where_bs_arr[1][2].'"';
			}
			if(isset($where_bs_arr[2][2])){
				$services_q .=  ', "'.$where_bs_arr[2][2].'"';
			}
			$services_q .='])';
		}			
//	dd($services_q);	
		$services_q .= '->take('.$chunk.')->get();';
		eval($services_q);
		return $services;
	}
    
    
    
}
