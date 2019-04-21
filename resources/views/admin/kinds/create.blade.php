@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить ВИД услуг
     </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      
      
    	<form method="POST" action="{{ route('kinds.store') }}">
		  	@csrf
		  
		    <div class="box-header with-border">
		      <h3 class="box-title">ВИД услуг входит в одну из КАТЕГОРИЙ, которая в свою очередь входит в некий РАЗДЕЛ</h3>
		      @include('admin.errors')
		    </div>
		    		     
		    <div class="box-body">
		      <div class="col-md-6">
		        <div class="form-group">
		          <label for="exampleInputEmail1">Название ВИДА услуг</label>
		          <input type="text" class="form-control" id="kind_id" placeholder="" name="title">
		        </div>
		      </div>
		    </div>
		    
		    <div class="box-body">
			     	<!-- Раздел -->
		        <div class="col-md-4">
		            <div class="form-group">
		              <label>Раздел</label>
		              <p><small>Выберите раздел в который входит ВИД</small></p>
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
		              <p><small>Выберите категорию к которой относится ВИД</small></p>
			              <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
			              </select>
		            </div>
		        </div>
		     </div>
		     
		     <div class="box-body">   
		         <div class="col-md-1">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">Код (категории) </label>
			          <input type="text" class="form-control" id="c_code" placeholder="XXYY" name="c_code" disabled>
			          <input type="hidden" class="form-control" id="cat_code" name="cat_code">
			        </div>
			     </div>
			     <div class="col-md-1">  
			        <div class="form-group">
			          <label for="exampleInputEmail1">- (вида услуги) </label>
			          <input type="text" class="form-control" id="code" placeholder="ZZ" name="code" maxlength="2" minlength="2">
			        </div>
			     </div>
			     
		    
		    </div>
		    
		   
		    
		    <!-- /.box-body -->
		    <div class="box-footer">
		       <button class="btn btn-success pull-right">Добавить</button>
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
  	$('#section_id').change(function(){
        var sectionID = $(this).val();    
        if(sectionID){
            /* Связанные списки разделов, категорий */
            $.ajax({
               type:'GET',
               url: "{{url('/admin/kinds/create/getcategory')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id").empty();
                    $("#category_id").append('<option value="">- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   	$("#category_id").empty();
                   	$("#kind_id").empty();
                   	
                   	$("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                	$("#c_code").empty();
                	$("#cat_code").empty();
					$("#c_code").prop("disabled", true);  /* Блокировка инпута */
                }
               }
            });
        }else{
            $("#category_id").empty();
            $("#kind_id").empty();
            
            $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
            $("#c_code").empty();
            $("#cat_code").val('');
            $("#c_code").val('');
            $("#c_code").prop("disabled", true);  /* Блокировка инпута */
        }      
    });
       
    /* Автоматический ввод кода для выбранной категории */   
    $('#category_id').change(function(){
        var categoryID = $(this).val();    
        if(categoryID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/admin/kinds/create/getcategorycode')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#c_code").prop("enabled", true);   /* Разблокировка инпута */
                    $("#c_code").empty();                 /* Очистка инпута */
                    $("#cat_code").val(res);
                    $("#c_code").val(res);
                    $("#c_code").prop("disabled", true);  /* Блокировка инпута */
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

<!-- Ограничение поля ввода кода вида ДВУМЯ ЦИФРАМИ -->
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