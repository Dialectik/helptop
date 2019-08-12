@push('styles')
	<style>
		#balance_neg  {
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
        Изменение Транзакции №{{ $score->id }}
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title fa fa-pencil"> Изменение Транзакции №{{ $score->id }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              			
				<!--Показывать страницу только если найден пользователь-->
				@if(null != $score->id)
				<form method="POST" action="{{ route('scoreusers.update', $score->id) }}" > 
			  		@csrf
					<input type="hidden" name="_method" value="PUT" >
					<div class="features_items"><!--Данные пользователя-->
						<h2 class="title text-center"><small>Изменение Транзакции</small> №{{ $score->id }}</h2>
						<!-- Default box -->
					      <div class="box">
					        
					        <div class="col-md-12" id="balance_neg">
						        <div class="form-group alert alert-danger" >
									Баланс не может быть отрицательным! Измените операцию/ сумму так, чтобы баланс стале > 0					
						        </div>
					        </div>
					        <!-- Движение средств -->
					        <div class="box-body col-md-12">
					          <div class="col-md-4">
					            <div class="form-group">
					              Сумма &nbsp; 
					              <span style="color:#0D1291; font-weight: bold;">
					              	<input type="hidden" id="sum0" name="sum0" value="<?php if($score->refill > 0){echo $score->refill;}elseif($score->expense){echo $score->expense;}else{echo 0;} ?>">
					              	<input type="number" class="form-control" id="sum" name="sum" min="0" value="<?php if($score->refill > 0){echo $score->refill;}elseif($score->expense){echo $score->expense;}else{echo 0;} ?>"> грн
					              </span>
					            </div>  <!-- end "col-md-4" -->
					          </div>
					          <div class="col-md-4">
					            <div class="form-group">
					              Операция &nbsp; 
					             <span style="color:#0D1291">
					             	<select class="form-control select2" name="operation" id="operation" style="width: 100%;">
					              		<option selected style="width: 100%" value="<?php if($score->refill > 0){echo 1;}elseif($score->expense > 0){echo 2;}else{echo 0;} ?>"><?php if($score->refill > 0){echo 'Зачисление (+)';}elseif($score->expense > 0){echo 'Снятие (-)';}else{echo 'Не проведена/ Ожидается';} ?></option>
							            <option style="width: 100%" value="1">Зачисление (+)</option>
							            <option style="width: 100%" value="2">Снятие (-)</option>
							            <option style="width: 100%" value="0">Не проведена/ Ожидается</option>
						            </select>
					             	
					            </div>
					          </div>  <!-- end "col-md-4" -->
					          <div class="col-md-4">
					            <div class="form-group">
					            	Баланс &nbsp; 
					            	<span style="color:#0D1291">
					             		<input type="hidden" class="form-control" id="balance0" name="balance0" value="<?php if($balance0 > 0){echo $balance0;}else{echo 0;} ?>">
					             		<input type="text" class="form-control" id="balance1" name="balance1" disabled> грн
					             	</span>
					            </div>
					          </div>  <!-- end "col-md-4" -->
					          
					        </div>  <!-- end "box-body" -->
					      
					        
					        <div class="col-md-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-md-12" -->

							<!-- Причина -->
					        <div class="box-body col-md-12">
					          <div class="col-md-4">
					            <div class="form-group">
					              Вид транзакции &nbsp; 
					              <span style="color:#0D1291">
					              	<select class="form-control select2" name="cause" id="cause" style="width: 100%;">
					              		<option selected style="width: 100%" value="{{$score->cause}}">
					              			<?php
						              			switch ($score->cause) {
												  case '1':
												    echo 'Пополнение пользователем';
												    break;
												  case '2':
												    echo 'Возврат';
												    break;
												  case '3':
												    echo 'Бонусная программа';
												    break;
												  case '4':
												    echo 'Оплата публикации';
												    break;
												  case '5':
												    echo 'Оплата рекламы';
												    break;
												  case '6':
												    echo 'Не проведен/ Ожидается';
												    break;
												  case '7':
												    echo 'Корректировка-';
												    break;
												  case '8':
												    echo 'Корректировка+';
												    break;
												  case null:
													echo 'Сбой! Ошибка!';
													break;
												  default:
												    break;
												}
						              		?>
					              		</option>
							            <option style="width: 100%" value="1">Пополнение пользователем</option>
							            <option style="width: 100%" value="2">Возврат</option>
							            <option style="width: 100%" value="3">Бонусная программа</option>
							            <option style="width: 100%" value="4">Оплата публикации</option>
							            <option style="width: 100%" value="5">Оплата рекламы</option>
							            <option style="width: 100%" value="6">Не проведен/ Ожидается</option>
							            <option style="width: 100%" value="7">Корректировка-</option>
							            <option style="width: 100%" value="8">Корректировка+</option>
						            </select>
					              </span>
					            </div>
					          </div>
					          <div class="col-md-8">
					            <div class="form-group">
					              Дата / Время &nbsp;
				              	  <span style="color:#0D1291">
				              	  	{{ $score->getDateAttribute($score->date_trans, $date_offset) }}
				              	  </span>
					            </div>
						      </div>  <!-- end "col-md-6" -->
						    </div>  <!-- end "box-body" -->

							<div class="col-md-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-md-12" -->


							@if(null != $score->blurb_id || null != $score->service_id)
							<!--  -->
					        <div class="box-body col-md-12">
					          <div class="col-md-2">
					            <div class="form-group">
					              	<?php 
					              		if(null != $score->blurb_id){echo 'Оплачена реклама услуги';}elseif(null != $score->service_id){echo 'Оплачена публикация услуги';}
					              	?>
					            </div>
					          </div>  <!-- end "col-md-2" -->
					          <div class="col-md-2">
					            <div class="form-group">
					            	<span style="color:#0D1291">
					            		<?php 
					              			if(null != $score->blurb_id){echo $score->getBlurbTitle();}elseif(null != $score->service_id){echo $score->getRateBiddingTitle();}
					              		?>
					              	</span>
					            </div>
					          </div>  <!-- end "col-md-2" -->
					          <div class="col-md-2">
					            <div class="form-group">
					            	Код услуги &nbsp;
					            	<p><div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;"><?php echo (substr($score->getServiceCode(), 0, 6) . '-' . substr($score->getServiceCode(), 6, 4)) ?></div></p>
					            </div>
					          </div>  <!-- end "col-md-2" -->
					          <div class="col-md-6">
					            <div class="form-group">
					            	<span style="color:#0D1291">
					            		<?php if(isset($score->service->title)){echo $score->service->title;} ?>
					            	</span>
					            </div>
					          </div>  <!-- end "col-md-6" -->
					        </div>  <!-- end "box-body" -->	
					        @endif		
					        
					        <div class="box-footer">
					          <button class="btn btn-warning pull-right">Изменить</button>
					        </div>

					      </div>
					      <!-- /.box -->


					</div><!--/Данные пользователя-->
				</form>
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Нет подробной информации по транзакции</label>
					</div>
				@endif	
				
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@push('scripts')

<!-- Защита от отрицательного баланса -->
<script type="text/javascript">
    $('#sum').change(function(){
		var $balance0 = $("#balance0").val() * 1;
		var $sum0 = $("#sum0").val() * 1;
		var $sum = $("#sum").val() * 1;
		var $delta = $sum - $sum0;
		var $operation = $("#operation").val() * 1;
		if($operation == 1){
			var $balance_new = $balance0 + $delta;
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance_new);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "none");
		}
		if($operation == 2 && ($balance0 - $delta > 0 || $balance0 - $delta == 0)){
			var $balance_new = $balance0 - $delta;
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance_new);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "none");
		}
		if($operation == 2 && $balance0 - $delta < 0){
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance0);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "inline-block");
		}else{
			$("#balance_neg").css("display", "none");
		}
	});
	
	$('#operation').change(function(){
		var $balance0 = $("#balance0").val() * 1;
		var $sum0 = $("#sum0").val() * 1;
		var $sum = $("#sum").val() * 1;
		var $delta = $sum - $sum0;
		var $operation = $("#operation").val() * 1;
		if($operation == 1){
			var $balance_new = $balance0 + $delta;
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance_new);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "none");
		}
		if($operation == 2 && ($balance0 - $delta > 0 || $balance0 - $delta == 0)){
			var $balance_new = $balance0 - $delta;
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance_new);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "none");
		}
		if($operation == 2 && $balance0 - $delta < 0){
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance0);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "inline-block");
		}else{
			$("#balance_neg").css("display", "none");
		}
	});
    
    $(document).ready(function(){
		var $balance0 = $("#balance0").val() * 1;
		var $sum0 = $("#sum0").val() * 1;
		var $sum = $("#sum").val() * 1;
		var $delta = $sum - $sum0;
		var $operation = $("#operation").val() * 1;
		if($operation == 1){
			var $balance_new = $balance0 + $delta;
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance_new);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "none");
		}
		if($operation == 2 && ($balance0 - $delta > 0 || $balance0 - $delta == 0)){
			var $balance_new = $balance0 - $delta;
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance_new);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "none");
		}
		if($operation == 2 && $balance0 - $delta < 0){
			$("#balance1").prop("enabled", true);      /* Разблокировка инпута */
			$("#balance1").val($balance0);
			$("#balance1").prop("disabled", true);     /* Блокировка инпута */
			$("#balance_neg").css("display", "inline-block");
		}else{
			$("#balance_neg").css("display", "none");
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
		$('#sum').forceNumbericOnly();
		
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
	
	
</script>

@endpush