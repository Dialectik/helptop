@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить платную опцию
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      
    	<form method="POST" action="{{ route('bidding_rates.update', $bidding_rate->id) }}">
		  	@csrf
		  	<input type="hidden" name="_method" value="PUT">
		  
		    <div class="box-header with-border">
		      <h3 class="box-title">Изменяем платную опцию</h3>
		      @include('admin.errors')
		    </div>
		    <div class="box-body">
		      <!-- Тип торгов -->
		      <div class="col-md-3">
		        <div class="form-group">
		          <label for="exampleInputEmail1">Тип торгов</label>
		           	<select class="form-control select2" name="bidding_type" id="bidding_type" style="width: 100%;" required>
		              	<option selected="selected" value="{{$bidding_rate->bidding_type}}">{{$bidding_rate->biddingTypeTitle()}}</option>
			            @foreach($bidding_types as $bidding_type)
		                	<option value="{{$bidding_type->id}}">{{$bidding_type->title}}</option>
		              	@endforeach
               		</select>
		        </div>
		      </div>
		      

		      
		      <!-- Начальная цена диапазона -->
		      <div class="col-md-3">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Начальная цена диапазона</label>
		          <input type="text" class="form-control" id="price_start" name="price_start" value="{{$bidding_rate->price_start}}" required>
		        </div>
		      </div>
		      <!-- Конечная цена диапазона -->
		      <div class="col-md-3">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Конечная цена диапазона</label>
		          <input type="text" class="form-control" id="price_end" name="price_end" value="{{$bidding_rate->price_end}}" required>
		        </div>
		      </div>
		      <!-- Тариф выставления услуги -->
		      <div class="col-md-3">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Тариф выставления услуги</label>
		          <input type="text" class="form-control" id="rate_bidding" name="rate_bidding" value="{{$bidding_rate->rate_bidding}}" required>
		        </div>
		      </div>

		    </div> <!-- /"box-body" -->
		      

		    
		    
		    <div class="box-footer">
		       <button class="btn btn-warning pull-right">Изменить</button>
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
		$('#price_start').forceDecimalOnly();
		$('#price_end').forceDecimalOnly();
		$('#rate_bidding').forceDecimalOnly();
		
	});
	
</script>

@endpush