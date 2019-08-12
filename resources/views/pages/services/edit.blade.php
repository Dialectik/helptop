@push('styles')
	<style>
      	#category_id_v, #category_title, #kind_id_v, #kind_title {
			display: none; 
		}
		
      	#bidding_12, #bidding_13, #bidding_14, #bidding_15, #bidding_16, #bidding_17 {
		 	display: none; 
		}
		
		#price_buy_now1, #price_sell_now1, #price_lower1, #bet_step1, #price_start1 {
		 	display: none; 
		}
		
		#period_un, #district_all, #address_un, #not_enough_public, #not_enough_blurb, #not_public {
			display: none;
		}
		
		#city_v, #district_v, #street_v, #house_v, #city_title, #district_title, #street_title, #house_title, #address_un {
			display: none;
		}

	</style>
	
	
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
						    @if($sell_buy && $sell_buy == 1)
						  		<li><a href="{{ route('service.mysell') }}"><i class="fa fa-gavel"></i>&nbsp;&nbsp; @lang('layouts.my_sale_ads')</a></li>
						  	@else
						  		<li><a href="{{ route('service.mybuy') }}"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp; @lang('layouts.my_purchase')</a></li>
						  	@endif
						  <li class="active">Обновление (изменение) услуги в разделе "
						  	@if($sell_buy && $sell_buy == 1)
						  		@lang('layouts.my_sale_ads')
						  	@else
						  		@lang('layouts.my_purchase')
						  	@endif
						  	"
						  </li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
  
  
  
  
	  <!-- Content Wrapper. Contains page content -->
	  <section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3"> <!--left-sidebar-->
					<div class="form-group">
		              @if(null != $user->id && $user->id == Auth::user()->id)
			              <img src="{{$user->getImage()}}" alt="" width="200" class="img-responsive">
			              <label for="exampleInputFile" style="color:#0D1291">{{ $user->name }}</label>
			            @endif
		            </div>
					
					<!--left-sidebar-->
					@include('layouts._sidebar_myprofile')
				</div>
				
				<div class="col-sm-9 padding-right">
		
					<!--Показывать страницу только если найден пользователь-->
					@if(null != $user->id && $user->id == Auth::user()->id)
					<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
					<form method="POST" action="{{ route('service.update', $service->id) }}" enctype="multipart/form-data"> 
					  @csrf
					  <input type="hidden" name="_method" value="PUT">

					
				      <!-- Default box -->
				      <div class="box">
				        <div class="box-header with-border">
				          <h3 class="box-title">Изменяем услугу - отредактируйте любую информацию по данной услуге</h3>
				          @include('admin.errors')
				        </div>
				        
				        <div class="box-body">
				          <div class="col-sm-12">
				            <!-- Название -->
				            <div class="form-group">
				              <label for="exampleInputEmail1">Название</label>
				              <input type="text" class="form-control" id="title" placeholder="" name="title" value="{{$service->title}}" maxlength="240" required>
				            </div>
				            
				                <!-- Раздел -->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Раздел</label>
						              <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;" required>
							              	<option selected="selected" value="{{$service->section_id}}">{{$service->getSectionTitle()}}</option>
							              	@foreach($sections as $section)
						                		<option value="{{$section->id}}">{{$section->title}}</option>
						              		@endforeach
						              </select>
					            </div>
					         </div>
				            
				            <p></p>
				            <p></p>
				            
				                <!-- Категория -->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Категория</label>
						            <input type="text" name="category_title" id="category_title" value="{{$service->getCategoryTitle()}}" style="width: 100%;" />
									<input type="hidden" name="category_id" id="category_id" value="{{$service->category_id}}" />
									<select  name="category_id_v" id="category_id_v" style="width: 100%;">
									</select>
					            </div>
				            </div>
				            
				             	<!-- Вид услуг -->
					        <div class="col-sm-4">    
					            <div class="form-group">
					              <label>Вид услуг</label>
						            <input type="text" name="kind_title" id="kind_title" value="{{$service->getKindTitle()}}" style="width: 100%;" />
									<input type="hidden" name="kind_id" id="kind_id" value="{{$service->kind_id}}" />
									<select  name="kind_id_v" id="kind_id_v" style="width: 100%;">
									</select>
					            </div>
				            </div>
				          </div>  <!-- end "col-sm-12" -->
				        </div>  <!-- end "box-body" -->
						
						
						<div class="box-body">
				          <div class="col-sm-12">
				          	<div class="col-sm-6">
				             	<!-- Лицевая картинка услуги -->            
					            <div class="form-group">
					              	<img src="{{$service->getImage()}}" alt="" class="img-responsive" width="200">
				              		<p></p>
				              		<p></p>
					              	<label for="exampleInputFile">Лицевая картинка услуги</label>
					              	<input type="file" id="exampleInputFile" name="image">
					              	<p class="help-block">Выберете графический файл для лицевой картинки услуги</p>
					            </div>
					        </div>
					        <div class="col-sm-6">
					        	<div class="form-group">
						          <label for="exampleInputEmail1">Товарный код услуги</label>
						          <span class="help-block">Формируестя автоматически</span>
						          <input type="text" class="form-control" id="c_code" placeholder="" name="c_code" value="{{substr($service->product_code_id, 0, 6) . '-' . substr($service->product_code_id, 6, 4)}}" disabled>
						        </div>
					        </div>
				          </div>  <!-- end "col-sm-12" -->
				        </div>  <!-- end "box-body" -->
				            
				            
				        <div class="box-body">  
				          <div class="col-sm-12">  
					        
					        <!-- Тип торгов -->
					        <div class="col-sm-4">
					          <div class="form-group">
					        	<label for="exampleInputEmail1">Тип торгов</label>
								<p class="help-block">Выберете тип ТОРГОВ</p>
					        		        	
								<select class="form-control select2" name="bidding_type" id="bidding_type" style="width: 100%;" required>
						              <option selected style="width: 100%" value="{{$service->bidding_type}}">{{$service->biddingTypeTitle()}}</option>
							        @foreach($bidding_types as $bidding_type)
						                <option value="{{$bidding_type->id}}">{{$bidding_type->title}}</option>
						            @endforeach
				               </select>

					          </div>	
					        </div>
					        
					        <!-- Комментарий по типу торгов -->
					        <div class="col-sm-4" id="bidding_all">
						        <div class="form-group" >
									<p id="bidding_12">При таком типе торгов, Вы как Поставщик услуги предлагаете приобрести ее по ФИКСИРОВАННОЙ цене. Соответственно необходимо сразу Вам определится с ценой, а клиенту - согласен ли он по этой цене и согласно приведенному описанию услуги ее приобрести</p>
									<p id="bidding_13">Если Вы Заказчик услуг и Вам нужна услуга с определенными параметрами, условиями и по Вашей ФИКСИРОВАННОЙ цене – этот тип торгов то, что нужно. После объявления данной услуги Поставщики рассмотрят данное предложение и в случае их согласия нажмут кнопку «Продать сразу»</p>
									<p id="bidding_14">Именно Аукцион подойдет Поставщику услуги, если Ваша услуга редкая и привлекательная. Установив изначально невысокую цену на Аукционе, Вы можете получить ее значительный рост в результате конкуренции Покупателей – участников торгов. Выиграет Покупатель, назначивший наивысшую ставку до срока завершения торгов, который устанавливаете Вы – Поставщик услуги</p>
									<p id="bidding_15">Выбирайте этот тип торгов, если Вы Заказчик услуг и хотите объявить Тендер на предоставления услуги на Ваших условиях по выгодной для Вас цене. При объявлении Тендера Вы как Заказчик устанавливаете максимально приемлемую для Вас цену, а Поставщики услуг соревнуются в торгах снижая цену до того уровня, который будет минимально приемлем для них. Выиграет Поставщик, который предложит минимальную цену до момента завершения торгов, который устанавливает Заказчик</p>
									<p id="bidding_16">Данный тип торгов, инициируемый Поставщиком услуг, совмещает в себе преимущества проведения Аукциона, в котором выигрывает Покупатель, предложивший наивысшую цену, и возможность Покупателей приобрести услугу по ФИКСИРОВАННОЙ цене сразу без участия в торгах (нажав на кнопку «Купить сразу»)</p>
									<p id="bidding_17">Данный тип торгов, инициируемый Заказчиком услуг, совмещает в себе преимущества проведения Тендера, в котором выигрывает Поставщик услуг, предложивший наименьшую цену, и возможность Поставщиков услуг продать услугу по ФИКСИРОВАННОЙ цене сразу без участия в торгах (нажав на кнопку «Продать сразу»).</p>
											        	  
						        </div>
					        </div>
					        
					        <!-- Цена -->
					        <div class="col-sm-4" id="price_start1">
						        <div class="form-group">
						        	<label for="exampleInputEmail1">Цена услуги</label>
									<p class="help-block">Укажите начальную цену услуги</p>
						        	
						        	<input type="number" min="0" class="form-control" id="price_start" placeholder="" name="price_start" value="{{$service->price_start}}" >               		<span>  грн</span>  
						        </div>
					        </div>
					        
				          </div>  <!-- end "col-sm-12" -->
				        </div> <!-- end "box-body" --> 
				            
				            
				        <div class="box-body">
				          <div class="col-sm-12">
				                        
				             	<!-- Цена "Купить сразу" -->
					        <div class="col-sm-4" id="price_buy_now1">    
					            <div class="form-group">
					              <label>Цена "Купить сразу"</label>
						              <input type="number" min="0" class="form-control" id="price_buy_now" placeholder="" name="price_buy_now" value="{{$service->price_buy_now}}" >               		<span>  грн</span>
					            </div>
				            </div>
				            
				                <!-- Цена "Продать сразу" -->
					        <div class="col-sm-4" id="price_sell_now1">    
					            <div class="form-group">
					              <label>Цена "Продать сразу"</label>
						              <input type="number" min="0" class="form-control" id="price_sell_now" placeholder="" name="price_sell_now" value="{{$service->price_sell_now}}" >               		<span>  грн</span>
					            </div>
				            </div>
				            
				           
				            	<!-- Нижняя граница цены (для Тендеров и Аукционов) -->
					        <div class="col-sm-4" id="price_lower1">    
					            <div class="form-group">
					              <label>Нижняя граница цены</label>
						              <input type="number" min="0" class="form-control" id="price_lower" placeholder="" name="price_lower" value="{{$service->price_lower}}" >               		<span>  грн</span>
					            </div>
				            </div>
				            
				                <!-- Шаг ставки -->
					        <div class="col-sm-4" id="bet_step1">    
					            <div class="form-group">
					              <label>Шаг ставки</label>
						              <input type="number" min="0" class="form-control" id="bet_step" placeholder="" name="bet_step" value="{{$service->bet_step}}" >               		<span>  грн</span>
					            </div>
				            </div>
				             
				          </div>  <!-- end "col-sm-12" -->
				         </div>  <!-- end "box-body" -->
				        
				        
				        
				        <div class="box-body">
				          <div class="col-sm-12">
				                        
				                <!-- Количество единиц (сеансов) услуги в наличии -->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Количество единиц (сеансов) услуги в наличии</label>
						              <input type="number" min="0" class="form-control" id="number_total" placeholder="" name="number_total" value="{{$service->number_total}}" required>               		<span>  единиц</span>
					            </div>
					         </div>
				            
				           
				            
				                <!-- Места предоставления услуги -->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Место предоставления услуги</label>
						              <select class="form-control select2" name="place_id" id="place_id" style="width: 100%;" required>
							              	<option selected style="width: 100%" value="{{$service->place_id}}">
							              		<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любое в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любое в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
			              					</option>
							              	<option style="width: 100%" value="11">По адресу Заказчика</option>
							              	<option style="width: 100%" value="12">По адресу Поставщика</option>
							              	<option style="width: 100%" value="13">Любое в городе Заказчика</option>
							              	<option style="width: 100%" value="14">Любое в городе Поставщика</option>
							              	<option style="width: 100%" value="15">Выезд в другой город</option>
							              	<option style="width: 100%" value="16">Любое место</option>
						              </select>
					            </div>
				            </div>
				            
				     
				          </div>  <!-- end "col-sm-12" -->
				        </div>  <!-- end "box-body" -->
				            
				      
				            
				            
				            <p></p>
				            <p></p>  <!-- Даты публикации -->
				        <div class="box-body">
				          <div class="col-sm-12">  
				                 <!-- Date -->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Период публикации:</label>
					                <select class="form-control select2" name="period" id="period" style="width: 100%;" required>
							              	<option selected style="width: 100%" value="">- выберите период -</option>
							              	<option style="width: 100%" value="1">1 день</option>
							              	<option style="width: 100%" value="3">3 дня</option>
							              	<option style="width: 100%" value="7">7 дней</option>
							              	<option style="width: 100%" value="14">14 дней</option>
							              	<option style="width: 100%" value="21">21 день</option>
							              	<option style="width: 100%" value="28">28 дней</option>
					               </select>
					      
					            </div>
							</div>
										
							<div class="col-sm-4">
					            <div class="form-group">
					              <label>Дата старта публикации:</label>

					              <div class="input-group date">
					                <div class="input-group-addon">
					                  <i class="fa fa-calendar"></i>
					                </div>
					                <input type="text" class="form-control" name="date_start" id="date_start" disabled>
					                <!-- Скрытое поле  "date_on" из базы данных-->
					                <input type="hidden" name="date_on_bd" id="date_on_bd" value="{{$service->date_on}}">
					                <!-- Скрытая передача поля  "date_on"-->
					                <input type="hidden" name="date_on" id="date_on">
					                <!-- Скрытая передача смещения часового пояса пользователя относительно 'UTC'-->
					                <input type="hidden" name="date_offset" id="date_offset">
					              </div>
					            </div>
				            </div>
				            
				            <div class="col-sm-4">
					            <div class="form-group">
					              <label>Дата завершения:</label>

					              <div class="input-group date">
					                <div class="input-group-addon">
					                  <i class="fa fa-calendar"></i>
					                </div>
					                <input type="text" class="form-control" name="date_end" id="date_end" disabled>
					                <!-- Скрытое поле  "date_off" из базы данных-->
					                <input type="hidden" name="date_off_bd" id="date_off_bd" value="{{$service->date_off}}">
					                <!-- Скрытая передача поля  "date_off"-->
					                <input type="hidden" name="date_off" id="date_off">
					              </div>
					            </div>
				            </div>
           
				          </div> <!-- end "col-sm-12" -->
				          
				          <!-- Краткое описание услуги -->
				          <div class="col-sm-7">
				            <div class="form-group">
				              <label for="exampleInputEmail1">Краткое описание услуги</label>
				              <p class="help-block">Опишите кратко предлагаемую услугу для представления ее в перечнях услуг при поиске</p>
				              <textarea name="description" id="description" cols="30" rows="10" class="form-control" maxlength="300" required >{{$service->getDescription()}}</textarea>
					        </div>
					      </div>
					      <!-- Рекламный слоган для услуги -->
				          <div class="col-sm-5">
				            <div class="form-group">
				              <label for="exampleInputEmail1">Рекламный слоган для услуги</label>
				              <p class="help-block">Если Вы планируете рекламировать данную услугу - придумайте сразу для нее рекламный слоган, который будет отображаться на заглавной странице</p>
				              <textarea name="slogan" id="slogan" cols="10" rows="5" class="form-control" maxlength="70"  >{{$service->serviceDesc->slogan}}</textarea>
					        </div>
					      </div>
				          <!-- Полное описание услуги -->
				          <div class="col-sm-10">
				            <div class="form-group">
				              <label for="exampleInputEmail1">Полное описание услуги</label>
				              <p class="help-block">Дайте исчерпывающе полное описание услуги для показа его на странице данной услуги</p>
				              <textarea name="content" id="content" cols="30" rows="20" class="form-control" maxlength="5000" required >{{$service->getContent()}}</textarea>
					        </div>
					      </div>
					        
				      </div>  <!-- end "box-body" -->
				      
				      
				      
				        <p></p>
				        <p></p>  <!-- Объем услуги и Дополнительные материалы -->
						<div class="box-body">
							<div class="col-sm-12">  
								<!-- Объем и структура услуги -->
								<div class="col-sm-6">
						            <div class="form-group">
						              <label for="exampleInputEmail1">Объем и структура услуги</label>
						              <p class="help-block">Изложите структуру услуги, что входит в объем, какие этапы предоставления</p>
						              <textarea name="value_service" id="value_service" cols="30" rows="10" class="form-control" >{{$service->getValueService()}}</textarea>
							        </div>
								</div>
								<!-- Дополнительные материалы -->			
								<div class="col-sm-6">
						            <div class="form-group">
						              <label for="exampleInputEmail1">Дополнительные материалы</label>
						              <p class="help-block">Опишите Дополнительные материалы, не входящие в стоимость услуги</p>
						              <textarea name="add_materials" id="add_materials" cols="30" rows="10" class="form-control" >{{$service->getAddMaterials()}}</textarea>
							        </div>
								</div>
							</div>  <!-- end "col-sm-12" -->
						</div>  <!-- end "box-body" -->
						
						
						
						<p></p>
				        <p></p> <!-- Дни до начального и конечного срока предоставления услуги -->
				        <div class="box-body">
				          <div class="col-sm-12">  
				            <!-- Date period_initial-->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Дни до начального срока предоставления услуги</label>
					              <p class="help-block">Период времени после сделки, когда может раньше всего быть предоставлена услуга - первый день предоставления услуги</p>
					                <select class="form-control select2" name="period_initial" id="period_initial" style="width: 100%;" required>
							              	<option selected style="width: 100%" value="{{$service->getPeriodInitial()}}">{{$service->getPeriodInitial()}} дней</option>
							              	<option style="width: 100%" value="1">1 день</option>
							              	<option style="width: 100%" value="3">3 дня</option>
							              	<option style="width: 100%" value="7">7 дней</option>
							              	<option style="width: 100%" value="14">14 дней</option>
							              	<option style="width: 100%" value="21">21 день</option>
							              	<option style="width: 100%" value="28">28 дней</option>
					               </select>
					            </div>
							</div>

							<!-- Date period_deadline-->
					        <div class="col-sm-4">
					            <div class="form-group">
					              <label>Дни до конечного срока предоставления услуги</label>
					              <p class="help-block">Период времени от сделки, до момента, когда услуга уже не может быть предоставлена – сделка аннулируется</p>
					                <select class="form-control select2" name="period_deadline" id="period_deadline" style="width: 100%;" required>
							              	<option selected style="width: 100%" value="{{$service->getPeriodDeadline()}}">{{$service->getPeriodDeadline()}} дней</option>
							              	<option style="width: 100%" value="3">3 дня</option>
							              	<option style="width: 100%" value="7">7 дней</option>
							              	<option style="width: 100%" value="14">14 дней</option>
							              	<option style="width: 100%" value="21">21 день</option>
							              	<option style="width: 100%" value="28">28 дней</option>
							              	<option style="width: 100%" value="56">56 дней</option>
					               </select>
					            </div>
							</div>
							
							<!-- Комментарий по соотношению сроков -->
					        <div class="col-sm-4" id="period_un">
						        <div class="form-group alert alert-danger" >
									Конечная дата не может быть раньше начальной! Выберете срок так, чтобы конечная дата была позже начальной					
						        </div>
					        </div>



							</div>  <!-- end "col-sm-12" -->
						</div>  <!-- end "box-body" -->

						<div class="box-body">
							<div class="col-sm-9">  		
								<!-- График работы -->			
								<div class="col-sm-6">
						            <div class="form-group">
						              <label for="exampleInputEmail1">График работы сервиса услуги</label>
						              <p class="help-block">Укажите расписание работы сервиса услуги (или офиса) - дни и часы, когда может быть предоставлена услуга</p>
						              <textarea name="schedule" id="schedule" cols="30" rows="10" class="form-control" >{{$service->getPeriodSchedule()}}</textarea>
							        </div>
								</div>
							</div>  <!-- end "col-sm-9" -->
						</div>  <!-- end "box-body" -->      

						
						<p></p>
				        <p></p>  <!-- Длительность и результат -->
						<div class="box-body">
							<div class="col-sm-12">  
								<!-- Длительность процесса предоставления услуги в часах-->
								<div class="col-sm-3">
						            <div class="form-group">
										<label>Длительность процесса предоставления услуги в часах</label>
										<input type="number" step="0.1" min="0" class="form-control" id="duration" placeholder="" name="duration" value="{{$service->getDuration()}}">               		<span>  часов</span>
						            </div>
								</div>
								<!-- Результат получения услуги-->
								<div class="col-sm-9">
						            <div class="form-group">
										<label>Результат получения услуги</label>
										<input type="text" class="form-control" id="result" placeholder="" name="result" value="{{$service->getResult()}}" required>      						</div>
								</div>
							</div>  <!-- end "col-sm-12" -->
						</div>  <!-- end "box-body" -->		


						<p></p>
				        <p></p>  <!-- Доступность и условия оплаты услуги-->
						<div class="box-body">
							<div class="col-sm-12">
								<!-- Доступность услуги-->
								<div class="col-sm-4">
						            <div class="form-group">
						              <label>Доступность услуги</label>
						              <p class="help-block">Если предполагается, что услуга доступна и может быть предоставлена в любой момент после заключения сделки - выбирайте - "В наличии", если нет - "Под заказ" (тогда в дополниельной информации нужно указать возможные сроки ожидания)</p>
						                <select class="form-control select2" name="availability" id="availability" style="width: 100%;" required>
							              	<option style="width: 100%" value="{{$service->getAvailability()}}">
							              		<?php
							              			switch ($service->getAvailability()) {
													  case '1':
													    echo 'В наличии';
													    break;
													  case '2':
													    echo 'Под заказ';
													    break;
													  default:
													    break;
													}
							              		?>
							              	</option>
							              	<option style="width: 100%" value="">- выберите доступность -</option>
							              	<option style="width: 100%" value="1">В наличии</option>
							              	<option style="width: 100%" value="2">Под заказ</option>
						               </select>
						            </div>
								</div>
								<!-- Условия оплаты-->
						        <div class="col-sm-4">
						            <div class="form-group">
						              <label>Условия оплаты</label>
						              <p class="help-block">Необходимо указать сроки и этапность оплаты услуги</p>
						                <select class="form-control select2" name="terms_payment" id="terms_payment" style="width: 100%;" required>
							              	<option selected style="width: 100%" value="{{$service->getTermsPayment()}}">
							              		<?php
							              			switch ($service->getTermsPayment()) {
													  case '1':
													    echo 'Предоплата';
													    break;
													  case '2':
													    echo 'Оплата после/в момент получения услуги';
													    break;
													  case '3':
													    echo 'Аванс';
													    break;
													  case '4':
													    echo 'Поэтапная оплата';
													    break;
													  case '5':
													    echo 'Любой способ оплаты';
													    break;
													  default:
													    break;
													}
							              		?>
							              	</option>
							              	<option style="width: 100%" value="1">Предоплата</option>
							              	<option style="width: 100%" value="2">Оплата после/в момент получения услуги</option>
							              	<option style="width: 100%" value="3">Аванс</option>
							              	<option style="width: 100%" value="4">Поэтапная оплата</option>
							              	<option style="width: 100%" value="5">Любой способ оплаты</option>
						               </select>
						            </div>
								</div>
								<div class="col-md-4">    
						            <!-- Расширяемая услуга -->
						            <div class="form-group">
						              <label>
										<?php 
						                	$checked1 = null;
						                	if($service->getExpandable()) $checked1 = 'checked';
						                	echo "<input type='checkbox' class='minimal' name='expandable' id='expandable' value='1' $checked1/>"; 
						                ?> 
						              </label>
						              <label>
						                Расширяемая услуга
						              </label>
						              <p class="help-block">Если до начала предоставления услуги не может быть предусмотрена необходимость применения дополнительных материалов и услуг не входящих в начальную стоимость услуги</p
						            </div>
						            <!-- Масштабируемая услуга -->
						            <div class="form-group">
						              <label>
						                <?php 
						                	$checked2 = null;
						                	if($service->getScalable()) $checked2 = 'checked';
						                	echo "<input type='checkbox' class='minimal' name='scalable' id='scalable' value='1' $checked2/>"; 
						                ?>
						              </label>
						              <label>
						                Масштабируемая услуга
						              </label>
						              <p class="help-block">Если услуга может быть выражена в количественных единицах (например на 1 м кв., 1 точка подключения, 1 стр.)</p
						            </div>
						        </div>
							</div>  <!-- end "col-sm-12" -->
						</div>  <!-- end "box-body" -->		

				        <p></p>
				        <p></p>  <!-- Дополнительные условия -->
						<div class="box-body">
							<div class="col-sm-12">  
								<!-- Условия предоставления -->
								<div class="col-sm-6">
						            <div class="form-group">
						              <label for="exampleInputEmail1">Условия предоставления</label>
						              <p class="help-block">Изложите какие условия должен соблюсти контрагент для успешного прохождения процесса предоставления услуги и ее оплаты</p>
						              <textarea name="terms_provision" id="terms_provision" cols="30" rows="10" class="form-control" >{{$service->getTermsProvision()}}</textarea>
							        </div>
								</div>
								<!-- Дополнительные условия -->			
								<div class="col-sm-6">
						            <div class="form-group">
						              <label for="exampleInputEmail1">Дополнительные условия</label>
						              <p class="help-block">Опишите Дополнительные условия, которые нужно учесть контрагенту перед участием в торгах по данной услуге</p>
						              <textarea name="add_terms" id="add_terms" cols="30" rows="10" class="form-control" >{{$service->getAddTerms()}}</textarea>
							        </div>
								</div>
							</div>  <!-- end "col-sm-12" -->
						</div>  <!-- end "box-body" -->
						
						<p></p>
				        <p></p>  <!-- Адрес предоставления услуги -->
						<div class="box-body">
							<label>Основной Адрес предоставления услуги (дополнительные - укажите в дополнительных условиях)</label>
							<div class="col-sm-12">
					            <!-- Область -->
						        <div class="col-sm-2">
						            <div class="form-group">
						              <label>Область</label>
							              <select class="form-control select2" name="region" id="region" style="width: 100%;" >
								              	<option selected value="{{$service->getRegion()}}">{{$service->getRegion()}}</option>
								              	@foreach($uaddress as $uaddr)
							                		<option value="{{$uaddr->region}}">{{$uaddr->region}}</option>
							              		@endforeach
							              </select>
						            </div>
						         </div>
					            <!-- Город -->
						        <div class="col-sm-3">
						            <div class="form-group">
						              <label>Город</label>
							              <input type="text" name="city_title" id="city_title" value="{{$service->getCity()}}" style="width: 100%;" />
										  <input type="hidden" name="city" id="city" value="{{$service->getCity()}}" />
			              				  <select  name="city_v" id="city_v" style="width: 100%;" >
			              				  </select>
						            </div>
					            </div>
								<!-- Район -->
						        <div class="col-sm-2" id="district_all">    
						            <div class="form-group">
						              <label>Район</label>
							              <input type="text" name="district_title" id="district_title" value="{{$service->getDistrict()}}" style="width: 100%;" />
										  <input type="hidden" name="district" id="district" value="{{$service->getDistrict()}}" />
										  <input type="hidden" name="district_er" id="district_er"/>
			              				  <select  name="district_v" id="district_v" style="width: 100%;">
			              				  </select>
						            </div>
					            </div>
					            <!-- Улица -->
						        <div class="col-sm-2">    
						            <div class="form-group">
						              <label>Улица</label>
							              <input type="text" name="street_title" id="street_title" value="{{$service->getStreet()}}" style="width: 100%;" />
										  <input type="hidden" name="street" id="street" value="{{$service->getStreet()}}" />
			              				  <select  name="street_v" id="street_v" style="width: 100%;">
			              				  </select>
						            </div>
					            </div>
					            <!-- Дом -->
						        <div class="col-sm-2">    
						            <div class="form-group">
						              <label>Дом</label>
							              <input type="text" name="house_title" id="house_title" value="{{$service->getHouse()}}" style="width: 100%;" />
										  <input type="hidden" name="house" id="house" value="{{$service->getHouse()}}" />
			              				  <select  name="house_v" id="house_v" style="width: 100%;">
			              				  </select>
						            </div>
					            </div>
					            
					            <!-- Комментарий по содержанию полей адреса -->
						        <div class="col-sm-8" id="address_un">
							        <div class="form-group alert alert-info" >
										Вы можете заполнять не все поля адреса, но чем подробнее, тем вероятнее Ваш клиент заметит объявление на сайте
							        </div>
						        </div>


							</div>  <!-- end "col-sm-12" -->
						</div>  <!-- end "box-body" -->

				        
				        <!-- /.box-body -->
				        <div class="box-footer col-sm-12">
					        <p>&nbsp;</p>
					        <div class="col-sm-4"></div>
					        <div class="col-sm-4"></div>
							<div class="col-sm-4">
					        	<a href="#window4" class="btn1 pull-right">
									@if($sell_buy == 1)
								  		<i class="fa fa-gavel"></i>&nbsp;&nbsp;
								  	@elseif($sell_buy == 2)
								  		<i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;
								    @endif
									Опубликовать услугу
								</a>
							</div>
				        </div>
				        
				        <!--Передача цен на публикацию услуг и диапазонов цен в JavaScript-->
				        <input type="hidden" id="bidding_rate1" name="bidding_rate1" value="{{ $bidding_rate1 }}"  />
				        <input type="hidden" id="bidding_rate2" name="bidding_rate2" value="{{ $bidding_rate2 }}"  />
				        <input type="hidden" id="bidding_rate3" name="bidding_rate3" value="{{ $bidding_rate3 }}"  />
				        <input type="hidden" id="bidding_rate4" name="bidding_rate4" value="{{ $bidding_rate4 }}"  />
				        
				        <input type="hidden" id="bidding_price1" name="bidding_price1" value="{{ $bidding_price1 }}"  />
				        <input type="hidden" id="bidding_price2" name="bidding_price2" value="{{ $bidding_price2 }}"  />
				        <input type="hidden" id="bidding_price3" name="bidding_price3" value="{{ $bidding_price3 }}"  />
				        <input type="hidden" id="bidding_price4" name="bidding_price4" value="{{ $bidding_price4 }}"  />
				        
				        <!--Передача цен на рекламу и периодов рекламы в JavaScript-->
				        <input type="hidden" id="blurb_prises" name="blurb_prises" value="{{ $blurb_prises }}"  />
				        <input type="hidden" id="blurb_periods" name="blurb_periods" value="{{ $blurb_periods }}"  />
				        <!--Передача баланса счета пользователя в JavaScript-->
				        <input type="hidden" id="balance0" name="balance0" value="{{ $balance0 }}"  />
				        
				        <!--Передача периодов предоставления рекламы-->
				        <input type="hidden" id="date_on_blurb" name="date_on_blurb" />
				        <input type="hidden" id="date_off_blurb" name="date_off_blurb" />
				        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}" />
				        
				        <!--Всплывающее окно подтверждения создания/публикации услуги-->
						<div id="window4"> <!--покупки/продажи-->
						      <div id="okno4">
						        @if($allow_free)
									Данная услуга может быть опубликована бесплатно
									<!--Передача в контроллер команды публиковать услугу (без предварительного просмотра)-->
				        			<input type="hidden" id="allow_public" name="allow_public" value="1"  />
								@else
									<div style="text-align: left">Количество бесплатных публикаций исчерпано.<br />
										Для публикации данной услуги необходимо использовать платную опцию по тарифу 
										<input type="text" id="bidding_rate" name="bidding_rate" style="width: 50px; text-align: center;" disabled /> грн
									</div>
									<p>&nbsp;</p>
								@endif
									<p>&nbsp;</p>
									<div style="text-align: left" class="col-md-12">
										Также предлагаем Вам для увеличения отклика клиентов воспользоваться одним из рекламных пакетов
										<p></p>
										<div class="col-sm-7">
											<label>Название</label>
											<select class="form-control select2" name="blurb_type_id" id="blurb_type_id" style="width: 100%;" >
								              	<option value="">- выберите рекламный пакет -</option>
								              	@foreach($blurb_types as $blurb_type)
							                		<option value="{{$blurb_type->id}}">{{$blurb_type->title}}</option>
							              		@endforeach
								            </select>
										</div>
										
										<div class="col-sm-2">
											<label>Период</label>
											<input type="text" id="period_blurb" name="period_blurb" style="width: 50px; text-align: center;" disabled />
											дней
										</div> 
										
										<div class="col-sm-3">
											<label>Стоимость</label>
											<input type="text" id="price_blurb" name="price_blurb" style="width: 50px; text-align: center;" disabled />
											грн
										</div> 
							        </div>
								<div class="col-md-12">
						        	<hr /> <!-- горизонтальная линия -->
						        </div>  <!-- end "col-md-12" -->
								
								<div class="col-md-12">
						        	<!--Галочка о принятии условий и тарифов-->
						        	<input class="form-check-input" type="checkbox" name="accept" id="remember" {{ old('accept') ? 'checked' : '' }} >
						        	Для публикации подтвердите согласие с <a href="/refer/3">Условиями</a> и <a href="/refer/4">Тарифами</a>
						        </div>  <!-- end "col-md-12" -->
								<p>&nbsp;</p>
						        <div class="col-sm-12">	
						        	<div class="col-sm-4">
						        		<a href="" class="close" >Cancel</a>  
						        	</div>
						        	<div class="col-sm-6" id="allow_public">
							        	<button type="submit" class="btn btn-fefault cart">
											<i class="fa fa-rss"></i> Опубликовать услугу
										</button>
									</div>
									<div class="col-sm-6" id="not_public">
							        	<button type="submit" class="btn btn-fefault cart">
											<i class="fa fa-ban"></i> Сохранить в архиве
										</button>
									</div>
						        </div>
						        <div class="col-md-12 alert alert-danger" id="not_enough_public">
						        	На балансе не достаточно средств для публикации услуги! Сохранить в архиве?
						        </div>
						        <div class="col-md-12 alert alert-danger" id="not_enough_blurb">
						        	На балансе не достаточно средств для использования выбранной рекламной опции! Сохранить в архиве?
						        </div>
						      </div>
					      
							
					    </div> <!--/покупки/продажи-->
				        
				        
				        
				        <!-- /.box-footer-->
				      </div>
				      <!-- /.box -->
					</form>

					@else
						<div class="order-message">
							<p>&nbsp;</p>
							<label style="font-weight:bold;">
								Перед использованием сервиса необходимо 
				            	<a class="nav-link" href="/login">войти</a>
				            	 или 
				            	 <a class="nav-link" href="/register">зарегистрироваться</a>
							</label>
						</div>
					@endif	

				</div> <!--/"col-sm-9 padding-right"-->
			</div> <!--/"row"-->
		</div> <!--/"container"-->
		<p>&nbsp;</p>
	</section>
	  <!-- /.content-wrapper -->




@endsection

@push('scripts')

<!-- Показ предупреждений о корректности выбора сроков предоставления услуги -->
<script type="text/javascript">
    jQuery(document).ready(function($){
		var $pin0 = $("#period_initial").val();
		var $pde0 = $("#period_deadline").val();
		if(($pde0 - $pin0 < 0 || $pde0 == $pin0) & $pde0 != 0 & $pin0 != 0){
			$("#period_un").css("display", "inline-block");
		}else{
			$("#period_un").css("display", "none");
		}
	});
    
    $('#period_initial').change(function(){
		var $pin = $(this).val();
		var $pde = $("#period_deadline").val();
		if(($pde - $pin < 0 || $pde == $pin) & $pde != 0 & $pin != 0){
			$("#period_un").css("display", "inline-block");
		}else{
			$("#period_un").css("display", "none");
		}
	});
	$('#period_deadline').change(function(){
		var $pin1 = $("#period_initial").val();
		var $pde1 = $(this).val();
		if(($pde1 - $pin1 < 0 || $pde1 == $pin1) & $pde1 != 0 & $pin1 != 0){
			$("#period_un").css("display", "inline-block");
		}else{
			$("#period_un").css("display", "none");
		}
	});
</script>

<!-- Если курсор мышки будет наведен на категории и виды услуги -->
<script type="text/javascript">
	//Если курсор мышки будет наведен на категории и виды услуги
	$(document).ready(function(){
        $("#category_title").css("display", "inline-block");
        $("#kind_title").css("display", "inline-block");
        
        $('#category_title').bind('mouseover', function(){
		    $("#category_title").css("display", "none");
		    $("#category_id_v").css("display", "inline-block");
		    $("#category_id_v").addClass('form-control');
		    $("#category_id_v").addClass('select2');
		    
		    var sectionID = $("#section_id").val();
		    /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getcat')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id_v").empty();
                    $("#category_id_v").append('<option value="">- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id_v").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   	$("#category_id_v").empty();
                   	                   	
                   	$("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                	$("#c_code").empty();
                	//$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            }); //end $.ajax
		}); //end $('#category_title').bind
		
		
		$('#kind_title').bind('mouseover', function(){
		    $("#kind_title").css("display", "none");
		    $("#kind_id_v").css("display", "inline-block");
		    $("#kind_id_v").addClass('form-control');
		    $("#kind_id_v").addClass('select2');
		    
		    var categoryID = $("#category_id").val();
		    /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getkind')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#kind_id_v").empty();
                    $("#kind_id_v").append('<option value="">- выберете Вид услуг -</option>');
                    $.each(res,function(key,value){
                        $("#kind_id_v").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   	$("#kind_id_v").empty();
                   	
                   	
                   	$("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                	$("#c_code").empty();
                	//$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
		});
		
        
    })
</script>

<!-- Если будет изменен раздел или категория услуги -->
<script type="text/javascript">
  	$('#section_id').change(function(){
        var sectionID = $(this).val();    
        if(sectionID){
            $("#category_title").css("display", "none");
		    $("#category_id_v").css("display", "inline-block");
		    $("#category_id_v").addClass('form-control');
		    $("#category_id_v").addClass('select2');
		    
            /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getcat')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id_v").empty();
                    $("#category_id_v").append('<option value="">- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id_v").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   	$("#category_id_v").empty();
                   	                   	
                   	$("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                	$("#c_code").empty();
                	//$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#category_id_v").empty();
                        
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            //$("#product_code_id").val('');
            $("#c_code").val('');
            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
        }      
    });
       
    
    $('#category_id_v').on('change', function(){
        var categoryID = $(this).val();    
        if(categoryID){
            $("#kind_title").css("display", "none");
		    $("#kind_id_v").css("display", "inline-block");
		    $("#kind_id_v").addClass('form-control');
		    $("#kind_id_v").addClass('select2');
		    
            /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getkind')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#kind_id_v").empty();
                    $("#kind_id_v").append('<option value="">- выберете Вид услуг -</option>');
                    $.each(res,function(key,value){
                        $("#kind_id_v").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   	$("#kind_id_v").empty();
                   	                   	
                   	$("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                	$("#c_code").empty();
                	//$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#kind_id_v").empty();
                        
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            //$("#product_code_id").val('');
            $("#c_code").val('');
            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
        }      
    });
    
    
    
    
    /*Назначить товарный код услуги для данного вида услуг - следующий по списку - ТЕПЕРЬ ФОРМИРУЕСТСЯ в контроллере ServicesController*/   
/*    $('#kind_id_v').change(function(){
        var kindID = $(this).val();    
        if(kindID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getsercode')}}?kind_id="+kindID,
               success:function(res){               
                if(res){
                    $("#c_code").prop("enabled", true);   // Разблокировка инпута 
	                    $("#c_code").empty();
	                    $("#c_code").val(res.substr(0, 6) + '-' + res.substr(6, 4));
	                    $("#c_code").prop("disabled", true);  // Блокировка инпута 
	                    $("#product_code_id").empty();
	                    $("#product_code_id").val(res);                    
		                }else{
		                    $("#c_code").prop("enabled", true);   // Разблокировка инпута 
				            $("#c_code").empty();
				            $("#c_code").prop("disabled", true);  // Блокировка инпута 
				            $("#product_code_id").empty();
		                }
		               }
		            });
		        }else{
		            $("#c_code").prop("enabled", true);   // Разблокировка инпута 
				    $("#c_code").empty();
				    $("#c_code").val('');					// Очистка инпута 
				    $("#c_code").prop("disabled", true);  // Блокировка инпута 
				    $("#product_code_id").empty();
				    $("#product_code_id").val('');					// Очистка инпута 
		        }      
		    });   */
        
        
</script>

<!-- Связанные списки областей, городов, районов, домов -->
<script type="text/javascript">
    //Связанные списки областей, городов, районов, домов
    $('#region').change(function(){
        var region = $(this).val();    
        if(region){
        	$("#city_title").css("display", "none");
		    $("#city_v").css("display", "inline-block");
		    $("#city_v").addClass('form-control');
		    $("#city_v").addClass('select2');
		    $("#street_title").css("display", "none");
	    	$("#street_v").css("display", "inline-block");
	   		$("#street_v").addClass('form-control');
	    	$("#street_v").addClass('select2');
	    	$("#house_title").css("display", "none");
    		$("#house_v").css("display", "inline-block");
   			$("#house_v").addClass('form-control');
    		$("#house_v").addClass('select2');
        	
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getcities')}}?region="+region,
               success:function(res){               
                if(res){
                    $("#city_v").empty();
                    $("#district_v").empty();
                    $("#street_v").empty();
                    $("#house_v").empty();
                    $("#city_v").append('<option value="">- выберете город -</option>');
                    $.each(res,function(id, value){
                        $("#city_v").append('<option value="'+value+'">'+value+'</option>');
                    });

                }else{
                   $("#city_v").empty();
                   $("#district_v").empty();
                   $("#street_v").empty();
                   $("#house_v").empty();
                }
               }
            });
        }else{
            $("#city_v").empty();
            $("#district_v").empty();
            $("#street_v").empty();
            $("#house_v").empty();
        }      
       });
        
        /*Связанные списки городов и районов (разделить города с одинаковым названием), городов и улиц (когда город один в области)*/
        $('#city_v').on('change',function(){
        var city = $(this).val();    
        var region = $("#region").val();    
        if(city){
        	$("#district_title").css("display", "none");
		    $("#district_v").css("display", "inline-block");
		    $("#district_v").addClass('form-control');
		    $("#district_v").addClass('select2');
		    $("#street_title").css("display", "none");
	    	$("#street_v").css("display", "inline-block");
	   		$("#street_v").addClass('form-control');
	    	$("#street_v").addClass('select2');
	    	$("#house_title").css("display", "none");
    		$("#house_v").css("display", "inline-block");
   			$("#house_v").addClass('form-control');
    		$("#house_v").addClass('select2');
        	
            $.ajax({
               type:"GET",
               url:"{{url('/kind/edit/getdistricts')}}?city="+city+"&region="+region,
               success:function(res){               
		            if(res[1]){
		                $("#district_all").css("display", "inline-block");
		                $("#district_v").empty();
		                $("#street_v").empty();
		                $("#district_v").append('<option value="">- выберете район -</option>');
		                $.each(res,function(id,value){
		                    $("#district_v").append('<option value="'+value+'">'+value+'</option>');
		                });

		                }else{
		                   //Если такой город есть только в одном из районов области - приступаем к выводу перечней улиц
				            $("#street_title").css("display", "none");
					    	$("#street_v").css("display", "inline-block");
					   		$("#street_v").addClass('form-control');
					    	$("#street_v").addClass('select2');
					    	$("#house_title").css("display", "none");
				    		$("#house_v").css("display", "inline-block");
				   			$("#house_v").addClass('form-control');
				    		$("#house_v").addClass('select2');
				            
				            $.ajax({
				               type:"GET",
				               url:"{{url('/kind/edit/getstreets')}}?city="+city+"&region="+region,
				               success:function(res1){               
				                if(res1){
				                    $("#district_v").empty();
				                    $("#district_v").val('');
				                    $("#district_er").empty();
				                    $("#district_er").val(1);
				                    $("#district_all").css("display", "none");
				                    $("#street_v").empty();
				                    $("#house_v").empty();
				                    $("#street_v").append('<option value="">- выберете улицу -</option>');
				                    $.each(res1,function(id,value){
					                        $("#street_v").append('<option value="'+value+'">'+value+'</option>');
					                    });

					                }else{
					                   $("#district_v").empty();
					                   $("#district_v").val('');
					                   $("#district_er").empty();
				                       $("#district_er").val(1);
					                   $("#street_v").empty();
					                   $("#district_all").css("display", "none");
					                } //end if(res1) ... else
					               } //end success:function(res)
					            }); //end $.ajax
		                   
		                   $("#district_v").empty();
		                   $("#district_v").val('');
		                   $("#district_er").empty();
				           $("#district_er").val(1);
		                   $("#street_v").empty();
		                   $("#house_v").empty();
		                   $("#district_all").css("display", "none");
		                }
	               } //end success:function(res)
	            });
	        }else{
	            $("#district_v").empty();
	            $("#district_v").val('');
	            $("#district_er").empty();
				$("#district_er").val(1);
	            $("#street_v").empty();
	            $("#house_v").empty();
	            $("#district_all").css("display", "none");
	        }
       	}); //end  $('#city').on
       	
       	
       	/*Связанные списки городов и улиц с учетом наличия в области одинаковых городов в разных районах */        
        $('#district_v').on('change',function(){
	        var district = $(this).val();
	        var region = $("#region").val();
	        //Если значение города уже изменено - берем новое значение
	        if(!$("#city_v").val()){
				var city = $("#city").val();
			}else{
				var city = $("#city_v").val();
			}

			if(district){
				$("#street_title").css("display", "none");
		    	$("#street_v").css("display", "inline-block");
		   		$("#street_v").addClass('form-control');
		    	$("#street_v").addClass('select2');
		    	$("#house_title").css("display", "none");
		    	$("#house_v").css("display", "inline-block");
		   		$("#house_v").addClass('form-control');
		    	$("#house_v").addClass('select2');
				
		        $.ajax({
		           type:"GET",
		           url:"{{url('/kind/edit/getstreetd')}}?city="+city+"&region="+region+"&district="+district,
		           success:function(res2){               
		            if(res2){
		                $("#house_v").empty();
		                $("#street_v").empty();
		                $("#street_v").append('<option value="">- выберете улицу -</option>');
		                $.each(res2,function(id,value){
		                    $("#street_v").append('<option value="'+value+'">'+value+'</option>');
		                });

		                }else{
		                   $("#street_v").empty();
		                   $("#house_v").empty();
		                } //end if(res2) ... else
		            } //end  success:function(res2)
	            }); //end $.ajax
	        }else{
	            $("#street_v").empty();
	            $("#house_v").empty();
	        } //end if(district) ... else
       	}); //end  $('#district').on
       	
       	/*Связанные списки улиц и домов */        
        $('#street_v').on('change',function(){
	        var street = $(this).val();
	        var region = $("#region").val();
	        //Если значение города уже изменено - берем новое значение
	        if(!$("#city_v").val()){
				var city = $("#city").val();
			}else{
				var city = $("#city_v").val();
			}
	        //Если значение района уже изменено - берем новое значение
	        if(!$("#district_v").val()){
				var district = $("#district").val();
			}else{
				var district = $("#district_v").val();
			}

			if(!district){
				if(street){
			        $("#house_title").css("display", "none");
		    		$("#house_v").css("display", "inline-block");
		   			$("#house_v").addClass('form-control');
		    		$("#house_v").addClass('select2');
			        
			        $.ajax({
			           type:"GET",
			           url:"{{url('/kind/edit/gethouse')}}?city="+city+"&region="+region+"&street="+street,
			           success:function(res3){               
			            if(res3){
			                $("#house_v").empty();
			                $("#house_v").append('<option value="">- выберете дом -</option>');
			                $.each(res3,function(id,value){
			                    $("#house_v").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   $("#house_v").empty();
			                } //end if(res3) ... else
			               } //end  success:function(res2)
			            }); //end $.ajax
			        }else{
			            $("#house_v").empty();
			        } //end if(street) ... else
			}else{
				if(street){
			        $("#house_title").css("display", "none");
		    		$("#house_v").css("display", "inline-block");
		   			$("#house_v").addClass('form-control');
		    		$("#house_v").addClass('select2');
			        
			        $.ajax({
			           type:"GET",
			           url:"{{url('/kind/edit/gethoused')}}?city="+city+"&region="+region+"&district="+district+"&street="+street,
			           success:function(res4){               
			            if(res4){
			                $("#house_v").empty();
			                $("#house_v").append('<option value="">- выберете дом -</option>');
			                $.each(res4,function(id,value){
			                    $("#house_v").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   $("#house_v").empty();
			                } //end if(res3) ... else
			               } //end  success:function(res2)
			            }); //end $.ajax
			        }else{
			            $("#house_v").empty();
			        } //end if(street) ... else
			} //end  if(district == null) ... else
			

       	}); //end  $('#street').on

</script>

<!-- Вычисление даты для пользователя из даты полученной из базы данных -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		
		function formatBdDate(date) {
			var dd = date.getDate();
			if (dd < 10) dd = '0' + dd;

			var mm = date.getMonth() + 1;
			if (mm < 10) mm = '0' + mm;

			var yy = date.getFullYear();
			if (yy < 10) yy = '0' + yy;
			
			var hh = date.getHours();
			if (hh < 10) hh = '0' + hh;
			
			var mi = date.getMinutes();
			if (mi < 10) mi = '0' + mi;
			
			var ss = date.getSeconds();
			if (ss < 10) ss = '0' + ss;			

			return dd + '-' + mm + '-' + yy + ' ' + hh + ':' + mi + ':' + ss;
		}
		
		var dateOnBD = $("#date_on_bd").val();
		var dateOffBD = $("#date_off_bd").val();
		
		/* Вычисление смещения часового пояса пользователя относительно 'UTC' в секундах для передачи в POST запрос.   */
		var date0 = new Date();
		/* Вычисление смещения часового пояса пользователя относительно 'UTC' в секундах.  
		На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */
		var offset0 = -1 * date0.getTimezoneOffset() * 60;  
		/* Передача в вид значения смещения для POST запроса */
		$("#date_offset").val(offset0);		
		/*-- конец расчета смещения --*/
		
		
		/* Вычисление смещения часового пояса пользователя относительно 'UTC' в милисекундах.   */
		var date_n = new Date();
		var offset_n = -1 * date_n.getTimezoneOffset() * 60000;  
		
		var date_on = new Date(dateOnBD);
		var date_off = new Date(dateOffBD);
		
		var result_on = new Date(date_on.getTime() + offset_n);
		var result_off = new Date(date_off.getTime() + offset_n);
		
		
		$('#date_on').val(formatBdDate(result_on));
		$('#date_start').val(formatBdDate(result_on));
		$('#date_off').val(formatBdDate(result_off));
		$('#date_end').val(formatBdDate(result_off));
		
	});
</script>

<!-- Связь конечной даты с установленным периодом публикации услуги -->
<script type="text/javascript">
	$('#period').change(function(){
		
		function formatDate(date) {
			var dd = date.getDate();
			if (dd < 10) dd = '0' + dd;

			var mm = date.getMonth() + 1;
			if (mm < 10) mm = '0' + mm;

			var yy = date.getFullYear();
			if (yy < 10) yy = '0' + yy;
			
			var hh = date.getHours();
			if (hh < 10) hh = '0' + hh;
			
			var mi = date.getMinutes();
			if (mi < 10) mi = '0' + mi;
			
			var ss = date.getSeconds();
			if (ss < 10) ss = '0' + ss;			

			return dd + '-' + mm + '-' + yy + ' ' + hh + ':' + mi + ':' + ss;
		}
		
		
		function addDays(days) {
		  var date_on = new Date();
		  var offset = -1 * date_on.getTimezoneOffset() * 60;  /* Вычисление смещения часового пояса пользователя относительно 'UTC' в секундах.  На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */
		  $("#date_offset").val(offset);
		  $("#date_on").val(formatDate(date_on));
		  $("#date_start").val(formatDate(date_on));		  
		  
		  var ms = date_on.getTime() + 86400000 * days;
		  var result = new Date(ms);
		  
		  return result;
		}
		
		var period_t = $(this).val();
		var date_off = addDays(period_t);
		
		if(period){
			$("#date_off").val(formatDate(date_off));
			$("#date_end").val(formatDate(date_off));
		}else{
			$("#date_off").empty();
			$("#date_end").empty();
		}
	});
</script>

<!-- Ограничение поля ввода цены услуги ЦИФРАМИ -->
<script type="text/javascript">
	jQuery(document).ready(function($){
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
		$('#price_start').forceNumbericOnly();
		$('#price_current').forceNumbericOnly();
		$('#price_buy_now').forceNumbericOnly();
		$('#price_sell_now').forceNumbericOnly();
		$('#price_lower').forceNumbericOnly();
		$('#bet_step').forceNumbericOnly();
		$('#number_total').forceNumbericOnly();
		
		//Функция отсекающая при вводе все кроме цифр и запятой (десятичные дроби)
		$.fn.forceDecimalOnly = function() {
			return this.each(function()
			{
			    $(this).keydown(function(e)
			    {
			        var key = e.charCode || e.keyCode || 0;
			        return ( key == 8 || key == 9 || key == 46 ||(key >= 37 && key <= 40) ||(key >= 48 && key <= 57) ||(key >= 96 && key <= 105) || key == 188 || key == 110  ); 
			        });
			});
		};
		$('#duration').forceDecimalOnly();
	});
</script>

<!-- Проверка типа аукциона и приведние страницы в соответствие с ним -->
<script type="text/javascript">
		jQuery(document).ready(function($){
			var BID = $("#bidding_type").val();
			if(BID){
			switch (BID) {
			  case '2':
			    $("#bidding_12").css("display", "inline-block");
			    $("#price_buy_now1").css("display", "inline-block");
			    $("#price_start1").css("display", "none");
			    break;
			  case '3':
			    $("#bidding_13").css("display", "inline-block");
			    $("#price_sell_now1").css("display", "inline-block");
			    $("#price_start1").css("display", "none");
			    break;
			  case '4':
			    $("#bidding_14").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  case '5':
			    $("#bidding_15").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  case '6':
			    $("#bidding_16").css("display", "inline-block");
			    $("#price_buy_now1").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  case '7':
			    $("#bidding_17").css("display", "inline-block");
			    $("#price_sell_now1").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  default:
			    break;
			}
		}
		});
		
		
		$('#bidding_type').change(function(){
		var biddingID = $(this).val();
			
			$("#bidding_12").css("display", "none");
           	$("#bidding_13").css("display", "none");
           	$("#bidding_14").css("display", "none");
           	$("#bidding_15").css("display", "none");
           	$("#bidding_16").css("display", "none");
           	$("#bidding_17").css("display", "none");
           	$("#price_buy_now1").css("display", "none");
			$("#price_sell_now1").css("display", "none");
			$("#price_lower1").css("display", "none");
			$("#bet_step1").css("display", "none");
           	$("#price_start1").css("display", "none");
		
		if(biddingID){
			switch (biddingID) {
			  case '2':
			    $("#bidding_12").css("display", "inline-block");
			    $("#price_buy_now1").css("display", "inline-block");
			    $("#price_start1").css("display", "none");
			    break;
			  case '3':
			    $("#bidding_13").css("display", "inline-block");
			    $("#price_sell_now1").css("display", "inline-block");
			    $("#price_start1").css("display", "none");
			    break;
			  case '4':
			    $("#bidding_14").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  case '5':
			    $("#bidding_15").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  case '6':
			    $("#bidding_16").css("display", "inline-block");
			    $("#price_buy_now1").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  case '7':
			    $("#bidding_17").css("display", "inline-block");
			    $("#price_sell_now1").css("display", "inline-block");
			    $("#price_lower1").css("display", "inline-block");
			    $("#bet_step1").css("display", "inline-block");
			    $("#price_start1").css("display", "inline-block");
			    break;
			  default:
			    break;
			}
		}
		
	});
</script>

<!-- Если курсор мышки будет наведен на города, улицы районы, дома -->
<script type="text/javascript">
    $(document).ready(function(){
        
        
        //
        $("#city_title").css("display", "inline-block");
        $("#district_title").css("display", "inline-block");
        $("#street_title").css("display", "inline-block");
        $("#house_title").css("display", "inline-block");
        //Показать поле ввода района, если он есть для данной записи в базе
        var district0 = $("#district").val();
        if(district0){
			$("#district_all").css("display", "inline-block");
		}
        
        //Курсор мышки - на городе
        $('#city_title').bind('mouseover', function(){
		    $("#city_title").css("display", "none");
		    $("#city_v").css("display", "inline-block");
		    $("#city_v").addClass('form-control');
		    $("#city_v").addClass('select2');
        
        	var region = $("#region").val();  
        	/*Связанные списки областей, городов, районов, домов*/  
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getcities')}}?region="+region,
               success:function(res){               
                if(res){
                    $("#city_v").empty();
                    $("#district_v").empty();
                    $("#street_v").empty();
                    $("#house_v").empty();
                    $("#city_v").append('<option value="">- выберете город -</option>');
                    $.each(res,function(id, value){
                        $("#city_v").append('<option value="'+value+'">'+value+'</option>');
                    });

                }else{
                   $("#city_v").empty();
                   $("#district_v").empty();
                   $("#street_v").empty();
                   $("#house_v").empty();
                } //end if(res) ... else
               } //end success:function(res)
            }); //end $.ajax
		}); //end $('#city_title').bind

		//Курсор мышки - на районе
        $('#district_title').bind('mouseover', function(){
		    $("#district_title").css("display", "none");
		    $("#district_v").css("display", "inline-block");
		    $("#district_v").addClass('form-control');
		    $("#district_v").addClass('select2');
        
        	var region = $("#region").val();  
        	var city = $("#city").val();
        	/*Связанные списки областей, городов, районов, домов*/  
            $.ajax({
               type:'GET',
               url:"{{url('/kind/edit/getdistricts')}}?city="+city+"&region="+region,
               success:function(res){               
                if(res){
                    $("#district_all").css("display", "inline-block");
	                $("#district_v").empty();
	                $("#street_v").empty();
	                $("#house_v").empty();
	                $("#district_v").append('<option value="">- выберете район -</option>');
	                $.each(res,function(id,value){
	                    $("#district_v").append('<option value="'+value+'">'+value+'</option>');
	                });

                }else{
                   $("#district_v").empty();
                   $("#district_v").val('');
//                 $("#district_er").empty();
//				   $("#district_er").val(1);
                   $("#street_v").empty();
                   $("#district_all").css("display", "none");
                } //end if(res) ... else
               } //end success:function(res)
            }); //end $.ajax
		}); //end $('#district_title').bind

		//Курсор мышки - на улице
		$('#street_title').bind('mouseover', function(){
		    $("#street_title").css("display", "none");
		    $("#street_v").css("display", "inline-block");
		    $("#street_v").addClass('form-control');
		    $("#street_v").addClass('select2');
		    
		    //Связанные списки городов и районов (разделить города с одинаковым названием), городов и улиц (когда город один в области)
		    var region = $("#region").val();
		    var city = $("#city").val();
			$.ajax({
	               type:"GET",
	               url:"{{url('/kind/edit/getdistricts')}}?city="+city+"&region="+region,
	               success:function(res){               
			            if(res[1]){
			                $("#district_all").css("display", "inline-block");
			                $("#district_v").empty();
			                $("#street_v").empty();
			                $("#house_v").empty();
			                $("#district_v").append('<option value="">- выберете район -</option>');
			                $.each(res,function(id,value){
			                    $("#district_v").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   //Если такой город есть только в одном из районов области - приступаем к выводу перечней улиц
					            $.ajax({
					               type:"GET",
					               url:"{{url('/kind/edit/getstreets')}}?city="+city+"&region="+region,
					               success:function(res1){               
					                if(res1){
					                    $("#district_v").empty();
					                    $("#district_v").val('');
					                    $("#district_all").css("display", "none");
					                    $("#street_v").empty();
					                    $("#house_v").empty();
					                    $("#street_v").append('<option value="">- выберете улицу -</option>');
					                    $.each(res1,function(id,value){
						                        $("#street_v").append('<option value="'+value+'">'+value+'</option>');
						                    });

						                }else{
						                   $("#district_v").empty();
						                   $("#district_v").val('');
						                   $("#street_v").empty();
						                   $("#district_all").css("display", "none");
						                } //end if(res1) ... else
						               } //end success:function(res)
						            }); //end $.ajax
			                   
			                   $("#district").empty();
			                   $("#district").val('');
			                   $("#street").empty();
			                   $("#house").empty();
			                   $("#district_all").css("display", "none");
			                }
		               } //end success:function(res)
		            }); //end $.ajax
		}); //end $('#street_title').bind
		
		//Если есть несколько городов с одинаковым названием в данной области
		var district_d = $("#district").val();
		if(district_d){		
			//Курсор мышки - на улице (есть несколько городов с таким названием в данной области)
			$('#street_title').bind('mouseover', function(){
			    $("#street_title").css("display", "none");
			    $("#street_v").css("display", "inline-block");
			    $("#street_v").addClass('form-control');
			    $("#street_v").addClass('select2');
			    
			    /*Связанные списки городов и улиц с учетом наличия в области одинаковых городов в разных районах */
			    var district = $("#district").val();
		        var region = $("#region").val();
		        var city = $("#city").val();
		        $.ajax({
		           type:"GET",
		           url:"{{url('/kind/edit/getstreetd')}}?city="+city+"&region="+region+"&district="+district,
		           success:function(res2){               
		            if(res2){
		                $("#house_v").empty();
		                $("#street_v").empty();
		                $("#street_v").append('<option value="">- выберете улицу -</option>');
		                $.each(res2,function(id,value){
		                    $("#street_v").append('<option value="'+value+'">'+value+'</option>');
		                });

		                }else{
		                   $("#street_v").empty();
		                   $("#house_v").empty();
		                } //end if(res2) ... else
		               } //end  success:function(res2)
		            }); //end $.ajax
				}); //end $('#street_title').bind
			} //end if(district_d)
		
		//Курсор мышки - на номере дома
		$('#house_title').bind('mouseover', function(){
		    $("#house_title").css("display", "none");
		    $("#house_v").css("display", "inline-block");
		    $("#house_v").addClass('form-control');
		    $("#house_v").addClass('select2');
		
			var street = $("#street").val();
	        var district = $("#district").val();
	        var region = $("#region").val();
	        var city = $("#city").val();

			if(!district){
				if(street){
			        $.ajax({
			           type:"GET",
			           url:"{{url('/kind/edit/gethouse')}}?city="+city+"&region="+region+"&street="+street,
			           success:function(res3){               
			            if(res3){
			                $("#house_v").empty();
			                $("#house_v").append('<option value="">- выберете дом -</option>');
			                $.each(res3,function(id,value){
			                    $("#house_v").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   $("#house_v").empty();
			                } //end if(res3) ... else
			               } //end  success:function(res2)
			            }); //end $.ajax
			        }else{
			            $("#house_v").empty();
			        } //end if(street) ... else
			}else{
				if(street){
			        $.ajax({
			           type:"GET",
			           url:"{{url('/kind/edit/gethoused')}}?city="+city+"&region="+region+"&district="+district+"&street="+street,
			           success:function(res4){               
			            if(res4){
			                $("#house_v").empty();
			                $("#house_v").append('<option value="">- выберете дом -</option>');
			                $.each(res4,function(id,value){
			                    $("#house_v").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   $("#house_v").empty();
			                } //end if(res3) ... else
			               } //end  success:function(res2)
			            }); //end $.ajax
			        }else{
			            $("#house_v").empty();
			        } //end if(street) ... else
			} //end  if(district == null) ... else
		}); //end $('#house_title').bind

    }); //end $(document).ready

</script>

<!-- Определение тарифа за публикацию услуги -->
<script type="text/javascript">
	$(document).ready(function(){
		var price_start = $("#price_start").val() * 1;
		var price_buy_now = $("#price_buy_now").val() * 1;
		var price_sell_now = $("#price_sell_now").val() * 1;
		var price_max = price_start;
		var bidding_rate1 = $("#bidding_rate1").val() * 1;
		var bidding_rate2 = $("#bidding_rate2").val() * 1;
		var bidding_rate3 = $("#bidding_rate3").val() * 1;
		var bidding_rate4 = $("#bidding_rate4").val() * 1;
		var bidding_price1 = $("#bidding_price1").val() * 1;
		var bidding_price2 = $("#bidding_price2").val() * 1;
		var bidding_price3 = $("#bidding_price3").val() * 1;
		var bidding_price4 = $("#bidding_price4").val() * 1;
		var balance0 = $("#balance0").val() * 1;
		
		if(price_max < price_buy_now){price_max = price_buy_now;}
		if(price_max < price_sell_now){price_max = price_sell_now;}
		
		var bidding_rate = 0;
		$("#bidding_rate").prop("enabled", true);      /* Разблокировка инпута */
		if(price_max > bidding_price4){
			bidding_rate = bidding_rate4;
		}else{
			if(price_max > bidding_price3){
				bidding_rate = bidding_rate3;
			}else{
				if(price_max > bidding_price2){
					bidding_rate = bidding_rate2;
				}else{
					if(price_max > bidding_price1 || price_max == 0){
						bidding_rate = bidding_rate1;
					}
				}
			}
		}
		$("#bidding_rate").val(bidding_rate);
		$("#bidding_rate").prop("disabled", true);     /* Блокировка инпута */
		
		var delta = balance0 - bidding_rate;
		if(delta < 0 && null != $('#bidding_rate').val()){
			$("#not_enough_public").css("display", "inline-block");
			$("#not_public").css("display", "inline-block");
			$("#allow_public").css("display", "none");
		}else{
			$("#not_enough_public").css("display", "none");
			$("#not_public").css("display", "none");
			$("#allow_public").css("display", "inline-block");
		}
	});
	
	$('#price_start').change(function(){
		var price_start = $("#price_start").val() * 1;
		var price_buy_now = $("#price_buy_now").val() * 1;
		var price_sell_now = $("#price_sell_now").val() * 1;
		var price_max = price_start;
		var bidding_rate1 = $("#bidding_rate1").val() * 1;
		var bidding_rate2 = $("#bidding_rate2").val() * 1;
		var bidding_rate3 = $("#bidding_rate3").val() * 1;
		var bidding_rate4 = $("#bidding_rate4").val() * 1;
		var bidding_price1 = $("#bidding_price1").val() * 1;
		var bidding_price2 = $("#bidding_price2").val() * 1;
		var bidding_price3 = $("#bidding_price3").val() * 1;
		var bidding_price4 = $("#bidding_price4").val() * 1;
		var balance0 = $("#balance0").val() * 1;
		
		if(price_max < price_buy_now){price_max = price_buy_now;}
		if(price_max < price_sell_now){price_max = price_sell_now;}
		
		var bidding_rate = 0;
		$("#bidding_rate").prop("enabled", true);      /* Разблокировка инпута */
		if(price_max > bidding_price4){
			bidding_rate = bidding_rate4;
		}else{
			if(price_max > bidding_price3){
				bidding_rate = bidding_rate3;
			}else{
				if(price_max > bidding_price2){
					bidding_rate = bidding_rate2;
				}else{
					if(price_max > bidding_price1 || price_max == 0){
						bidding_rate = bidding_rate1;
					}
				}
			}
		}
		$("#bidding_rate").val(bidding_rate);
		$("#bidding_rate").prop("disabled", true);     /* Блокировка инпута */
		
		var delta = balance0 - bidding_rate;
		if(delta < 0 && null != $('#bidding_rate').val()){
			$("#not_enough_public").css("display", "inline-block");
			$("#not_public").css("display", "inline-block");
			$("#allow_public").css("display", "none");
		}else{
			$("#not_enough_public").css("display", "none");
			$("#not_public").css("display", "none");
			$("#allow_public").css("display", "inline-block");
		}
	});
	
	$('#price_buy_now').change(function(){
		var price_start = $("#price_start").val() * 1;
		var price_buy_now = $("#price_buy_now").val() * 1;
		var price_sell_now = $("#price_sell_now").val() * 1;
		var price_max = price_start;
		var bidding_rate1 = $("#bidding_rate1").val() * 1;
		var bidding_rate2 = $("#bidding_rate2").val() * 1;
		var bidding_rate3 = $("#bidding_rate3").val() * 1;
		var bidding_rate4 = $("#bidding_rate4").val() * 1;
		var bidding_price1 = $("#bidding_price1").val() * 1;
		var bidding_price2 = $("#bidding_price2").val() * 1;
		var bidding_price3 = $("#bidding_price3").val() * 1;
		var bidding_price4 = $("#bidding_price4").val() * 1;
		var balance0 = $("#balance0").val() * 1;
		
		if(price_max < price_buy_now){price_max = price_buy_now;}
		if(price_max < price_sell_now){price_max = price_sell_now;}
		
		var bidding_rate = 0;
		$("#bidding_rate").prop("enabled", true);      /* Разблокировка инпута */
		if(price_max > bidding_price4){
			bidding_rate = bidding_rate4;
		}else{
			if(price_max > bidding_price3){
				bidding_rate = bidding_rate3;
			}else{
				if(price_max > bidding_price2){
					bidding_rate = bidding_rate2;
				}else{
					if(price_max > bidding_price1 || price_max == 0){
						bidding_rate = bidding_rate1;
					}
				}
			}
		}
		$("#bidding_rate").val(bidding_rate);
		$("#bidding_rate").prop("disabled", true);     /* Блокировка инпута */
		
		var delta = balance0 - bidding_rate;
		if(delta < 0 && null != $('#bidding_rate').val()){
			$("#not_enough_public").css("display", "inline-block");
			$("#not_public").css("display", "inline-block");
			$("#allow_public").css("display", "none");
		}else{
			$("#not_enough_public").css("display", "none");
			$("#not_public").css("display", "none");
			$("#allow_public").css("display", "inline-block");
		}
	});
	
	$('#price_sell_now').change(function(){
		var price_start = $("#price_start").val() * 1;
		var price_buy_now = $("#price_buy_now").val() * 1;
		var price_sell_now = $("#price_sell_now").val() * 1;
		var price_max = price_start;
		var bidding_rate1 = $("#bidding_rate1").val() * 1;
		var bidding_rate2 = $("#bidding_rate2").val() * 1;
		var bidding_rate3 = $("#bidding_rate3").val() * 1;
		var bidding_rate4 = $("#bidding_rate4").val() * 1;
		var bidding_price1 = $("#bidding_price1").val() * 1;
		var bidding_price2 = $("#bidding_price2").val() * 1;
		var bidding_price3 = $("#bidding_price3").val() * 1;
		var bidding_price4 = $("#bidding_price4").val() * 1;
		var balance0 = $("#balance0").val() * 1;
		
		if(price_max < price_buy_now){price_max = price_buy_now;}
		if(price_max < price_sell_now){price_max = price_sell_now;}
		
		var bidding_rate = 0;
		$("#bidding_rate").prop("enabled", true);      /* Разблокировка инпута */
		if(price_max > bidding_price4){
			bidding_rate = bidding_rate4;
		}else{
			if(price_max > bidding_price3){
				bidding_rate = bidding_rate3;
			}else{
				if(price_max > bidding_price2){
					bidding_rate = bidding_rate2;
				}else{
					if(price_max > bidding_price1 || price_max == 0){
						bidding_rate = bidding_rate1;
					}
				}
			}
		}
		$("#bidding_rate").val(bidding_rate);
		$("#bidding_rate").prop("disabled", true);     /* Блокировка инпута */
		
		var delta = balance0 - bidding_rate;
		if(delta < 0 && null != $('#bidding_rate').val()){
			$("#not_enough_public").css("display", "inline-block");
			$("#not_public").css("display", "inline-block");
			$("#allow_public").css("display", "none");
		}else{
			$("#not_enough_public").css("display", "none");
			$("#not_public").css("display", "none");
			$("#allow_public").css("display", "inline-block");
		}
	});
</script>

<!-- Определение тарифа за рекламирование услуги -->
<script type="text/javascript">
	$('#blurb_type_id').change(function(){
		var blurb_type_id = $(this).val();
		//Передача тарифа на рекламу
		var str = $("#blurb_prises").val();
		var blurb_prises = str.split(",");
		var blurb_pr = blurb_prises[blurb_type_id - 1];
		$("#price_blurb").prop("enabled", true);      /* Разблокировка инпута */
		$("#price_blurb").val(blurb_pr);
		$("#price_blurb").prop("disabled", true);     /* Блокировка инпута */
		//Передача периода рекламы
		var str1 = $("#blurb_periods").val();
		var blurb_periods = str1.split(",");
		var blurb_pe = blurb_periods[blurb_type_id - 1];
		$("#period_blurb").prop("enabled", true);      /* Разблокировка инпута */
		$("#period_blurb").val(blurb_pe);
		$("#period_blurb").prop("disabled", true);     /* Блокировка инпута */
		
		
		//Корректировка конечного периода в зависимости от выбранного пакета рекламы
		function formatDate1(date) {
			var dd = date.getDate();
			if (dd < 10) dd = '0' + dd;

			var mm = date.getMonth() + 1;
			if (mm < 10) mm = '0' + mm;

			var yy = date.getFullYear();
			if (yy < 10) yy = '0' + yy;
			
			var hh = date.getHours();
			if (hh < 10) hh = '0' + hh;
			
			var mi = date.getMinutes();
			if (mi < 10) mi = '0' + mi;
			
			var ss = date.getSeconds();
			if (ss < 10) ss = '0' + ss;			

			return dd + '-' + mm + '-' + yy + ' ' + hh + ':' + mi + ':' + ss;
		}
		
		function addDays1(days) {
		  var date_on_blurb = new Date();
		  var offset = -1 * date_on_blurb.getTimezoneOffset() * 60;  /* Вычисление смещения часового пояса пользователя относительно 'UTC'.  На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */

		  var ms = date_on_blurb.getTime() + 86400000 * days;
		  var result = new Date(ms);
		  
		  //Передать в контроллер начальную дату рекламного периода
		  $("#date_on_blurb").val(formatDate1(date_on_blurb));
		  
		  return result;
		}
		
		var period_t1 = $('#period').val();
		var date_off = addDays1(period_t1);
		var date_off_blurb = addDays1(blurb_pe); //Берем период рекламы и зменяем им ранее выбранный период если период рекламы больше
		
		$("#date_off_blurb").val(formatDate1(date_off_blurb));
		
		if(blurb_pe){
			if(date_off < date_off_blurb){
				$("#date_end").prop("enabled", true);      /* Разблокировка инпута */
				$("#date_end").val(formatDate1(date_off_blurb));
				$("#date_end").prop("disabled", true);     /* Блокировка инпута */
				$("#date_off").val(formatDate1(date_off_blurb));
			}else{
				$("#date_end").prop("enabled", true);      /* Разблокировка инпута */
				$("#date_end").val(formatDate1(date_off));
				$("#date_end").prop("disabled", true);     /* Блокировка инпута */
				$("#date_off").val(formatDate1(date_off));
			}
		}
		
		
		var price_start = $("#price_start").val() * 1;
		var price_buy_now = $("#price_buy_now").val() * 1;
		var price_sell_now = $("#price_sell_now").val() * 1;
		var price_max = price_start;
		var bidding_rate1 = $("#bidding_rate1").val() * 1;
		var bidding_rate2 = $("#bidding_rate2").val() * 1;
		var bidding_rate3 = $("#bidding_rate3").val() * 1;
		var bidding_rate4 = $("#bidding_rate4").val() * 1;
		var bidding_price1 = $("#bidding_price1").val() * 1;
		var bidding_price2 = $("#bidding_price2").val() * 1;
		var bidding_price3 = $("#bidding_price3").val() * 1;
		var bidding_price4 = $("#bidding_price4").val() * 1;
		var balance0 = $("#balance0").val() * 1;
		
		if(price_max < price_buy_now){price_max = price_buy_now;}
		if(price_max < price_sell_now){price_max = price_sell_now;}
		
		var bidding_rate = 0;
		if(price_max > bidding_price4){
			bidding_rate = bidding_rate4;
		}else{
			if(price_max > bidding_price3){
				bidding_rate = bidding_rate3;
			}else{
				if(price_max > bidding_price2){
					bidding_rate = bidding_rate2;
				}else{
					if(price_max > bidding_price1 || price_max == 0){
						bidding_rate = bidding_rate1;
					}
				}
			}
		}
		
		var delta = balance0 - bidding_rate - blurb_pr;
		if(delta < 0 && null != $('#blurb_type_id').val()){
			$("#not_enough_blurb").css("display", "inline-block");
			$("#not_public").css("display", "inline-block");
			$("#allow_public").css("display", "none");
		}else{
			$("#not_enough_blurb").css("display", "none");
			$("#not_public").css("display", "none");
			$("#allow_public").css("display", "inline-block");
		}
		
		
		
	});
</script>


@endpush