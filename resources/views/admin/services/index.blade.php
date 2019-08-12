@push('styles')
	<style>
		#district_all, #code_un, #date_un, #price_all, #price_f, #price_s, #price_type {
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
        Формирование запроса для выдачи перечня услуг
        <small>Выберите параметры запроса для демонстрации перечня услуг</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
	
	<form method="POST" action="{{ route('services.request') }}" > 
	  @csrf
	
	
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Параметры запроса</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-12">
            
            <!-- Скрытая передача смещения часового пояса пользователя относительно 'UTC'-->
			<input type="hidden" name="date_offset" id="date_offset">
            
            <!-- Название услуги -->
	        <div class="col-md-6">    
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название</label>
	              <input type="text" class="form-control" id="services_title" placeholder="" name="services_title" value="{{old('title')}}" enabled>
	            </div>
            </div>
            
            <!-- Искать в описании услуги -->
	        <div class="col-md-3">    
	            <div class="form-group">
	              <p class="help-block">Выбрать, если нужно искать в описании услуг</p>
	              <label>
	                <input type="checkbox" class="minimal" name="in_content" id="in_content">
	              </label>
	              <label>
	                Искать также в описании
	              </label>
	            </div>
	        </div>
            
          </div>  <!-- end "col-md-12" -->
      </div>  <!-- end "box-body" -->
            
		
		<div class="box-body">
	  		<div class="col-md-9">   
		         
		    <!-- Пояснение в случае удаления товарного кода из запроса -->
	        <div class="col-md-12" id="code_un">
		        <div class="form-group alert alert-info" >
					Если требуется отменить поиск по товарному коду услуги и выбрать другие параметры запроса - удалите товарный код услуги и обновите страницу			
		        </div>
	        </div>
		         <!-- Товарный код услуги-->
		         <div class="col-md-4">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">Товарный код услуги</label>
			          <input type="text" class="form-control" id="product_code_id" name="product_code_id" >
			        </div>
			     </div>
			     
			     <!-- Статус услуги искомой (опубликованные / все (вкл. архивные)-->
			     <div class="form-group">
					<p class="help-block">Снять, если нужно искать все услуги, включая архивные (не опубликованные)</p>
					<label>
						<input type="checkbox" class="minimal" name="status" id="status" checked>
					</label>
					<label>
						Показать только опубликованные услуги
					</label>
				</div>
			     
				<!-- Доступность услуги-->
<!--				<div class="col-md-4">
		            <div class="form-group">
		              <label>Доступность услуги</label>
		                <select class="form-control select2" name="availability" id="availability" style="width: 100%;">
			              	<option style="width: 100%" value="">- выберите доступность -</option>
			              	<option style="width: 100%" value="1">В наличии</option>
			              	<option style="width: 100%" value="2">Под заказ</option>
		               </select>
		            </div>
				</div>-->
				<!-- Условия оплаты-->
<!--		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Условия оплаты</label>
		                <select class="form-control select2" name="terms_payment" id="terms_payment" style="width: 100%;">
			              	<option style="width: 100%" value="">- выберите срок -</option>
			              	<option style="width: 100%" value="1">Предоплата</option>
			              	<option style="width: 100%" value="2">Оплата после/в момент получения услуги</option>
			              	<option style="width: 100%" value="3">Аванс</option>
			              	<option style="width: 100%" value="4">Поэтапная оплата</option>
			              	<option style="width: 100%" value="5">Любой способ оплаты</option>
		               </select>
		            </div>
				</div>-->
			     
			</div>  <!-- end "col-md-9" -->			     
		</div>   <!-- end "box-body" -->
	  
	  <div class="box-body">
		  <div class="col-md-9">
	        <!-- Раздел -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Раздел</label>
		              <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;">
			              	<option value="">- выберите раздел -</option>
			              	@foreach($sections as $section)
		                		<option value="{{$section->id}}">{{$section->title}}</option>
		              		@endforeach
		              </select>
	            </div>
	         </div>
	            
	            <!-- Категория -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Категория</label>
		              <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
		              </select>
	            </div>
	        </div>
	        
	        <!-- Вид услуг -->
	        <div class="col-md-4">    
	            <div class="form-group">
	              <label>Вид услуг</label>
		              <select class="form-control select2" name="kind_id" id="kind_id" style="width: 100%;">
		              </select>
	            </div>
            </div>
          </div>  <!-- end "box-body" -->
      </div>  <!-- end "col-md-9" -->
      

	  <div class="box-body">
		  <div class="col-md-9">            
	        <!-- Пояснение в случае не корректно указанных дат -->
	        <div class="col-md-12" id="date_un">
		        <div class="form-group alert alert-warning" >
					В запросе дата "ОТ" должна быть раньше даты "ДО". Дата ЗАПУСКА публикации услуги должна быть раньше даты ОКОНЧАНИЯ публикации
		        </div>
	        </div>
	        <!-- Диапазон дат публикации услуги -->
	         <div class="col-md-6">
		        <label>Дата ЗАПУСКА публикации услуги (для ОТ - поиск большей даты):</label>
		        <div class="col-md-6">
		            <div class="form-group">
		              <label>ОТ</label>
		              <div class="input-group date">
		                <div class="input-group-addon">
		                  <i class="fa fa-calendar"></i>
		                </div>
		                <input type="text" class="form-control pull-right" id="datepicker" name="date_on_start" value="">
		              </div>
		            </div>
				</div>
					              
		        <div class="col-md-6">
		            <div class="form-group">
		              <label>ДО</label>	              
		              <div class="input-group date">
		                <div class="input-group-addon">
		                  <i class="fa fa-calendar"></i>
		                </div>
		                <input type="text" class="form-control pull-right" id="datepicker1" name="date_on_end" value="">
		              </div>
		              <!-- /.input group -->
		            </div>
				</div>
			</div>
	         
	         <div class="col-md-6">
		        <label>Дата ОКОНЧАНИЯ публикации услуги (для ДО - поиск меньшей даты):</label>
		        <div class="col-md-6">
		            <div class="form-group">
		              <label>ОТ</label>
		              <div class="input-group date">
		                <div class="input-group-addon">
		                  <i class="fa fa-calendar"></i>
		                </div>
		                <input type="text" class="form-control pull-right" id="datepicker2" name="date_off_start" value="">
		              </div>
		            </div>
				</div>
					              
		        <div class="col-md-6">
		            <div class="form-group">
		              <label>ДО</label>	              
		              <div class="input-group date">
		                <div class="input-group-addon">
		                  <i class="fa fa-calendar"></i>
		                </div>
		                <input type="text" class="form-control pull-right" id="datepicker3" name="date_off_end" value="">
		              </div>
		              <!-- /.input group -->
		            </div>
				</div>
			</div>
            
 
          </div>  <!-- end "box-body" -->
      </div>  <!-- end "col-md-9" -->
      
      
      <div class="box-body">
          <div class="col-md-9">
      		<!-- Тип торгов -->
	        <div class="col-md-6">
	          <div class="form-group">
	        	<label for="exampleInputEmail1">Тип торгов</label>
				<select class="form-control select2" name="bidding_type" id="bidding_type" style="width: 100%;">
		              	<option value="">- выберите тип торгов -</option>
			            @foreach($bidding_types as $bidding_type)
		                	<option value="{{$bidding_type->id}}">{{$bidding_type->title}}</option>
		              	@endforeach
               </select>
	          </div>	
	        </div>
          </div>  <!-- end "box-body" -->
      </div>  <!-- end "col-md-9" -->


	  <div class="box-body">
		  <div class="col-md-9">            
	        <!-- Пояснение в случае указания некорректного диапазона цен -->
	        <div class="col-md-12" id="price_all">
		        <div class="form-group alert alert-warning" >
					В запросе минимальная цена должна быть меньше максимальной
		        </div>
	        </div>
	        <!-- Пояснение в случае не выбранного типа торгов -->
	        <div class="col-md-12" id="price_type">
		        <div class="form-group alert alert-info" >
					Если тип торгов не выбран, по умолчанию цена сравнивается только с ценами услуг в Аукционах и Тендерах
		        </div>
	        </div>
	        <!-- Диапазон фиксированных цен услуг -->
	         <div class="col-md-6" id="price_f">
		        <label>ФИКСИРОВАННЫЕ цены (для усгуг по ценам Купить сразу/Продать сразу):</label>
		        <div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Минимальная цена</label>
		        	  <input type="text" class="form-control" id="price_f_min" placeholder="" name="price_f_min" value="{{old('price_f_min')}}">               		<span>  грн</span>
		            </div>
				</div>
					              
		        <div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Максимальная цена</label>
		        	  <input type="text" class="form-control" id="price_f_max" placeholder="" name="price_f_max" value="{{old('price_f_max')}}">               		<span>  грн</span>
		            </div>
				</div>
			</div>
	         
	         <!-- Диапазон начальных цен услуг -->
	         <div class="col-md-6" id="price_s">
		        <label>НАЧАЛЬНЫЕ цены услуг (задаются для услуг в Аукционах/Тендерах):</label>
<div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Минимальная цена</label>
		        	  <input type="text" class="form-control" id="price_s_min" placeholder="" name="price_s_min" value="{{old('price_s_min')}}">               		<span>  грн</span>
		            </div>
				</div>
					              
		        <div class="col-md-6">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Максимальная цена</label>
		        	  <input type="text" class="form-control" id="price_s_max" placeholder="" name="price_s_max" value="{{old('price_s_max')}}">               		<span>  грн</span>
		            </div>
				</div>
			</div>
            
 
          </div>  <!-- end "box-body" -->
      </div>  <!-- end "col-md-9" -->      
      
      		<p></p>
        <p></p>  <!-- Адрес предоставления услуги -->
		<div class="box-body">
			<p><label for="exampleInputEmail1">Основной Адрес предоставления услуги </label></p>
			<div class="col-md-9">
	            <!-- Область -->
		        <div class="col-md-4">
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
		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Город</label>
			              <select class="form-control select2" name="city" id="city" style="width: 100%;" >
			              </select>
		            </div>
	            </div>
				
				<!-- Район -->
		        <div class="col-md-4" id="district_all">    
		            <div class="form-group">
		              <label>Район</label>
			              <select class="form-control select2" name="district" id="district" style="width: 100%;">
				              	
			              </select>
		            </div>
	            </div>

			</div>  <!-- end "col-md-9" -->
		</div>  <!-- end "box-body" -->
      
        
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-success">Вывести данные по услугам</button>
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

<!-- Связанные списки разделов и категорий -->
<script type="text/javascript">
    $('#section_id').change(function(){
        var sectionID = $(this).val();    
        if(sectionID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/index/getcat')}}?section_id="+sectionID,
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
                }
               }
            });
        }else{
            $("#category_id").empty();
            $("#kind_id").empty();
        }      
       });
        
        $('#category_id').on('change',function(){
        var categoryID = $(this).val();    
        if(categoryID){
            $.ajax({
               type:"GET",
               url:"{{url('/admin/services/index/getkind')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#kind_id").empty();
                    $("#kind_id").append('<option value="">- выберете вид услуг -</option>');
                    $.each(res,function(key,value){
                        $("#kind_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#kind_id").empty();
                }
               }
            });
        }else{
            $("#kind_id").empty();
        }

       });
</script>

<!-- Вывод сообщения об очередности выбора разделов, категорий и видов услуг ***НЕ РАБОТАЕТ -->
<script type="text/javascript">
//	jQuery(document).ready(function($){
//		//Курсор мышки на категории
//		$('#category_id').bind('click', function(){
//			alert('Выберите в начале раздел');
//			if($("#section_id[document_type]").val() == ''){
//				alert('Выберите в начале раздел');
//			}
//		});
//		//Курсор мышки на виде услуг
//		$('#kind_id').bind('click', function(){
//			alert('Выберите в начале категорию');
//			if($("#category_id[document_type]" == '').val()){
//				alert('Выберите в начале категорию');
//			}
//		});
//	});
</script>

<!-- Получение часового пояса пользователя -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		var date_on = new Date();
		var offset = -1 * date_on.getTimezoneOffset() * 60;  /* Вычисление смещения часового пояса пользователя относительно 'UTC'.  На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */
		$("#date_offset").val(offset);
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
	  $("#product_code_id").mask("999999-9999");
	});
</script>	

<!-- Связанные списки областей, городов, районов -->
<script type="text/javascript">
    //Связанные списки областей, городов, районов
    $('#region').change(function(){
        var region = $(this).val();    
        if(region){
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/index/getcities')}}?region="+region,
               success:function(res){               
                if(res){
                    $("#city").empty();
                    $("#district").empty();
                    $("#city").append('<option value="">- выберете город -</option>');
                    $.each(res,function(id, value){
                        $("#city").append('<option value="'+value+'">'+value+'</option>');
                    });

                }else{
                   $("#city").empty();
                   $("#district").empty();
                }
               }
            });
        }else{
            $("#city").empty();
            $("#district").empty();
        }      
       });
        
        //Связанные списки городов и районов (разделить города с одинаковым названием), городов и улиц (когда город один в области)
        $('#city').on('change',function(){
        var city = $(this).val();    
        var region = $("#region").val();    
        if(city){
            $.ajax({
               type:"GET",
               url:"{{url('/admin/services/index/getdistricts')}}?city="+city+"&region="+region,
               success:function(res){               
		            if(res[1]){
		                $("#district_all").css("display", "inline-block");
		                $("#district").empty();
		                $("#district").append('<option value="">- выберете район -</option>');
		                $.each(res,function(id,value){
		                    $("#district").append('<option value="'+value+'">'+value+'</option>');
		                });

		                }
	               } //end success:function(res)
	            });
	        }else{
	            $("#district").empty();
	            $("#district").val('');
	            $("#district_all").css("display", "none");
	        }
       	}); //end  $('#city').on
 	

</script>

<!-- Деактивация остальных полей при вводе товарного кода услуги -->
<script type="text/javascript">
	$('#product_code_id').change(function(){
        var productCodeID = $(this).val();    
        if(productCodeID){
			$("#code_un").css("display", "inline-block");
            
            $("#services_title").empty();	// Очистка инпута
            $("#in_content").empty();
            $("#availability").empty();
            $("#terms_payment").empty();
            $("#section_id").empty();
            $("#category_id").empty();
            $("#kind_id").empty();
            $("#datepicker").empty();
            $("#datepicker1").empty();
            $("#bidding_type").empty();
            $("#price_min").empty();
            $("#price_max").empty();
            $("#region").empty();
            $("#city").empty();
            $("#district").empty();
            
            $("#services_title").val('');
            $("#availability").val('');
            $("#terms_payment").val('');
            $("#section_id").val('');
            $("#category_id").val('');
            $("#kind_id").val('');
            $("#datepicker").val('');
            $("#datepicker1").val('');
            $("#bidding_type").val('');
            $("#price_min").val('');
            $("#price_max").val('');
            $("#region").val('');
            $("#city").val('');
            $("#district").val('');
            
            $("#services_title").prop("disabled", true);  // Блокировка инпута
            $("#in_content").prop("disabled", true);
            $("#availability").prop("disabled", true);
            $("#terms_payment").prop("disabled", true);
            $("#section_id").prop("disabled", true);
            $("#category_id").prop("disabled", true);
            $("#kind_id").prop("disabled", true);
            $("#datepicker").prop("disabled", true);
            $("#datepicker1").prop("disabled", true);
            $("#bidding_type").prop("disabled", true);
            $("#price_min").prop("disabled", true);
            $("#price_max").prop("disabled", true);
            $("#region").prop("disabled", true);
            $("#city").prop("disabled", true);
            $("#district").prop("disabled", true);
        }
        if(productCodeID == ''){
			$("#services_title").prop("enabled", true);   // Разблокировка инпута 
            $("#in_content").prop("enabled", true);
            $("#availability").prop("enabled", true);
            $("#terms_payment").prop("enabled", true);
            $("#section_id").prop("enabled", true);
            $("#category_id").prop("enabled", true);
            $("#kind_id").prop("enabled", true);
            $("#datepicker").prop("enabled", true);
            $("#datepicker1").prop("enabled", true);
            $("#bidding_type").prop("enabled", true);
            $("#price_min").prop("enabled", true);
            $("#price_max").prop("enabled", true);
            $("#region").prop("enabled", true);
            $("#city").prop("enabled", true);
            $("#district").prop("enabled", true);
		}
    });
    
    // check if autocomplete has been cleared
//	$("#product_code_id").on('mouseout', function() {
//	    var $d = $('#product_code_id[document_type]');
//		if ($d.val() == null) {
//		  	location.reload();

//	        $("#services_title").prop("enabled", true);   // Разблокировка инпута 
//            $("#in_content").prop("enabled", true);
//            $("#availability").prop("enabled", true);
//            $("#terms_payment").prop("enabled", true);
//            $("#section_id").prop("enabled", true);
//            $("#category_id").prop("enabled", true);
//            $("#kind_id").prop("enabled", true);
//            $("#datepicker").prop("enabled", true);
//            $("#datepicker1").prop("enabled", true);
//            $("#bidding_type").prop("enabled", true);
//            $("#price_min").prop("enabled", true);
//            $("#price_max").prop("enabled", true);
//            $("#region").prop("enabled", true);
//            $("#city").prop("enabled", true);
//            $("#district").prop("enabled", true);
//	    }
//	});

	//Если при обновлении страницы в инпуте товарного кода есть содержимое - блокировать остальные поля
	jQuery(document).ready(function($){
		var $d = $('#product_code_id');
		if($d.val()) {
			$("#code_un").css("display", "inline-block");
			
			$("#services_title").empty();	// Очистка инпута
            $("#in_content").empty();
            $("#availability").empty();
            $("#terms_payment").empty();
            $("#section_id").empty();
            $("#category_id").empty();
            $("#kind_id").empty();
            $("#datepicker").empty();
            $("#datepicker1").empty();
            $("#bidding_type").empty();
            $("#price_min").empty();
            $("#price_max").empty();
            $("#region").empty();
            $("#city").empty();
            $("#district").empty();
            
            $("#services_title").val('');
            $("#availability").val('');
            $("#terms_payment").val('');
            $("#section_id").val('');
            $("#category_id").val('');
            $("#kind_id").val('');
            $("#datepicker").val('');
            $("#datepicker1").val('');
            $("#bidding_type").val('');
            $("#price_min").val('');
            $("#price_max").val('');
            $("#region").val('');
            $("#city").val('');
            $("#district").val('');
            
            $("#services_title").prop("disabled", true);  // Блокировка инпута
            $("#in_content").prop("disabled", true);
            $("#availability").prop("disabled", true);
            $("#terms_payment").prop("disabled", true);
            $("#section_id").prop("disabled", true);
            $("#category_id").prop("disabled", true);
            $("#kind_id").prop("disabled", true);
            $("#datepicker").prop("disabled", true);
            $("#datepicker1").prop("disabled", true);
            $("#bidding_type").prop("disabled", true);
            $("#price_min").prop("disabled", true);
            $("#price_max").prop("disabled", true);
            $("#region").prop("disabled", true);
            $("#city").prop("disabled", true);
            $("#district").prop("disabled", true);
		}
	});



</script>

<!-- Деактивация остальных полей при поиске по описанию  ***НЕ РАБОТАЕТ -->
<script type="text/javascript">
//	$('#in_content').change(function(){
//        alert($('#in_content').val());
//        if($(this).is(':checked')){
////			$("#code_un").css("display", "inline-block");
//            alert($('#in_content').val());
//            $("#availability").empty();		
//            $("#terms_payment").empty();
//            $("#section_id").empty();		// Очистка инпута
//            $("#category_id").empty();
//            $("#kind_id").empty();
//            $("#datepicker").empty();
//            $("#datepicker1").empty();
//            $("#bidding_type").empty();
//            $("#price_min").empty();
//            $("#price_max").empty();
//            $("#region").empty();
//            $("#city").empty();
//            $("#district").empty();
//            
//            $("#availability").val('');
//            $("#terms_payment").val('');
//            $("#section_id").val('');		//Значение заменить на пустое
//            $("#category_id").val('');
//            $("#kind_id").val('');
//            $("#datepicker").val('');
//            $("#datepicker1").val('');
//            $("#bidding_type").val('');
//            $("#price_min").val('');
//            $("#price_max").val('');
//            $("#region").val('');
//            $("#city").val('');
//            $("#district").val('');
//            
//            $("#availability").prop("disabled", true);
//            $("#terms_payment").prop("disabled", true);
//            $("#section_id").prop("disabled", true);		// Блокировка инпута
//            $("#category_id").prop("disabled", true);
//            $("#kind_id").prop("disabled", true);
//            $("#datepicker").prop("disabled", true);
//            $("#datepicker1").prop("disabled", true);
//            $("#bidding_type").prop("disabled", true);
//            $("#price_min").prop("disabled", true);
//            $("#price_max").prop("disabled", true);
//            $("#region").prop("disabled", true);
//            $("#city").prop("disabled", true);
//            $("#district").prop("disabled", true);
//        }else{
////            $("#availability").prop("enabled", true);	
////            $("#terms_payment").prop("enabled", true);
////            $("#section_id").prop("enabled", true);		// Разблокировка инпута
////            $("#category_id").prop("enabled", true);
////            $("#kind_id").prop("enabled", true);
////            $("#datepicker").prop("enabled", true);
////            $("#datepicker1").prop("enabled", true);
////            $("#bidding_type").prop("enabled", true);
////            $("#price_min").prop("enabled", true);
////            $("#price_max").prop("enabled", true);
////            $("#region").prop("enabled", true);
////            $("#city").prop("enabled", true);
////            $("#district").prop("enabled", true);
//		}
//    });
//    
 	//Если при обновлении страницы в инпуте товарного кода есть содержимое - блокировать остальные поля
//	jQuery(document).ready(function($){
//		var $d = $('#in_content');
//		alert($d.val());
//		if($d.val() == on) {
////			$("#code_un").css("display", "inline-block");
//			
//            $("#availability").empty();
//            $("#terms_payment").empty();
//            $("#section_id").empty();		// Очистка инпута
//            $("#category_id").empty();
//            $("#kind_id").empty();
//            $("#datepicker").empty();
//            $("#datepicker1").empty();
//            $("#bidding_type").empty();
//            $("#price_min").empty();
//            $("#price_max").empty();
//            $("#region").empty();
//            $("#city").empty();
//            $("#district").empty();
//            
//            $("#availability").val('');
//            $("#terms_payment").val('');
//            $("#section_id").val('');		//Значение заменить на пустое
//            $("#category_id").val('');
//            $("#kind_id").val('');
//            $("#datepicker").val('');
//            $("#datepicker1").val('');
//            $("#bidding_type").val('');
//            $("#price_min").val('');
//            $("#price_max").val('');
//            $("#region").val('');
//            $("#city").val('');
//            $("#district").val('');
//            
//            $("#availability").prop("disabled", true);
//            $("#terms_payment").prop("disabled", true);
//            $("#section_id").prop("disabled", true);		// Блокировка инпута
//            $("#category_id").prop("disabled", true);
//            $("#kind_id").prop("disabled", true);
//            $("#datepicker").prop("disabled", true);
//            $("#datepicker1").prop("disabled", true);
//            $("#bidding_type").prop("disabled", true);
//            $("#price_min").prop("disabled", true);
//            $("#price_max").prop("disabled", true);
//            $("#region").prop("disabled", true);
//            $("#city").prop("disabled", true);
//            $("#district").prop("disabled", true);
//		}
//	});
</script>

<!-- Показ предупреждений о корректности выбора дат публикации услуги в запросе -->
<script type="text/javascript">
	//Перевод вводимого в input значения даты в формат, допустимый в JAVA
	function formatDate(value){
		var date = "20" + value[6] + value[7] + ", " + value[3] + value[4] + ", " + value[0] + value[1];
		return date;
	}
	
	//Проверка корректности заданных в запросе дат начала и окончатня публикации услуги
	function compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end){
		if($date_on_start > $date_on_end || $date_off_start > $date_off_end || $date_off_start < $date_on_start || $date_off_end < $date_on_end || $date_off_start < $date_on_end || $date_off_end < $date_on_start){
			$("#date_un").css("display", "inline-block");
		}else{
			$("#date_un").css("display", "none");
		}
	}
    
    jQuery(document).ready(function($){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
    
    $('#datepicker').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
    $('#datepicker1').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
	$('#datepicker2').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
	$('#datepicker3').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
</script>

<!-- Проверка типа аукциона и приведние страницы в соответствие с ним -->
<script type="text/javascript">
		jQuery(document).ready(function($){
			var BID = $("#bidding_type").val();
			if(BID){
				switch (BID) {
				  case '2':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '3':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '4':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '5':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '6':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '7':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  default:
				    break;
				}
			}else{
				$("#price_f").css("display", "none");
				$("#price_s").css("display", "inline-block");
			}
		});
		
		
		$('#bidding_type').change(function(){
			var biddingID = $(this).val();
			
			$("#price_f").css("display", "none");
			$("#price_s").css("display", "none");
		
			if(biddingID){
				switch (biddingID) {
				  case '2':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '3':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '4':

				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '5':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '6':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '7':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  default:
				    break;
				}
			}else{
				$("#price_f").css("display", "none");
				$("#price_s").css("display", "inline-block");
			}
		
	});
</script>

<!-- Проверка соответствия диапазонов цен -->
<script type="text/javascript">
   //Функция сравнения минимальной и максимальной цен
   function comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max){
   		if((($price_f_max - $price_f_min < 0) && $price_f_max && $price_f_min) || (($price_s_max - $price_s_min < 0) && $price_s_max && $price_s_min)){
			$("#price_all").css("display", "inline-block");
		}else{
			$("#price_all").css("display", "none");
		}
   }
   function priceInfo(){
   		if(!$("#bidding_type").val()){
			$("#price_type").css("display", "inline-block");
		}else{
			$("#price_type").css("display", "none");
		}
   }
   
   jQuery(document).ready(function($){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
	});
    
    $('#price_f_min').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#price_f_max').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#price_s_min').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#price_s_max').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#bidding_type').change(function(){
		priceInfo();
	});
</script>

@endpush