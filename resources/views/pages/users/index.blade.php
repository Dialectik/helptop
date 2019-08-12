@push('styles')



@endpush

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
						  <li class="active">Мой профиль</li>
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
				@if(null != $user)
					<div class="features_items"><!--Данные пользователя-->
						<h2 class="title text-center" >Настройки <small>пользователя</small> {{ $user->name }}</h2>
						<!-- Default box -->
					      <div class="box">
					        <!-- Регистрационные данные -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-3">
					            <div class="form-group">
					              Логин &nbsp; 
					              <span style="color:#0D1291"><?php echo $user->name ?></span>
					            </div>  <!-- end "col-sm-3" -->
					          </div>
					          <div class="col-sm-3">
					            <div class="form-group">
					              E-mail &nbsp; 
					             <span style="color:#0D1291"><?php echo $user->email ?></span>
					            </div>
					          </div>  <!-- end "col-sm-3" -->
					          <div class="col-sm-3">
					            <div class="form-group">
					            </div>
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
						              <span style="color:#0D1291">{{$user->first_name}}</span>
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Отчество -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              Отчество &nbsp; 
						             <span style="color:#0D1291">{{$user->getPatronymic()}}</span>
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Фамилия -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              Фамилия &nbsp; 
						              <span style="color:#0D1291">{{$user->getLastName()}}</span>
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
					              <p><span style="color:#0D1291">{{$user->firm}}</span></p>
					            </div>
					          </div>
					          <div class="col-sm-8">
					            <div class="form-group">
					              Краткое описание фирмы (пользователь – о себе) &nbsp;
				              	  <p><span style="color:#0D1291"><?php echo $user->getDescription() ?></span></p>
					            </div>
						      </div>  <!-- end "col-sm-6" -->
						    </div>  <!-- end "box-body" -->

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

							<!-- Номер телефона -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-8">
					            <div class="form-group">
					              Номер телефона (для идентификации пользователя и доступа) &nbsp; 
					              <span style="color:#0D1291">{{$user->getPhone()}}</span>
					            </div>
					          </div>  <!-- end "col-sm-8" -->
					          <div class="col-sm-4">
					            <div class="form-group">
					            </div>
					          </div>  <!-- end "col-sm-4" -->
					        </div>  <!-- end "box-body" -->			

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

						    <!-- Личные данные -->  
					        <div class="box-body col-sm-12">
								<div class="col-sm-4">
						      		<div class="form-group">
						             	Пол &nbsp; 
						              	<span style="color:#0D1291">{{$user->getSex()[1]}}</span>
						            </div>
								</div>
								<!-- Семейное положение -->
								<div class="col-sm-4">
						      		<div class="form-group">
						              	Семейное положение &nbsp; 
						              	<span style="color:#0D1291">{{$user->getMaritalStatus()[1]}}</span>
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
							            @if(!empty($user->getDateBirthday()))
								            <span style="color:#0D1291">{{$user->getDateBirthday()['year']}}</span>
								        @endif
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Месяц -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              	Месяц &nbsp; 
										@if(!empty($user->getDateBirthday()))
								            <span style="color:#0D1291">{{$months[$user->getDateBirthday()['month'] - 1]}}</span>
								        @endif
						            </div>
								</div> <!-- end "col-sm-3" -->
								<!-- Число -->
								<div class="col-sm-3">
						      		<div class="form-group">
						              	Число &nbsp; 
							            @if(!empty($user->getDateBirthday()))
								            <span style="color:#0D1291">{{$user->getDateBirthday()['day']}}</span>
								        @endif
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
						              	<p><span style="color:#0D1291">{{$user->getChildren()[1]}}</span></p>
						            </div>
								</div>
						    	<!-- Наличие автомобиля -->
								<div class="col-sm-4">
						      		<div class="form-group">
						              Наличие автомобиля &nbsp; 
						              <p><span style="color:#0D1291">{{$user->getCar()[1]}}</span></p>
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
							          <a class="btn1 pull-right" href="{{ route('myprofile.edit', $user->id) }}">Изменить</a>
							        </div>
							    </div> <!-- /"col-sm-9"-->
						    </div>  <!-- /.box-footer-->
					      </div>
					      <!-- /.box -->


					</div><!--/Данные пользователя-->
					
					
					
					
					
					<div class="features_items"><!--***-->
						
						



					</div> <!--/***-->
					

				
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Страница пользователя не найдена...</label>
					</div>
				@endif	
				</div>
			</div>
		</div>
	</section>

	
@endsection



