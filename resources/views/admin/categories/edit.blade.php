@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить категорию
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем категорию</h3>
          @include('admin.errors')
        </div>
        
        <form method="POST" action="{{ route('categories.update') }}">
		  	@csrf
		  	<input type="hidden" name="id" value ="{{$category->id}}">
		  	
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название КАТЕГОРИИ</label>
	              <input type="text" class="form-control" id="title" name="title" placeholder="" value="{{$category->title}}">
	            </div>
	          </div>
	        </div>
	        
	        	<!-- Раздел -->
	        <div class="box-body">	
		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Измените РАЗДЕЛ, в который входит категория</label>
			              <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;">
				              	<option selected="selected" value="{{$category->getSectionID()}}">{{$category->getSectionTitle()}}</option>
				              	@foreach($sections as $section)
			                		<option value="{{$section->id}}">{{$section->title}}</option>
			              		@endforeach
			              </select>
		            </div>
		         </div>
		         <div class="col-md-1">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">Код (раздела)</label>
			          <input type="text" class="form-control" id="_code" placeholder="YY" name="_code" value="{{$category->getSectionCode()}}"  disabled>
			          <input type="hidden" class="form-control" id="pre_code" name="pre_code" value="{{$category->getSectionCode()}}">
			        </div>
			     </div>
		         <div class="col-md-1">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">- (категории) </label>
			          <input type="text" class="form-control" id="code" placeholder="XX" name="code" maxlength="2" minlength="2" value="{{$category->getCatEndCode()}}">
			        </div>
			     </div>
	        </div>
	        
	        <div class="box-body">
	        	<div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Ключевые слова</label>
	              <input type="text" class="form-control" id="keywords" name="keywords" placeholder="" value="{{$category->keywords}}">
	            </div>
	          </div>
	        </div>
	        
	        <div class="box-body">
	        	<div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Описание для тега</label>
	              <input type="text" class="form-control" id="description" name="description" placeholder="" value="{{$category->description}}">
	            </div>
	          </div>
	        </div>
	        	        
	        
	        <!-- /.box-body -->
	        <div class="box-footer">
	            <button class="btn btn-warning pull-right">Изменить</button>
	        </div>
	        <!-- /.box-footer-->
        </form>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@push('scripts')
<!-- Автоматический ввод кода для выбранного раздела -->
<script type="text/javascript">
    
    $('#section_id').change(function(){
        var sectionID = $(this).val();
         if(sectionID){
             $.ajax({
               type:'GET',
               url: "{{url('/admin/categories/edit/getsectioncode')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#_code").prop("enabled", true);   /* Разблокировка инпута */
                    $("#_code").empty();                 /* Очистка инпута */
                    $("#pre_code").val(res);
                    $("#_code").val(res);
                    $("#_code").prop("disabled", true);  /* Блокировка инпута */
                }else{
                    $("#_code").prop("enabled", true);   /* Разблокировка инпута */
                    $("#_code").empty();
                    $("#pre_code").empty();
                    $("#_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#_code").empty();
            $("#pre_code").val('');
            $("#_code").val('');
            $("#_code").prop("disabled", true);  /* Блокировка инпута */
        }      
       });
</script>
<!-- Ограничение поля ввода кода раздела ДВУМЯ ЦИФРАМИ -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		$.fn.forceNumbericOnly = function() {
			return this.each(function()
			{
			    $(this).keydown(function(e)
			    {
			        var key = e.charCode || e.keyCode || 0;
			        return ( key == 8 || key == 9 || key == 46 ||(key >= 37 && key <= 40) ||(key >= 48 && key <= 57) ||(key >= 96 && key <= 105) || key == 107 || key == 109 || key == 173|| key == 61  ); 
			        });
				});
			};
		$('#code').forceNumbericOnly();
	});
</script>
@endpush