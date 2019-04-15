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
          <div class="col-md-9">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="services_title" placeholder="" name="title" value="{{old('title')}}">
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
            
	            <!-- Date -->
	        <div class="col-md-6">
	            <div class="form-group">
	              <label>Дата запуска публикации услуги:</label>

	              <div class="input-group date">
	                <div class="input-group-addon">
	                  <i class="fa fa-calendar"></i>
	                </div>
	                <input type="text" class="form-control pull-right" id="datepicker" name="date_on" value="{{old('date')}}">
	              </div>
	              <!-- /.input group -->
	            </div>
			</div>
			
			<div class="col-md-6">
	            <div class="form-group">
	              <label>Дата завершения публикации услуги:</label>

	              <div class="input-group date">
	                <div class="input-group-addon">
	                  <i class="fa fa-calendar"></i>
	                </div>
	                <input type="text" class="form-control pull-right" id="datepicker1" name="date_off" value="{{old('date')}}">
	              </div>
	              <!-- /.input group -->
	            </div>
            </div>
            
            <!-- checkbox -->
            <div class="form-group">
              <label>
                <input type="checkbox" class="minimal" name="is_featured" value="1">
              </label>
              <label>
                Рекомендованные
              </label>
            </div>
            
            

            
          </div>
          
          
          
          
          
          
          
          
      </div>
        
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
                    $("#category_id").append('<option>- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#category_id").empty();
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
       
       
</script>
@endpush