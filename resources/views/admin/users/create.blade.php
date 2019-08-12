@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить пользователя
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
		<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
		<form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data"> 
		  @csrf
		
	      <!-- Default box -->
	      <div class="box">
	        <div class="box-header with-border">
	          <h3 class="box-title">Добавляем пользователя</h3>
	          @include('admin.errors')
	        </div>
	        <!-- Регистрационные данные -->
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Ник</label>
	              <input type="text" name="name" class="form-control" id="name" placeholder="" value="{{old('name')}}">
	            </div>
	            <div class="form-group">
	              <label for="exampleInputEmail1">E-mail</label>
	              <input type="text" name="email" class="form-control" id="email" placeholder="" value="{{old('email')}}">
	            </div>
	            <div class="form-group">
	              <label for="exampleInputEmail1">Пароль</label>
	              <input type="password" name="password" class="form-control" id="password" placeholder="">
	            </div>
	            <div class="form-group">
	              <label for="exampleInputFile">Аватар</label>
	              <input type="file" name="avatar" id="avatar">

	              <p class="help-block">Загрузите картинку для странички "Обо мне" (только графические файлы)</p>
	            </div>
	        </div>  <!-- end "col-md-6" -->
	      </div>  <!-- end "box-body" -->

	    <!-- Дополнительные данные -->  
        <div class="box-body">
          <div class="col-md-9">	      
			<!-- Имя -->
			<div class="col-md-4">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Имя</label>
	              <input type="text" name="first_name" class="form-control" id="first_name" placeholder="" value="{{old('first_name')}}">
	            </div>
			</div>
			<!-- Отчество -->
			<div class="col-md-4">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Отчество</label>
	              <input type="text" name="patronymic" class="form-control" id="patronymic" placeholder="" value="{{old('patronymic')}}">
	            </div>
			</div>
			<!-- Фамилия -->
			<div class="col-md-4">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Фамилия</label>
	              <input type="text" name="last_name" class="form-control" id="last_name" placeholder="" value="{{old('last_name')}}">
	            </div>
			</div>
	      
          </div>  <!-- end "col-md-9" -->
        </div>  <!-- end "box-body" -->

			<!-- О фирме / О себе -->
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Наименование фирмы (если имеется)</label>
	              <input type="text" name="firm" class="form-control" id="firm" placeholder="" value="{{old('firm')}}">
	            </div>
	            
	            <div class="form-group">
	              <label for="exampleInputEmail1">Краткое описание фирмы (пользователь – о себе)</label>
	              <p class="help-block">Дайте краткое описание деятельности по предоставлению или закупки услуг, которыми Вы занимаетесь</p>
              	  <textarea name="description" id="description" cols="30" rows="10" class="form-control" maxlength="5000">{{old('description')}}</textarea>
	            </div>
	        </div>  <!-- end "col-md-6" -->
	      </div>  <!-- end "box-body" -->

			<!-- Номер телефона -->
	        <div class="box-body">
	          <div class="col-md-4">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Номер телефона (для идентификации пользователя и доступа)</label>
	              <input type="text" name="phone" class="form-control" id="phone" placeholder="" value="{{old('phone')}}">
	            </div>
	        </div>  <!-- end "col-md-4" -->
	      </div>  <!-- end "box-body" -->			


	    <!-- Личные данные -->  
        <div class="box-body">
          <div class="col-md-9">	      
			<!-- Пол -->
			<div class="col-md-4">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Пол</label>
	              	<select class="form-control select2" name="sex" id="sex" style="width: 100%;">
			            <option style="width: 100%" value="">- выберите пол -</option>
			            <option style="width: 100%" value="1">Женский</option>
			            <option style="width: 100%" value="2">Мужской</option>
		            </select>
	            </div>
			</div>
			<!-- Семейное положение -->
			<div class="col-md-4">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Семейное положение</label>
	              	<select class="form-control select2" name="marital_status" id="marital_status" style="width: 100%;">
			            <option style="width: 100%" value="">- Вы в браке? -</option>
			            <option style="width: 100%" value="1">Женат/За мужем</option>
			            <option style="width: 100%" value="2">Не в браке</option>
		            </select>
	            </div>
			</div>
			<!-- Наличие детей -->
			<div class="col-md-4">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Наличие детей</label>
	              <select class="form-control select2" name="children" id="children" style="width: 100%;">
			            <option style="width: 100%" value="">- Есть дети? -</option>
			            <option style="width: 100%" value="1">Есть</option>
			            <option style="width: 100%" value="2">Нет</option>
		            </select>
	            </div>
			</div>
	      
          </div>  <!-- end "col-md-9" -->
        </div>  <!-- end "box-body" -->
        

	    <!-- Личные данные 1 -->  
        <div class="box-body">
          <div class="col-md-9">	      
			<!-- Год рождения -->
			<div class="col-md-3">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Год рождения</label>
	              	<select class="form-control select2" name="year" id="year" style="width: 100%;">
			            <option style="width: 100%" value="">- выберите год -</option>
			            @for($y = date('Y')-10; $y>date('Y')-80; $y--)
			            	<option style="width: 100%" value="{{$y}}">{{$y}}</option>
						@endfor
		            </select>
	            </div>
			</div>
			<!-- Месяц -->
			<div class="col-md-3">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Месяц</label>
	              	<select class="form-control select2" name="month" id="month" style="width: 100%;">
			            <option style="width: 100%" value="">- выберите -</option>
			            @for($i=0; $i<12; $i++)
			            	<option value = "{{$i + 1}}">{{$months[$i]}}</ option>
			            @endfor
		            </select>
	            </div>
			</div>
			<!-- Число -->
			<div class="col-md-3">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Число</label>
	              <select class="form-control select2" name="day" id="day" style="width: 100%;">
			            <option style="width: 100%" value="">- число -</option>
			            @for($d = 1; $d<32; $d++)
			            	<option style="width: 100%" value="{{$d}}">{{$d}}</option>
						@endfor
		            </select>
	            </div>
			</div>
			<!-- Наличие автомобиля -->
			<div class="col-md-3">
	      		<div class="form-group">
	              <label for="exampleInputEmail1">Наличие автомобиля</label>
	              <select class="form-control select2" name="availability" id="availability" style="width: 100%;">
			            <option style="width: 100%" value="">- Есть автомобиль? -</option>
			            <option style="width: 100%" value="1">Есть</option>
			            <option style="width: 100%" value="2">Нет</option>
		            </select>
	            </div>
			</div>
	      
          </div>  <!-- end "col-md-9" -->
        </div>  <!-- end "box-body" -->
        
        	      
	        <!-- /.box-body -->
	        <div class="box-footer">
	          <button class="btn btn-success pull-right">Добавить</button>
	        </div>
	        <!-- /.box-footer-->
	      </div>
	      <!-- /.box -->
		</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@push('scripts')

<!-- Подключение jQuery плагина Masked Input -->
<script src="/js/jquery.maskedinput.min.js"></script>

<!-- Ограничение поля ввода цены услуги ЦИФРАМИ -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		//Функция отсекающая при вводе все кроме цифр
		$.fn.forceNumbericOnly = function() {
			return this.each(function()
			{
			    $(this).keydown(function(e)
			    {
			        var key = e.charCode || e.keyCode || 0;
			        return ( key == 8 || key == 9 || key == 46 ||(key >= 37 && key <= 40) ||(key >= 48 && key <= 57) ||(key >= 96 && key <= 105)   ); 
			        });
			});
		};
		$('#price_f_min').forceNumbericOnly();
		$('#price_f_max').forceNumbericOnly();
		$('#price_s_min').forceNumbericOnly();
		$('#price_s_max').forceNumbericOnly();
	});

	/**
	* Маска ввода товарного кода услуги
	* 
	* плагин: jquery.maskedinput.min.js
	* Цифра 9 – соответствует цифре от 0 до 9.
	* Символ a – представляет собой любой английский символ (A-Z, a-z).
	* Знак * - представляет собой любой алфавитно-цифровой символ (A-Z, a-z, 0-9).
	*
	* задание заполнителя с помощью параметра placeholder
	* $("#date").mask("99.99.9999", {placeholder: "дд.мм.гггг" });
	*
	* https://itchief.ru/lessons/javascript/input-mask-for-html-input-element
	*/
  	$(function(){
	  //Получить элемент, к которому необходимо добавить маску
	  $("#phone").mask("+38(999)999-99-99");
	});
</script>


@endpush