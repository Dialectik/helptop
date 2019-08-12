

@extends('layouts.app_a')

@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Путь -->
					<div class="breadcrumbs">
						<ol class="breadcrumb">
						  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
						  <li class="active">Изменение данных Моего профиля</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3"> <!--left-sidebar-->
					<div class="form-group">
		              <img src="{{$user->getImage()}}" alt="" width="200" class="img-responsive">
		              <label for="exampleInputFile" style="color:#0D1291">{{ $user->name }}</label>
		            </div>
					
					<!--left-sidebar-->
					@include('layouts._sidebar_myprofile')
				</div>
				
				<div class="col-sm-9 padding-right">
				

				
				
				<!--Показывать страницу только если найден пользователь-->
				@if(null != $user && $user->id == Auth::user()->id)
				<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
				<form method="POST" action="{{ route('myprofile.update', $user->id) }}" enctype="multipart/form-data"> 
			  		@csrf
					<input type="hidden" name="_method" value="PUT" >
					
					<div class="features_items"><!--Данные пользователя-->
						<h2 class="title text-center">Изменение данных <small>пользователя</small> {{ $user->name }}</h2>
						<!-- Default box -->
					      <div class="box">
					        <!-- Регистрационные данные -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-3">
					            <div class="form-group">
					              Логин &nbsp; 
					              <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="" value="{{$user->name}}">
					            </div>  <!-- end "col-sm-3" -->
					          </div>
					          <div class="col-sm-3">
					            <div class="form-group">
					              E-mail &nbsp; 
					              <p><a href="/contacts">Для изменения E-mail обратитесь через форму обратной связи</a></p>
					            </div>
					          </div>  <!-- end "col-sm-3" -->
					          <div class="col-sm-3">
				            	Пароль &nbsp;
				            	@if (Route::has('password.request'))
	                                <p><a href="{{ route('changepassword') }}">
	                                    Если Вы хотите изменить пароль - пройдите по ссылке
	                                </a></p>
	                            @else
	                            	<p><span style="color:#0D1291">Вы не можете изменить пароль</span></p>
	                            @endif
					          </div>  <!-- end "col-sm-3" -->
					          <div class="col-sm-3">
					            <div class="form-group">
					            </div>
					          </div>  <!-- end "col-sm-3" -->
					        </div>  <!-- end "box-body" -->
					      
						    <!-- Дополнительные данные -->  
					        <div class="box-body col-sm-12">
					          	      
								<!-- Имя -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              Имя &nbsp; 
						              <input type="text" name="first_name" class="form-control" id="first_name" placeholder="" value="{{$user->first_name}}">
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Отчество -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              Отчество &nbsp; 
						             <input type="text" name="patronymic" class="form-control" id="patronymic" placeholder="" value="{{$user->getPatronymic()}}">
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Фамилия -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              Фамилия &nbsp; 
						              <input type="text" name="last_name" class="form-control" id="last_name" placeholder="" value="{{$user->getLastName()}}">
						            </div>
								</div> <!-- end "col-sm-3" -->
								<div class="col-sm-3">
						            <div class="form-group">
						            </div>
						        </div>  <!-- end "col-sm-3" -->
					        </div>  <!-- end "box-body" -->
					        
					        <div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

							<!-- О фирме / О себе -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-4">
					            <div class="form-group">
					              Наименование фирмы &nbsp; 
					              <input type="text" name="firm" class="form-control" id="firm" placeholder="" value="{{$user->firm}}">
					            </div>
					          </div>
					          <div class="col-sm-8">
					            <div class="form-group">
					              Краткое описание фирмы (пользователь – о себе) &nbsp;
				              	  <textarea name="description" id="description" cols="30" rows="10" class="form-control" maxlength="5000">{{$user->getDescription()}}</textarea>
					            </div>
						      </div>  <!-- end "col-sm-6" -->
						    </div>  <!-- end "box-body" -->

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

							<!-- Номер телефона -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-6">
					            <div class="form-group">
					              Номер телефона (для идентификации пользователя и доступа) &nbsp; 
					              <input type="text" name="phone" class="form-control" id="phone" placeholder="" value="{{$user->getPhone()}}">
					            </div>
					          </div>  <!-- end "col-sm-6" -->
					          <div class="col-sm-6">
					            <div class="form-group">
					              <img src="{{$user->getImage()}}" alt="" width="200" class="img-responsive">
					              <label for="exampleInputFile">Аватар</label>
					              <input type="file" name="avatar" id="exampleInputFile">
					              <p class="help-block">Загрузите картинку для странички "Обо мне" (только графические файлы)</p>
					            </div>
					          </div>  <!-- end "col-sm-6" -->
					        </div>  <!-- end "box-body" -->			

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

						    <!-- Личные данные -->  
					        <div class="box-body col-sm-12">
								<div class="col-sm-4">
						      		<div class="form-group">
						             	Пол &nbsp; 
						              	<select class="form-control select2" name="sex" id="sex" style="width: 100%;">
								            <option selected style="width: 100%" value="{{$user->getSex()[0]}}">{{$user->getSex()[1]}}</option>
								            <option style="width: 100%" value="1">Женский</option>
								            <option style="width: 100%" value="2">Мужской</option>
							            </select>
						            </div>
								</div>
								<!-- Семейное положение -->
								<div class="col-sm-4">
						      		<div class="form-group">
						              	Семейное положение &nbsp; 
						              	<select class="form-control select2" name="marital_status" id="marital_status" style="width: 100%;">
								            <option selected style="width: 100%" value="{{$user->getMaritalStatus()[0]}}">{{$user->getMaritalStatus()[1]}}</option>
								            <option style="width: 100%" value="1">Женат/За мужем</option>
								            <option style="width: 100%" value="2">Не в браке</option>
							            </select>
						            </div> 
								</div> <!-- end "col-sm-4" -->
								<!-- Наличие детей -->
								<div class="col-sm-4">
						      		<div class="form-group">
						            </div>
								</div> <!-- end "col-sm-4" -->
					        </div>  <!-- end "box-body" -->
				        
				        	<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

						    <!-- Личные данные 1 -->  
					        <div class="box-body col-sm-12">
      
								<!-- Год рождения -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              	Год рождения &nbsp; 
							            <select class="form-control select2" name="year" id="year" style="width: 100%;">
								            @if(!empty($user->getDateBirthday()))
								            	<option selected style="width: 100%" value="{{$user->getDateBirthday()['year']}}">{{$user->getDateBirthday()['year']}}</option>
								            @endif
								            <option style="width: 100%" value="">- выберите год -</option>
								            @for($y = date('Y')-10; $y>date('Y')-80; $y--)
								            	<option style="width: 100%" value="{{$y}}">{{$y}}</option>
											@endfor
							            </select>
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Месяц -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              	Месяц &nbsp; 
										<select class="form-control select2" name="month" id="month" style="width: 100%;">
								            @if(!empty($user->getDateBirthday()))
								            	<option selected style="width: 100%" value="{{$user->getDateBirthday()['month']}}">{{$months[$user->getDateBirthday()['month'] - 1]}}</option>
								            @endif
								            <option style="width: 100%" value="">- выберите -</option>
								            @for($i=0; $i<12; $i++)
								            	<option value = "{{$i + 1}}">{{$months[$i]}}</ option>
								            @endfor
							            </select>
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Число -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              	Число &nbsp; 
							            <select class="form-control select2" name="day" id="day" style="width: 100%;">
								            @if(!empty($user->getDateBirthday()))
								            	<option selected style="width: 100%" value="{{$user->getDateBirthday()['day']}}">{{$user->getDateBirthday()['day']}}</option>
								            @endif
								            <option style="width: 100%" value="">- число -</option>
								            @for($d = 1; $d<32; $d++)
								            	<option style="width: 100%" value="{{$d}}">{{$d}}</option>
											@endfor
							            </select>
						            </div>
								</div> <!-- end "col-sm-3" -->
								
					        </div>  <!-- end "box-body" -->	      
					      	
					      	<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->
					      	
					      	<div class="box-body col-sm-12">
						    	<!-- Наличие детей -->
								<div class="col-sm-4">
						      		<div class="form-group">
						              	Наличие детей &nbsp; 
						              	<select class="form-control select2" name="children" id="children" style="width: 100%;">
						              		<option selected style="width: 100%" value="{{$user->getChildren()[0]}}">{{$user->getChildren()[1]}}</option>
								            <option style="width: 100%" value="">- Есть дети? -</option>
								            <option style="width: 100%" value="1">Есть</option>
								            <option style="width: 100%" value="2">Нет</option>
							            </select>
						            </div>
								</div>
						    	<!-- Наличие автомобиля -->
								<div class="col-sm-4">
						      		<div class="form-group">
						              Наличие автомобиля &nbsp; 
						              <select class="form-control select2" name="availability" id="availability" style="width: 100%;">
								        <option selected style="width: 100%" value="{{$user->getCar()[0]}}">{{$user->getCar()[1]}}</option>
								        <option style="width: 100%" value="1">Есть</option>
								        <option style="width: 100%" value="2">Нет</option>
							          </select>
						            </div> 
								</div> <!-- end "col-sm-4" -->
								
								<div class="col-sm-4">
						      		<div class="form-group">
						            </div> 
								</div> <!-- end "col-sm-4" -->
						    </div>  <!-- end "box-body" -->
						    
						    <div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->
						    
						    <div class="box-body col-sm-12"> 
						    	<div class="col-sm-9">
							        <!-- /.box-body -->
							        <div class="box-footer">
							          <button type="submit" class="btn1 pull-right">Применить изменения</button>
							        </div>
							    </div> <!-- /"col-sm-9"-->
						    </div>  <!-- /.box-footer-->
						    <p>&nbsp;</p>
					      </div>

					</div><!--/Данные пользователя-->
				</form>
					
					
					
					
					<div class="features_items"><!--***-->

					</div> <!--/***-->
					

				
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Вы не можете изменить информацию профиля данного пользователя</label>
					</div>
				@endif	
				</div>
			</div>
		</div>
	</section>

	
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
