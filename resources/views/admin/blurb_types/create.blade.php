@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить рекламную опцию
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      
    	<form method="POST" action="{{ route('blurb_types.store') }}">
		  	@csrf
		  
		    <div class="box-header with-border">
		      <h3 class="box-title">Добавляем рекламную опцию</h3>
		      @include('admin.errors')
		    </div>
		    <div class="box-body">
		      <!-- Название вида рекламы -->
		      <div class="col-md-4">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Название вида рекламы</label>
		          <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" required>
		        </div>
		      </div>
		      
		      <!-- Рекламный пакет -->
		      <div class="col-md-4">
		        <div class="form-group">
		          <label for="exampleInputEmail1">Рекламный пакет</label>
		           	<select class="form-control select2" name="type_blurb" id="type_blurb" style="width: 100%;" required>
		              	<option value="">- выберите рекламный пакет -</option>
			            <option style="width: 100%" value="Старт">Старт</option>
			            <option style="width: 100%" value="Middle">Middle</option>
			            <option style="width: 100%" value="Лидер">Лидер</option>
               		</select>
		        </div>
		      </div>
		      
		      <!-- Период предоставления рекламы -->
		      <div class="col-md-4">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Период предоставления рекламы</label>
		          <select class="form-control select2" name="period_blurb" id="period_blurb" style="width: 100%;" required>
		              	<option style="width: 100%" value="">- выберите период -</option>
		              	<option style="width: 100%" value="3">3 дня</option>
		              	<option style="width: 100%" value="7">7 дней</option>
		              	<option style="width: 100%" value="14">14 дней</option>
		              	<option style="width: 100%" value="21">21 день</option>
		              	<option style="width: 100%" value="28">28 дней</option>
	               </select>
		        </div>
		      </div>
		      <!-- Код вида рекламы -->
		      <div class="col-md-4">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Код вида рекламы</label>
		          <input type="text" class="form-control" id="code" name="code" value="{{old('code')}}" required>
		        </div>
		      </div>
		      <!-- Стоимость вида рекламы -->
		      <div class="col-md-4">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Стоимость вида рекламы</label>
		          <input type="text" class="form-control" id="blurb_price" name="blurb_price" value="{{old('blurb_price')}}" required>
		        </div>
		      </div>
	      
		    </div> <!-- /"box-body" -->
		    
		    <div class="box-footer">
		       <button class="btn btn-success pull-right">Добавить</button>
		    </div>
		    <!-- /.box-footer-->
    	</form>
      </div>  <!-- /.box -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@push('scripts')

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
		$('#code').forceDecimalOnly();
		$('#blurb_price').forceDecimalOnly();
		
	});
	
</script>

@endpush