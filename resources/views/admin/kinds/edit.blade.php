@push('styles')
	<style>
      #category_id_v, #category_title {
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
        Изменить вид услуг
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем вид услуг</h3>
          @include('admin.errors')
        </div>
        
        <form method="POST" action="{{ route('kinds.update') }}">
		  	@csrf
		  	<input type="hidden" name="id" value ="{{$kind->id}}">
		  	
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название ВИДА услуг</label>
	              <input type="text" class="form-control" id="title" name="title" placeholder="" value="{{$kind->title}}">
	            </div>
	          </div>
	        </div>
	        
	        <div class="box-body">
	        	<!-- Раздел -->
		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Измените раздел, в который входит ВИД услуг</label>
			              <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;">
				              	<option selected="selected" value="{{$kind->getSectionID()}}">{{$kind->getSectionTitle()}}</option>
				              	@foreach($sections as $section)
			                		<option value="{{$section->id}}">{{$section->title}}</option>
			              		@endforeach
			              </select>
		            </div>
		         </div>
		            
		            <!-- Категория -->
		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Измените категорию, к которой относится ВИД услуг</label>
			              <input type="text" name="category_title" id="category_title" value="{{$kind->getCategoryTitle()}}" style="width: 100%;" />
						  <input type="hidden" name="category_id" id="category_id" value="{{$kind->getCategoryID()}}" />
			              <select  name="category_id_v" id="category_id_v" style="width: 100%;">
			              </select>
		            </div>
		        </div>
	        </div>
	        
	        <div class="box-body">
	        	<div class="col-md-1">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">Код (категории) </label>
			          <input type="text" class="form-control" id="c_code" placeholder="XXYY" name="c_code" value="{{$kind->getCategoryCode()}}" disabled>
			          <input type="hidden" class="form-control" id="cat_code" name="cat_code" value="{{$kind->getCategoryCode()}}">
			        </div>
			     </div>
			     <div class="col-md-1">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">- (вида услуги) </label>
			          <input type="text" class="form-control" id="code" placeholder="ZZ" name="code" maxlength="2" minlength="2" value="{{$kind->getKindEndCode()}}">
			        </div>
			     </div>
	        </div>
	        
	        <div class="box-body">
	        	<div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Ключевые слова</label>
	              <input type="text" class="form-control" id="keywords" name="keywords" placeholder="" value="{{$kind->keywords}}">
	            </div>
	          </div>
	        </div>
	        
	        <div class="box-body">
	        	<div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Описание для тега</label>
	              <input type="text" class="form-control" id="description" name="description" placeholder="" value="{{$kind->description}}">
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

<script type="text/javascript">
	$(document).ready(function(){
        $("#category_title").css("display", "inline-block");
        
        $('#category_title').bind('mouseover', function(){
		    $("#category_title").css("display", "none");
		    $("#category_id_v").css("display", "inline-block");
		    $("#category_id_v").addClass('form-control');
		    $("#category_id_v").addClass('select2');
		    
		    var sectionID = $("#section_id").val();
		    /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/admin/kinds/edit/getcategory')}}?section_id="+sectionID,
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
                	$("#cat_code").empty();
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
               url: "{{url('/admin/kinds/edit/getcategory')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id_v").empty();
                    $("#category_id_v").append('<option value="">- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id_v").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   	$("#category_id_v").empty();
                   	$("#kind_id").empty();
                   	
                   	$("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                	$("#c_code").empty();
                	$("#cat_code").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#category_id_v").empty();
                        
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            $("#cat_code").val('');
            $("#c_code").val('');
            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
        }      
    });
       
    /* Автоматический ввод кода для выбранной категории */   
    $('#category_id_v').change(function(){
        var categoryID = $(this).val();    
        if(categoryID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/admin/kinds/edit/getcategorycode')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                    $("#c_code").empty();                 /* Очистка инпута */
                    $("#cat_code").val(res);
                    $("#c_code").val(res);
                    $("#c_code").prop("disabled", true);  /* Блокировка инпута */
                    
                    $('#category_id').val(categoryID);                    
                }else{
                    $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                    $("#c_code").empty();
                    $("#cat_code").empty();
                    $("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            $("#cat_code").val('');
            $("#c_code").val('');
            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
        }      
    });   
        
        
</script>

<!-- Ограничение поля ввода кода вида ЦИФРАМИ -->
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