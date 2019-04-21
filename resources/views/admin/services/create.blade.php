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
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{old('title')}}">
            </div>
            
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
            
            <div class="form-group">
              <label for="exampleInputFile">Лицевая картинка услуги</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Выберете графический файл для лицевой картинки услуги</p>
            </div>
            
                 <!-- Date -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Период публикации:</label>

	              
	                <select class="form-control select2" name="period" id="period" style="width: 100%;">
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
	                <input type="hidden" name="date_on" id="date_on">
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
	                <input type="hidden" name="date_off" id="date_off">
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
              <textarea name="description" id="description" cols="30" rows="10" class="form-control" >{{old('description')}}</textarea>
	        </div>
	      </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полное описание услуги</label>
              <p class="help-block">Дайте исчерпывающе полное описание услуги для показа его на странице данной услуги</p>
              <textarea name="content" id="content" cols="30" rows="10" class="form-control" ></textarea>
	          </div>
	        </div>
      </div>
        
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
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
<script type="text/javascript">
    /*Связанные списки разделов, категорий и видов услуг*/
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
                    $("#category_id").append('<option>- выберете категорию -</option>');
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
                    $("#kind_id").append('<option>- выберете вид услуг -</option>');
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

			return dd + '.' + mm + '.' + yy + '  ' + hh + ':' + mi + ':' + ss;
		}
		
		
		function addDays(days) {
		  var date_on = new Date();
		  
		  $("#date_start").prop("enabled", true);      /* Разблокировка инпута */
		  $("#date_start").val(formatDate(date_on));
		  $("#date_start").prop("disabled", true);     /* Блокировка инпута */
		  $("#date_on").val(date_on);
		  
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
			$("#date_off").val(date_off);			
		}else{
			$("#date_end").prop("enabled", true);      /* Разблокировка инпута */
			$("#date_end").empty();
			$("#date_end").prop("disabled", true);     /* Блокировка инпута */
			
		}

		
	});

	       
</script>
@endpush