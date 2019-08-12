@push('styles')
	<style>
      	#bidding_12, #bidding_13, #bidding_14, #bidding_15, #bidding_16, #bidding_17 {
		 	display: none; 
		}
		
		#price_buy_now1, #price_sell_now1, #price_lower1, #bet_step1, #price_start1 {
		 	display: none; 
		}
		
		#period_un, #district_all, #address_un {
			display: none;
		}

	</style>
@endpush

@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить услугу
        <small>продажа</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
	<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
	<form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data"> 
	  @csrf
	

	
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Добавляем услугу</h3>
          @include('admin.errors')
        </div>
        
        <div class="box-body">
          <div class="col-md-9">
            <!-- Название -->
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="title" placeholder="" name="title" value="{{old('title')}}" maxlength="240" required>
            </div>
            
                <!-- Раздел -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Раздел</label>
		              <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;" required>
			              	<option value="">- выберите раздел -</option>
			              	@foreach($sections as $section)
		                		<option value="{{$section->id}}">{{$section->title}}</option>
		              		@endforeach
		              </select>
	            </div>
	         </div>
            
            <p></p>
            <p></p>
            
                <!-- Категория -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Категория</label>
		              <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;" required>
			              	
		              </select>
	            </div>
            </div>
            
             	<!-- Вид услуг -->
	        <div class="col-md-4">    
	            <div class="form-group">
	              <label>Вид услуг</label>
		              <select class="form-control select2" name="kind_id" id="kind_id" style="width: 100%;" required>
			              	
		              </select>
	            </div>
            </div>

             	<!-- Лицевая картинка услуги -->            
            <div class="form-group">
              <label for="exampleInputFile">Лицевая картинка услуги</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Выберете графический файл для лицевой картинки услуги</p>
            </div>
          </div>  <!-- end "col-md-9" -->
        </div>  <!-- end "box-body" -->
            
            
        <div class="box-body">  
          <div class="col-md-9">  
	        
	        <!-- Тип торгов -->
	        <div class="col-md-4">
	          <div class="form-group">
	        	<label for="exampleInputEmail1">Тип торгов</label>
				<p class="help-block">Выберете тип ТОРГОВ</p>
	        		        	
				<select class="form-control select2" name="bidding_type" id="bidding_type" style="width: 100%;" required>
		              	<option value="">- выберите тип торгов -</option>
			            @foreach($bidding_types as $bidding_type)
		                	<option value="{{$bidding_type->id}}">{{$bidding_type->title}}</option>
		              	@endforeach
               </select>

	          </div>	
	        </div>
	        
	        <!-- Комментарий по типу торгов -->
	        <div class="col-md-4" id="bidding_all">
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
	        <div class="col-md-4" id="price_start1">
		        <div class="form-group">
		        	<label for="exampleInputEmail1">Цена услуги</label>
					<p class="help-block">Укажите начальную цену услуги</p>
		        	
		        	<input type="number" min="0" class="form-control" id="price_start" placeholder="" name="price_start" value="{{old('price_start')}}" >               		<span>  грн</span>  
		        </div>
	        </div>
	        
          </div>  <!-- end "col-md-9" -->
        </div> <!-- end "box-body" --> 
            
            
        <div class="box-body">
          <div class="col-md-9">
                        
             	<!-- Цена "Купить сразу" -->
	        <div class="col-md-4" id="price_buy_now1">    
	            <div class="form-group">
	              <label>Цена "Купить сразу"</label>
		              <input type="number" min="0" class="form-control" id="price_buy_now" placeholder="" name="price_buy_now" value="{{old('price_buy_now')}}" >               		<span>  грн</span>
	            </div>
            </div>
            
                <!-- Цена "Продать сразу" -->
	        <div class="col-md-4" id="price_sell_now1">    
	            <div class="form-group">
	              <label>Цена "Продать сразу"</label>
		              <input type="number" min="0" class="form-control" id="price_sell_now" placeholder="" name="price_sell_now" value="{{old('price_sell_now')}}" >               		<span>  грн</span>
	            </div>
            </div>
            
           
            	<!-- Нижняя граница цены (для Тендеров и Аукционов) -->
	        <div class="col-md-4" id="price_lower1">    
	            <div class="form-group">
	              <label>Нижняя граница цены</label>
		              <input type="number" min="0" class="form-control" id="price_lower" placeholder="" name="price_lower" value="{{old('price_lower')}}" >               		<span>  грн</span>
	            </div>
            </div>
            
                <!-- Шаг ставки -->
	        <div class="col-md-4" id="bet_step1">    
	            <div class="form-group">
	              <label>Шаг ставки</label>
		              <input type="number" min="0" class="form-control" id="bet_step" placeholder="" name="bet_step" value="{{old('bet_step')}}" >               		<span>  грн</span>
	            </div>
            </div>
             
          </div>  <!-- end "col-md-9" -->
         </div>  <!-- end "box-body" -->
        
        
        
        <div class="box-body">
          <div class="col-md-9">
                        
                <!-- Количество единиц (сеансов) услуги в наличии -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Количество единиц (сеансов) услуги в наличии</label>
		              <input type="number" min="0" class="form-control" id="number_total" placeholder="" name="number_total" value="{{old('number_total')}}" required>               		<span>  единиц</span>
	            </div>
	         </div>
            
           
            
                <!-- Места предоставления услуги -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Место предоставления услуги</label>
	              
		              <select class="form-control select2" name="place_id" id="place_id" style="width: 100%;" required>
			              	<option style="width: 100%" value="">- выберите место -</option>
			              	<option style="width: 100%" value="11">По адресу Заказчика</option>
			              	<option style="width: 100%" value="12">По адресу Поставщика</option>
			              	<option style="width: 100%" value="13">Любое в городе Заказчика</option>
			              	<option style="width: 100%" value="14">Любое в городе Поставщика</option>
			              	<option style="width: 100%" value="15">Выезд в другой город</option>
			              	<option style="width: 100%" value="16">Любое место</option>
		              </select>
	            </div>
            </div>
            
            <!-- Статус услуги искомой (опубликованные / все (вкл. архивные)-->
		     <div class="form-group">
				<p class="help-block">Снять, если нужно отправить услугу в архивные (не опубликованные)</p>
				<label>
					<input type="checkbox" class="minimal" name="status" id="status" checked>
				</label>
				<label>
					Опубликовать услугу
				</label>
			</div>
            
     
          </div>  <!-- end "col-md-9" -->
        </div>  <!-- end "box-body" -->
            
      
            
            
            <p></p>
            <p></p>  <!-- Даты публикации -->
        <div class="box-body">
          <div class="col-md-9">  
                 <!-- Date -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Период публикации:</label>

	              
	                <select class="form-control select2" name="period" id="period" style="width: 100%;" required>
			              	<option style="width: 100%" value="">- выберите период -</option>
			              	<option style="width: 100%" value="1">1 день</option>
			              	<option style="width: 100%" value="3">3 дня</option>
			              	<option style="width: 100%" value="7">7 дней</option>
			              	<option style="width: 100%" value="14">14 дней</option>
			              	<option style="width: 100%" value="21">21 день</option>
			              	<option style="width: 100%" value="28">28 дней</option>
	               </select>
	      
	            </div>
			</div>
						
			<div class="col-md-4">
	            <div class="form-group">
	              <label>Дата старта публикации:</label>

	              <div class="input-group date">
	                <div class="input-group-addon">
	                  <i class="fa fa-calendar"></i>
	                </div>
	                <input type="text" class="form-control" name="date_start" id="date_start" disabled>
	                <!-- Скрытая передача поля  "date_on"-->
	                <input type="hidden" name="date_on" id="date_on">
	                <!-- Скрытая передача смещения часового пояса пользователя относительно 'UTC'-->
	                <input type="hidden" name="date_offset" id="date_offset">
	              </div>
	            </div>
            </div>
            
            <div class="col-md-4">
	            <div class="form-group">
	              <label>Дата завершения:</label>

	              <div class="input-group date">
	                <div class="input-group-addon">
	                  <i class="fa fa-calendar"></i>
	                </div>
	                <input type="text" class="form-control" name="date_end" id="date_end" disabled>
	                <!-- Скрытая передача поля  "date_off"-->
	                <input type="hidden" name="date_off" id="date_off">
	              </div>
	            </div>
            </div>

			<!-- ФУНКЦИЯ автоматического формирования кода перенесена в КОНТРОЛЛЕР ServicesController
		     <div class="box-body">   
		         <div class="col-md-4">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">Товарный код услуги</label>
			          <span class="help-block">Формируестя автоматически</span>
			          <input type="text" class="form-control" id="c_code" placeholder="" name="c_code" disabled>
			          <input type="hidden" class="form-control" id="product_code_id" name="product_code_id">
			        </div>
			     </div>
		    </div>
			-->

            <!-- checkbox -->
            <div class="form-group">
              <label>
                <input type="checkbox" class="minimal" name="is_featured">
              </label>
              <label>
                Рекомендовать
              </label>
            </div>

            
          </div> <!-- end "col-md-9" -->
          
          <!-- Краткое описание услуги -->
          <div class="col-md-8">
            <div class="form-group">
              <label for="exampleInputEmail1">Краткое описание услуги</label>
              <p class="help-block">Опишите кратко предлагаемую услугу для представления ее в перечнях услуг при поиске</p>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control" maxlength="300" required >{{old('description')}}</textarea>
	        </div>
	      </div>
	      
	      <!-- Рекламный слоган для услуги -->
          <div class="col-md-5">
            <div class="form-group">
              <label for="exampleInputEmail1">Рекламный слоган для услуги</label>
              <p class="help-block">Если Вы планируете рекламировать данную услугу - придумайте сразу для нее рекламный слоган, который будет отображаться на заглавной странице</p>
              <textarea name="slogan" id="slogan" cols="10" rows="5" class="form-control" maxlength="70"  >{{old('slogan')}}</textarea>
	        </div>
	      </div>
	      
          <!-- Полное описание услуги -->
          <div class="col-md-10">
            <div class="form-group">
              <label for="exampleInputEmail1">Полное описание услуги</label>
              <p class="help-block">Дайте исчерпывающе полное описание услуги для показа его на странице данной услуги</p>
              <textarea name="content" id="content" cols="30" rows="20" class="form-control" maxlength="5000" required >{{old('content')}}</textarea>
	        </div>
	      </div>
	        
      </div>  <!-- end "box-body" -->
      
      
      
        <p></p>
        <p></p>  <!-- Объем услуги и Дополнительные материалы -->
		<div class="box-body">
			<div class="col-md-9">  
				<!-- Объем и структура услуги -->
				<div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Объем и структура услуги</label>
		              <p class="help-block">Изложите структуру услуги, что входит в объем, какие этапы предоставления</p>
		              <textarea name="value_service" id="value_service" cols="30" rows="10" class="form-control" >{{old('value_service')}}</textarea>
			        </div>
				</div>
				<!-- Дополнительные материалы -->			
				<div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Дополнительные материалы</label>
		              <p class="help-block">Опишите Дополнительные материалы, не входящие в стоимость услуги</p>
		              <textarea name="add_materials" id="add_materials" cols="30" rows="10" class="form-control" >{{old('add_materials')}}</textarea>
			        </div>
				</div>
			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->
		
		
		
		<p></p>
        <p></p> <!-- Дни до начального и конечного срока предоставления услуги -->
        <div class="box-body">
          <div class="col-md-9">  
            <!-- Date period_initial-->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Дни до начального срока предоставления услуги</label>
	              <p class="help-block">Период времени после сделки, когда может раньше всего быть предоставлена услуга - первый день предоставления услуги</p>
	                <select class="form-control select2" name="period_initial" id="period_initial" style="width: 100%;" required>
			              	<option style="width: 100%" value="">- выберите срок -</option>
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
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Дни до конечного срока предоставления услуги</label>
	              <p class="help-block">Период времени от сделки, до момента, когда услуга уже не может быть предоставлена – сделка аннулируется</p>
	                <select class="form-control select2" name="period_deadline" id="period_deadline" style="width: 100%;" required>
			              	<option style="width: 100%" value="">- выберите срок -</option>
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
	        <div class="col-md-4" id="period_un">
		        <div class="form-group alert alert-danger" >
					Конечная дата не может быть раньше начальной! Выберете срок так, чтобы конечная дата была позже начальной					
		        </div>
	        </div>



			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->

		<div class="box-body">
			<div class="col-md-9">  		
				<!-- График работы -->			
				<div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">График работы сервиса услуги</label>
		              <p class="help-block">Укажите расписание работы сервиса услуги (или офиса) - дни и часы, когда может быть предоставлена услуга</p>
		              <textarea name="schedule" id="schedule" cols="30" rows="10" class="form-control" >{{old('schedule')}}</textarea>
			        </div>
				</div>
			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->      

		
		<p></p>
        <p></p>  <!-- Длительность и результат -->
		<div class="box-body">
			<div class="col-md-9">  
				<!-- Длительность процесса предоставления услуги в часах-->
				<div class="col-md-3">
		            <div class="form-group">
						<label>Длительность процесса предоставления услуги в часах</label>
						<input type="number" step="0.1" min="0" class="form-control" id="duration" placeholder="" name="duration" value="{{old('duration')}}">               		<span>  часов</span>
		            </div>
				</div>
				<!-- Результат получения услуги-->
				<div class="col-md-9">
		            <div class="form-group">
						<label>Результат получения услуги</label>
						<input type="text" class="form-control" id="result" placeholder="" name="result" value="{{old('result')}}" required>      						</div>
				</div>
			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->		


		<p></p>
        <p></p>  <!-- Доступность и условия оплаты услуги-->
		<div class="box-body">
			<div class="col-md-9">
				<!-- Доступность услуги-->
				<div class="col-md-4">
		            <div class="form-group">
		              <label>Доступность услуги</label>
		              <p class="help-block">Если предполагается, что услуга доступна и может быть предоставлена в любой момент после заключения сделки - выбирайте - "В наличии", если нет - "Под заказ" (тогда в дополниельной информации нужно указать возможные сроки ожидания)</p>
		                <select class="form-control select2" name="availability" id="availability" style="width: 100%;" required>
			              	<option style="width: 100%" value="">- выберите доступность -</option>
			              	<option style="width: 100%" value="1">В наличии</option>
			              	<option style="width: 100%" value="2">Под заказ</option>
		               </select>
		            </div>
				</div>
				<!-- Условия оплаты-->
		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Условия оплаты</label>
		              <p class="help-block">Необходимо указать сроки и этапность оплаты услуги</p>
		                <select class="form-control select2" name="terms_payment" id="terms_payment" style="width: 100%;" required>
			              	<option style="width: 100%" value="">- выберите срок -</option>
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
		                <input type="checkbox" class="minimal" name="expandable" id="expandable" value="1">
		              </label>
		              <label>
		                Расширяемая услуга
		              </label>
		              <p class="help-block">Если до начала предоставления услуги не могут быть предусмотрена необходимость применения дополнительных материалов и услуг не входящих в начальную стоимость услуги</p
		            </div>

		            <!-- Масштабируемая услуга -->
		            <div class="form-group">
		              <label>
		                <input type="checkbox" class="minimal" name="scalable" id="scalable" value="1">
		              </label>
		              <label>
		                Масштабируемая услуга
		              </label>
		              <p class="help-block">Если услуга может быть выражена в количественных единицах (например на 1 м кв., 1 точка подключения, 1 стр.)</p
		            </div>
		        </div>
		        
				
			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->		

        <p></p>
        <p></p>  <!-- Дополнительные условия -->
		<div class="box-body">
			<div class="col-md-9">  
				<!-- Условия предоставления -->
				<div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Условия предоставления</label>
		              <p class="help-block">Изложите какие условия должен соблюсти контрагент для успешного прохождения процесса предоставления услуги и ее оплаты</p>
		              <textarea name="terms_provision" id="terms_provision" cols="30" rows="10" class="form-control" >{{old('terms_provision')}}</textarea>
			        </div>
				</div>
				<!-- Дополнительные условия -->			
				<div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Дополнительные условия</label>
		              <p class="help-block">Опишите Дополнительные условия, которые нужно учесть контрагенту перед участием в торгах по данной услуге</p>
		              <textarea name="add_terms" id="add_terms" cols="30" rows="10" class="form-control" >{{old('add_terms')}}</textarea>
			        </div>
				</div>
			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->
		
		<p></p>
        <p></p>  <!-- Адрес предоставления услуги -->
		<div class="box-body">
			<label>Основной Адрес предоставления услуги (дополнительные - укажите в дополнительных условиях)</label>
			<div class="col-md-12">
	            <!-- Область -->
		        <div class="col-md-2">
		            <div class="form-group">
		              <label>Область</label>
			              <select class="form-control select2" name="region" id="region" style="width: 100%;" >
				              	<option value="">- выберите область -</option>
				              	@foreach($address as $addr)
			                		<option value="{{$addr->region}}">{{$addr->region}}</option>
			              		@endforeach
			              </select>
		            </div>
		         </div>
	            <!-- Город -->
		        <div class="col-md-3">
		            <div class="form-group">
		              <label>Город</label>
			              <select class="form-control select2" name="city" id="city" style="width: 100%;" >

			              </select>
		            </div>
	            </div>
				<!-- Район -->
		        <div class="col-md-2" id="district_all">    
		            <div class="form-group">
		              <label>Район</label>
			              <select class="form-control select2" name="district" id="district" style="width: 100%;">
				              	
			              </select>
		            </div>
	            </div>
	            <!-- Улица -->
		        <div class="col-md-2">    
		            <div class="form-group">
		              <label>Улица</label>
			              <select class="form-control select2" name="street" id="street" style="width: 100%;">
				              	
			              </select>
		            </div>
	            </div>
	            <!-- Дом -->
		        <div class="col-md-2">    
		            <div class="form-group">
		              <label>Дом</label>
			              <select class="form-control select2" name="house" id="house" style="width: 100%;">
				              	
			              </select>
		            </div>
	            </div>
	            
	            <!-- Комментарий по содержанию полей адреса -->
		        <div class="col-md-8" id="address_un">
			        <div class="form-group alert alert-danger" >
						Заполните пожалуйста все поля адреса!			
			        </div>
		        </div>


			</div>  <!-- end "col-md-12" -->
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

<!-- Связанные списки разделов и категорий -->
<script type="text/javascript">
     $('#section_id').change(function(){
        var sectionID = $(this).val();    
        if(sectionID){
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/create/getcat')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id").empty();
                    $("#kind_id").empty();
                    $("#category_id").append('<option value="">- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#category_id").empty();
                   $("#kind_id").empty();
                   $("#c_code").empty();
                   //$("#product_code_id").empty();
                }
               }
            });
        }else{
            $("#category_id").empty();
            $("#kind_id").empty();
            $("#c_code").empty();
            //$("#product_code_id").empty();
        }      
       });
        
        /*Связанные списки категорий и видов услуг*/        
        $('#category_id').on('change',function(){
        var categoryID = $(this).val();    
        if(categoryID){
            $.ajax({
               type:"GET",
               url:"{{url('/admin/services/create/getkind')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#kind_id").empty();
                    $("#kind_id").append('<option value="">- выберете вид услуг -</option>');
                    $.each(res,function(key,value){
                        $("#kind_id").append('<option value="'+key+'">'+value+'</option>');
                    });

	                }else{
	                   $("#kind_id").empty();
	                   $("#c_code").empty();
	                   //$("#product_code_id").empty();
	                }
	               }
	            });
	        }else{
	            $("#kind_id").empty();
	            $("#c_code").empty();
	            //$("#product_code_id").empty();
	        }

       	});
       
       
       /*Назначить товарный код услуги для данного вида услуг - следующий по списку - ТЕПЕРЬ ФОРМИРУЕСТСЯ в контроллере ServicesController*/        
/*        $('#kind_id').change(function(){
	        var kindID = $(this).val();
	            
	        if(kindID){
	            $.ajax({
	               type:"GET",
	               url:"{{url('/admin/services/create/getsercode')}}?kind_id="+kindID,
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
       	});    */
       
    
    /*Связь конечной даты с установленным периодом публикации услуги*/   
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
		  var offset = -1 * date_on.getTimezoneOffset() * 60;  /* Вычисление смещения часового пояса пользователя относительно 'UTC'.  На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */
		  $("#date_offset").val(offset);
		  
		  $("#date_start").prop("enabled", true);      /* Разблокировка инпута */
		  $("#date_start").val(formatDate(date_on));
		  $("#date_start").prop("disabled", true);     /* Блокировка инпута */
		  $("#date_on").val(formatDate(date_on));
		  
		  var ms = date_on.getTime() + 86400000 * days;
		  var result = new Date(ms);
		  
		  return result;
		}
		
		var period_t = $(this).val();
		var date_off = addDays(period_t);
		
		if(period){
			$("#date_end").prop("enabled", true);      /* Разблокировка инпута */
			$("#date_end").val(formatDate(date_off));
			$("#date_end").prop("disabled", true);     /* Блокировка инпута */
			$("#date_off").val(formatDate(date_off));			
		}else{
			$("#date_end").prop("enabled", true);      /* Разблокировка инпута */
			$("#date_end").empty();
			$("#date_end").prop("disabled", true);     /* Блокировка инпута */
		}
	});

	       
</script>

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
	
	//Функция отображения только 2-х знаков после запятой - НЕ РАБОТАЕТ***
	$( '#duration' ).blur(function() {
    	this.value = parseFloat(this.value).toFixed(2);
	});
	
</script>

<!-- Проверка типа аукциона и приеведние страницы в соответствие с ним -->
<script type="text/javascript">

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

<!-- Подключение текстового редактора -->
<script>
    $(document).ready(function(){
        var editor_sc = CKEDITOR.replaceAll();
        CKFinder.setupCKEditor( editor_sc );
    })
</script>

<!-- Связанные списки областей, городов, районов, домов -->
<script type="text/javascript">
    //Связанные списки областей, городов, районов, домов
    $('#region').change(function(){
        var region = $(this).val();    
        if(region){
        	$("#address_un").css("display", "inline-block");
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/create/getcities')}}?region="+region,
               success:function(res){               
                if(res){
                    $("#city").empty();
                    $("#district").empty();
                    $("#street").empty();
                    $("#house").empty();
                    $("#city").append('<option value="">- выберете город -</option>');
                    $.each(res,function(id, value){
                        $("#city").append('<option value="'+value+'">'+value+'</option>');
                    });

                }else{
                   $("#city").empty();
                   $("#district").empty();
                   $("#street").empty();
                   $("#house").empty();
                }
               }
            });
        }else{
            $("#city").empty();
            $("#district").empty();
            $("#street").empty();
            $("#house").empty();
        }      
       });
        
        /*Связанные списки городов и районов (разделить города с одинаковым названием), городов и улиц (когда город один в области)*/
        $('#city').on('change',function(){
        var city = $(this).val();    
        var region = $("#region").val();    
        if(city){
        	$("#address_un").css("display", "inline-block");
            $.ajax({
               type:"GET",
               url:"{{url('/admin/services/create/getdistricts')}}?city="+city+"&region="+region,
               success:function(res){               
		            if(res[1]){
		                $("#district_all").css("display", "inline-block");
		                $("#district").empty();
		                $("#street").empty();
		                $("#district").append('<option value="">- выберете район -</option>');
		                $.each(res,function(id,value){
		                    $("#district").append('<option value="'+value+'">'+value+'</option>');
		                });

		                }else{
		                   //Если такой город есть только в одном из районов области - приступаем к выводу перечней улиц
				            $.ajax({
				               type:"GET",
				               url:"{{url('/admin/services/create/getstreets')}}?city="+city+"&region="+region,
				               success:function(res1){               
				                if(res1){
				                    $("#district").empty();
				                    $("#district").val('');
				                    $("#district_all").css("display", "none");
				                    $("#street").empty();
				                    $("#house").empty();
				                    $("#street").append('<option value="">- выберете улицу -</option>');
				                    $.each(res1,function(id,value){
					                        $("#street").append('<option value="'+value+'">'+value+'</option>');
					                    });

					                }else{
					                   $("#district").empty();
					                   $("#district").val('');
					                   $("#street").empty();
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
	            });
	        }else{
	            $("#district").empty();
	            $("#district").val('');
	            $("#street").empty();
	            $("#house").empty();
	            $("#district_all").css("display", "none");
	        }
       	}); //end  $('#city').on
       	
       	
       	/*Связанные списки городов и улиц с учетом наличия в области одинаковых городов в разных районах */        
        $('#district').on('change',function(){
	        var district = $(this).val();
	        var region = $("#region").val();
	        var city = $("#city").val();

			if(district){
				$("#address_un").css("display", "inline-block");
		        $.ajax({
		           type:"GET",
		           url:"{{url('/admin/services/create/getstreetd')}}?city="+city+"&region="+region+"&district="+district,
		           success:function(res2){               
		            if(res2){
		                $("#house").empty();
		                $("#street").empty();
		                $("#street").append('<option value="">- выберете улицу -</option>');
		                $.each(res2,function(id,value){
		                    $("#street").append('<option value="'+value+'">'+value+'</option>');
		                });

		                }else{
		                   $("#street").empty();
		                   $("#house").empty();
		                } //end if(res2) ... else
		               } //end  success:function(res2)
		            }); //end $.ajax
	        }else{
	            $("#street").empty();
	            $("#house").empty();
	        } //end if(district) ... else
       	}); //end  $('#district').on
       	
       	/*Связанные списки улиц и домов */        
        $('#street').on('change',function(){
	        var street = $(this).val();
	        var district = $("#district").val();
	        var region = $("#region").val();
	        var city = $("#city").val();

			if(!district){
				if(street){
					$("#address_un").css("display", "inline-block");
			        $.ajax({
			           type:"GET",
			           url:"{{url('/admin/services/create/gethouse')}}?city="+city+"&region="+region+"&street="+street,
			           success:function(res3){               
			            if(res3){
			                $("#house").empty();
			                $("#house").append('<option value="">- выберете дом -</option>');
			                $.each(res3,function(id,value){
			                    $("#house").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   $("#house").empty();
			                } //end if(res3) ... else
			               } //end  success:function(res2)
			            }); //end $.ajax
			        }else{
			            $("#house").empty();
			        } //end if(street) ... else
			}else{
				if(street){
					$("#address_un").css("display", "inline-block");
			        $.ajax({
			           type:"GET",
			           url:"{{url('/admin/services/create/gethoused')}}?city="+city+"&region="+region+"&district="+district+"&street="+street,
			           success:function(res4){               
			            if(res4){
			                $("#house").empty();
			                $("#house").append('<option value="">- выберете дом -</option>');
			                $.each(res4,function(id,value){
			                    $("#house").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }else{
			                   $("#house").empty();
			                } //end if(res3) ... else
			               } //end  success:function(res2)
			            }); //end $.ajax
			        }else{
			            $("#house").empty();
			        } //end if(street) ... else
			} //end  if(district == null) ... else
			

       	}); //end  $('#street').on

</script>

<!-- Если заполнены не все поля адреса, выводится предупреждение -->
<script type="text/javascript">
    $(document).ready(function(){
        if(!$("#region").val() || !$("#city").val() || !$("#street").val() || !$("#house").val()){
			$("#address_un").css("display", "inline-block");
		}
	});
	
	$('#house').change(function(){
		if($("#house").val()){
			$("#address_un").css("display", "none");
		}
	});
</script>

@endpush