@push('styles')
	<style>
      #category_id_v, #category_title, #kind_id_v, #kind_title {
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
        Изменить услугу
        <small>продажа</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
	<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
	<form method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
		  	@csrf
		  	<input type="hidden" name="_method" value="PUT">
	
	  <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Обновляем услугу</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-9">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="title" placeholder="" value="{{$service->title}}" name="title">
            </div>
            
            
                            <!-- Раздел -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Измените РАЗДЕЛ, в который входит вид услуг</label>
		              <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;">
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
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Измените КАТЕГОРИЮ, к которой относится вид услуг</label>
						<input type="text" name="category_title" id="category_title" value="{{$service->getCategoryTitle()}}" style="width: 100%;" />
						<input type="hidden" name="category_id" id="category_id" value="{{$service->category_id}}" />
						<select  name="category_id_v" id="category_id_v" style="width: 100%;">
						</select>
	            </div>
            </div>
            
             	<!-- Вид услуг -->
	        <div class="col-md-4">    
	            <div class="form-group">
	              <label>Измените ВИД услуг, к которому относится услуга</label>
					<input type="text" name="kind_title" id="kind_title" value="{{$service->getKindTitle()}}" style="width: 100%;" />
					<input type="hidden" name="kind_id" id="kind_id" value="{{$service->kind_id}}" />
					<select  name="kind_id_v" id="kind_id_v" style="width: 100%;">
					</select>

	            </div>
            </div>
            
            
            <div class="form-group">
              <img src="{{$service->getImage()}}" alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Лицевая картинка</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Измените графический файл для лицевой картинки услуги</p>
            </div>
          </div>  
        </div>    
            
            
        <div class="box-body">  
          <div class="col-md-9">  
	        <!-- Тип торгов -->
	        <div class="col-md-4">
	          <div class="form-group">
	        	<label for="exampleInputEmail1">Тип торгов</label>
				<p class="help-block">Выберете тип ТОРГОВ</p>
	        		        	
				<select class="form-control select2" name="bidding_type" id="bidding_type" style="width: 100%;">
		              	<option selected style="width: 100%" value="{{$service->bidding_type}}">{{$service->bidding_type}}</option>
		              	<option style="width: 100%" value="10">10</option>
		              	<option style="width: 100%" value="11">11</option>
		              	<option style="width: 100%" value="12">12</option>
		              	<option style="width: 100%" value="13">13</option>
		              	<option style="width: 100%" value="14">14</option>
		              	<option style="width: 100%" value="15">15</option>
               </select>

	          </div>	
	        </div>
	        
	        <!-- Цена -->
	        <div class="col-md-4">
		        <div class="form-group">
		        	<label for="exampleInputEmail1">Цена услуги</label>
					<p class="help-block">Укажите начальную цену услуги</p>
		        	
		        	<input type="text" class="form-control" id="price_start" placeholder="" name="price_start" value="{{$service->price_start}}">               		<span>  грн</span>  
		        </div>
	        </div>
          </div>
        </div>  
            
            
            
            <p></p>
            <p></p>
        <div class="box-body">
          <div class="col-md-9">  
                 <!-- Date -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Период публикации:</label>

	              
	                <select class="form-control select2" name="period" id="period" style="width: 100%;">
			              	<option selected style="width: 100%" value="{{$service->period}}">{{$service->period}} дней</option>
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
	                <!-- Скрытое поле  "date_on" из базы данных-->
	                <input type="hidden" name="date_on_bd" id="date_on_bd" value="{{$service->date_on}}">
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
	                <!-- Скрытое поле  "date_off" из базы данных-->
	                <input type="hidden" name="date_off_bd" id="date_off_bd" value="{{$service->date_off}}">
	                <!-- Скрытая передача поля  "date_off"-->
	                <input type="hidden" name="date_off" id="date_off">
	              </div>
	            </div>
            </div>


		     <div class="box-body">   
		         <div class="col-md-4">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">Товарный код услуги</label>
			          <span class="help-block">Формируестя автоматически</span>
			          <input type="text" class="form-control" id="c_code" placeholder="" name="c_code" value="{{substr($service->product_code_id, 0, 6) . '-' . substr($service->product_code_id, 6, 4)}}" disabled>
			          <input type="hidden" class="form-control" id="product_code_id" name="product_code_id" value="{{$service->product_code_id}}">
			        </div>
			     </div>
			     
			     
		    
		    </div>
		

            <!-- checkbox -->
            <div class="form-group">
              <label>
                <input type="checkbox" class="minimal" name="is_featured">
              </label>
              <label>
                Рекомендовать
              </label>
            </div>

            
          </div>
            
            
            
            
            
            
            
            
         
          
          
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Краткое описание услуги</label>
              <p class="help-block">Опишите кратко предлагаемую услугу для представления ее в перечнях услуг при поиске</p>
              <textarea name="description" id="description" cols="30" rows="10" class="form-control" >{{$service->description}}</textarea>
	        </div>
	      </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полное описание услуги</label>
              <p class="help-block">Дайте исчерпывающе полное описание услуги для показа его на странице данной услуги</p>
              <textarea name="content" id="content" cols="30" rows="10" class="form-control" >{{$service->content}}</textarea>
	        </div>
	      </div>
        
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-warning pull-right">Изменить</button>
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

<script type="text/javascript">
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
               url: "{{url('/admin/services/edit/getcat')}}?section_id="+sectionID,
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
                	$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
		});
		
		
		$('#kind_title').bind('mouseover', function(){
		    $("#kind_title").css("display", "none");
		    $("#kind_id_v").css("display", "inline-block");
		    $("#kind_id_v").addClass('form-control');
		    $("#kind_id_v").addClass('select2');
		    
		    var categoryID = $("#category_id").val();
		    /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/edit/getkind')}}?category_id="+categoryID,
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
                	$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
		});
		
        
    })
</script>

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
               url: "{{url('/admin/services/edit/getcat')}}?section_id="+sectionID,
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
                	$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#category_id_v").empty();
                        
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            $("#product_code_id").val('');
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
               url: "{{url('/admin/services/edit/getkind')}}?category_id="+categoryID,
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
                	$("#product_code_id").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#kind_id_v").empty();
                        
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            $("#product_code_id").val('');
            $("#c_code").val('');
            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
        }      
    });
    
    
    
    
    /*Назначить товарный код услуги для данного вида услуг - следующий по списку*/   
    $('#kind_id_v').change(function(){
        var kindID = $(this).val();    
        if(kindID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/admin/services/edit/getsercode')}}?kind_id="+kindID,
               success:function(res){               
                if(res){
                    $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
	                    $("#c_code").empty();
	                    $("#c_code").val(res.substr(0, 6) + '-' + res.substr(6, 4));
	                    $("#c_code").prop("disabled", true);  /* Блокировка инпута */
	                    $("#product_code_id").empty();
	                    $("#product_code_id").val(res);                    
		                }else{
		                    $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
				            $("#c_code").empty();
				            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
				            $("#product_code_id").empty();
		                }
		               }
		            });
		        }else{
		            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
				    $("#c_code").empty();
				    $("#c_code").val('');					/* Очистка инпута */
				    $("#c_code").prop("disabled", true);  /* Блокировка инпута */
				    $("#product_code_id").empty();
				    $("#product_code_id").val('');					/* Очистка инпута */
		        }      
		    });   
        
        
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
		
		var date_n = new Date();
		var offset_n = -1 * date_n.getTimezoneOffset() * 60000;  /* Вычисление смещения часового пояса пользователя относительно 'UTC' в милисекундах.   */
		
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



<script type="text/javascript">
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
	});
</script>
@endpush