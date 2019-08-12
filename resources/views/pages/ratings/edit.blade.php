@push('styles')
	<style>
      	.rating_block {
		  width: 125px;
		  height: 25px;
		}
		.rating_block input[type="radio"] {
		  display: none;
		}
		.label_rating {
		  float: right;
		  display: block;
		  width: 25px;
		  height: 25px;
		  background: url(rating.png) no-repeat 50% 0;
		  cursor: pointer;
		}
		/*Пишем правила смены положения background-а*/
		.rating_block .label_rating:hover, /*Правило для ховера на текущий лейбл*/
		.rating_block .label_rating:hover ~ .label_rating, /*Правило для всех следующих лейблов по DOM дереву*/
		.rating_block input[type="radio"]:checked ~ .label_rating /*Правило для всех следующих лейблов после выбранного инпута, чтобы звездочки как бы зафиксировались*/
		{
		  background-position: 50% -25px;
		}
	</style>


	
@endpush


@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li><a href="{{ route('ratings.index') }}">Рейтинги</a></li>
				  <li class="active"> Оценка Сделки №{{ isset($deal_code) ? $deal_code : '' }}</li>
				</ol>
			</div>
					@if((null != $rating_create && $rating_create == 1) || isset($rating) )
			<!-- Основная информация по рейтингу -->
			<div class="heading">
				<div class="col-sm-12">
					<form id="myForm" method="post" action="{{ route('ratings.store') }}" >
	                	{{csrf_field()}}
					<div class="product-details"><!--product-details-->
						<div class="product-information"><!--product-information-->
							@if(null != $rating_create && $rating_create == 1)
								
								<h2>Оцените пожалуйста сделку №{{ null != $deal_code ? $deal_code : '' }} 
								<span style="font-weight: normal"> по услуге:</span> &nbsp;&nbsp;
								<a href="{{ route('service.show', $deal->service_id) }}" >
									{{ null != $deal ? $deal->service->title : '' }}</a></h2>
								<h2><span style="font-weight: normal">Ваш контрагент: </span> 
									<?php 
										if($deal->author == Auth::user()->id){
											echo $deal->initiatorUser->name;
										}else{
											echo $deal->authorUser->name;
										} 
									?>
								</h2>
								<div class="col-sm-12">
									<div class="col-sm-8">
										<p>Актуальность цены</p>
										<div class="col-sm-6">
											Цена услуги была указана правильно?
										</div>
										<div class="col-sm-2">
											<input name="local_price" type="radio" value="1"
												<?php 
													if($rating->local_price == 1) echo "checked disabled";
													if($rating->local_price == 2) echo "disabled";
													if($rating->local_price == 3) echo "disabled";
												?>
											>
											Нет
										</div>
										<div class="col-sm-2">
											<input name="local_price" type="radio" value="2"
												<?php 
													if($rating->local_price == 2) echo "checked disabled";
													if($rating->local_price == 1) echo "disabled";
													if($rating->local_price == 3) echo "disabled";
												?>
											>
											Не помню
										</div>
										<div class="col-sm-2">
											<input name="local_price" type="radio" value="3"
												<?php 
													if($rating->local_price == 3) echo "checked disabled";
													if($rating->local_price == 2) echo "disabled";
													if($rating->local_price == 1) echo "disabled";
													if($rating->local_price == 0) echo "checked";
												?>
											>
											Да
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<p>Актуальность наличия</p>
										<div class="col-sm-6">
											Наличие услуги было указано правильно?
										</div>
										<div class="col-sm-2">
											<input name="local_availab" type="radio" value="1"
												<?php 
													if($rating->local_availab == 1) echo "checked disabled";
													if($rating->local_availab == 2) echo "disabled";
													if($rating->local_availab == 3) echo "disabled";
												?>
											>
											Нет
										</div>
										<div class="col-sm-2">
											<input name="local_availab" type="radio" value="2"
												<?php 
													if($rating->local_availab == 2) echo "checked disabled";
													if($rating->local_availab == 1) echo "disabled";
													if($rating->local_availab == 3) echo "disabled";
												?>
											>
											Не помню
										</div>
										<div class="col-sm-2">
											<input name="local_availab" type="radio" value="3"
												<?php 
													if($rating->local_availab == 3) echo "checked disabled";
													if($rating->local_availab == 1) echo "disabled";
													if($rating->local_availab == 2) echo "disabled";
													if($rating->local_availab == 0) echo "checked";
												?>
											>
											Да
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<p>Актуальность описания</p>
										<div class="col-sm-6">
											Описание услуги было актуальным?
										</div>
										<div class="col-sm-2">
											<input name="local_descr" type="radio" value="1"
												<?php 
													if($rating->local_descr == 1) echo "checked disabled";
													if($rating->local_descr == 2) echo "disabled";
													if($rating->local_descr == 3) echo "disabled";
												?>
											>
											Нет
										</div>
										<div class="col-sm-2">
											<input name="local_descr" type="radio" value="2"
												<?php 
													if($rating->local_descr == 2) echo "checked disabled";
													if($rating->local_descr == 1) echo "disabled";
													if($rating->local_descr == 3) echo "disabled";
												?>
											>
											Не помню
										</div>
										<div class="col-sm-2">
											<input name="local_descr" type="radio" value="3"
												<?php 
													if($rating->local_descr == 3) echo "checked disabled";
													if($rating->local_descr == 2) echo "disabled";
													if($rating->local_descr == 3) echo "disabled";
													if($rating->local_descr == 0) echo "checked";
												?>
											>
											Да
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<p>Выполнение заказа в срок</p>
										<div class="col-sm-6">
											Заказ был выполнен в оговоренные сроки?
										</div>
										<div class="col-sm-2">
											<input name="local_term" type="radio" value="1" 
												<?php 
													if($rating->local_term == 1) echo "checked disabled";
													if($rating->local_term == 2) echo "disabled";
													if($rating->local_term == 3) echo "disabled";
												?>
											>
											Нет
										</div>
										<div class="col-sm-2">
											<input name="local_term" type="radio" value="2" 
												<?php 
													if($rating->local_term == 2) echo "checked disabled";
													if($rating->local_term == 1) echo "disabled";
													if($rating->local_term == 3) echo "disabled";
												?>
											>
											Не помню
										</div>
										<div class="col-sm-2">
											<input name="local_term" type="radio" value="3" 
												<?php 
													if($rating->local_term == 3) echo "checked disabled";
													if($rating->local_term == 1) echo "disabled";
													if($rating->local_term == 2) echo "disabled";
													if($rating->local_term == 0) echo "checked";
												?>
											>
											Да
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<p>Доступность комуникации</p>
										<div class="col-sm-6">
											Заказ был выполнен в оговоренные сроки?
										</div>
										<div class="col-sm-5">
											<select class="form-control select2" name="local_contact" style="width: 100%;" >
								              	@if($rating->local_contact > 0)
								              		<option style="width: 100%" value="{{$rating->local_contact}}" checked disabled ><?php
									              			switch ($rating->local_contact) {
															  case '5':
															    echo 'В течение 30 минут';
															    break;
															  case '4':
															    echo 'В течение нескольких часов';
															    break;
															  case '3':
															    echo 'На следующий день';
															    break;
															  case '2':
															    echo 'Спустя несколько дней';
															    break;
															  case '1':
															    echo 'Не связались';
															    break;
															  default:
															    break;
															}
									              		?></option>
								              	@else
									              	<option style="width: 100%" value="5" checked>В течение 30 минут</option>
									              	<option style="width: 100%" value="4">В течение нескольких часов</option>
									              	<option style="width: 100%" value="3">На следующий день</option>
									              	<option style="width: 100%" value="2">Спустя несколько дней</option>
									              	<option style="width: 100%" value="1">Не связались</option>
									            @endif
							              </select>
										</div>
									</div>  <!--/ "col-sm-8" -->
								
								</div>  <!--/ "col-sm-12" -->
								
								<div class="col-sm-8">
									<hr/>
								</div>
								
								<div class="col-sm-12">
									<div class="col-sm-8">
										<p>Общее впечатление</p>
										<div class="col-sm-6">
											Вы бы порекомендовали контрагента к сотрудничеству?
										</div>
										<div class="col-sm-2">
											<input name="local_recom" type="radio" value="1" 
												<?php 
													if($rating->local_recom == 1) echo "checked disabled";
													if($rating->local_recom == 2) echo "disabled";
													if($rating->local_recom == 3) echo "disabled";
												?>
											>
											Нет
										</div>
										<div class="col-sm-2">
											<input name="local_recom" type="radio" value="2" 
												<?php 
													if($rating->local_recom == 2) echo "checked disabled";
													if($rating->local_recom == 1) echo "disabled";
													if($rating->local_recom == 3) echo "disabled";
												?>
											>
											Не уверен
										</div>
										<div class="col-sm-2">
											<input name="local_recom" type="radio" value="3" 
												<?php 
													if($rating->local_recom == 3) echo "checked disabled";
													if($rating->local_recom == 1) echo "disabled";
													if($rating->local_recom == 2) echo "disabled";
													if($rating->local_recom == 0) echo "checked";
												?>
											>
											Да
										</div>
									</div>
									
									<div class="col-sm-8">
										<hr/>
									</div>
									
									<div class="col-sm-8">
										<p>Общая оценка контрагента</p>
										@if($rating->local_star == 0)
											<div class="col-sm-7">
												<input type="text" id="esteem">
											</div>
											<div class="col-sm-5">
												<div class="rating_block">
												  <input name="local_star" value="5" id="rating_5" type="radio" checked />
												  <label for="rating_5" class="label_rating"></label>
												 
												  <input name="local_star" value="4" id="rating_4" type="radio" />
												  <label for="rating_4" class="label_rating"></label>
												 
												  <input name="local_star" value="3" id="rating_3" type="radio" />
												  <label for="rating_3" class="label_rating"></label>
												 
												  <input name="local_star" value="2" id="rating_2" type="radio" />
												  <label for="rating_2" class="label_rating"></label>
												 
												  <input name="local_star" value="1" id="rating_1" type="radio" />
												  <label for="rating_1" class="label_rating"></label>
												</div>
											</div>
										@else
											<div class="col-sm-7">
												<input type="text" value="<?php
								              			switch ($rating->local_star) {
														  case '5':
														    echo 'Отлично';
														    $ra5 = 'checked';
														    break;
														  case '4':
														    echo 'Хорошо';
														    $ra4 = 'checked';
														    break;
														  case '3':
														    echo 'Удовлетворительно';
														    $ra3 = 'checked';
														    break;
														  case '2':
														    echo 'Плохо';
														    $ra2 = 'checked';
														    break;
														  case '1':
														    echo 'Ужасно';
														    $ra1 = 'checked';
														    break;
														  default:
														    break;
														}
								              		?>" disabled >
											</div>
											<div class="col-sm-5">
												<div class="rating_block">
												  <input name="local_star" value="5" id="rating_5" type="radio" <?php if(isset($ra5)){echo $ra5;} ?> />
												  <label for="rating_5" class="label_rating"></label>
												 
												  <input name="local_star" value="4" id="rating_4" type="radio" <?php if(isset($ra4)){echo $ra4;} ?> />
												  <label for="rating_4" class="label_rating"></label>
												 
												  <input name="local_star" value="3" id="rating_3" type="radio" <?php if(isset($ra3)){echo $ra3;} ?> />
												  <label for="rating_3" class="label_rating"></label>
												 
												  <input name="local_star" value="2" id="rating_2" type="radio" <?php if(isset($ra2)){echo $ra2;} ?> />
												  <label for="rating_2" class="label_rating"></label>
												 
												  <input name="local_star" value="1" id="rating_1" type="radio" <?php if(isset($ra1)){echo $ra1;} ?> />
												  <label for="rating_1" class="label_rating"></label>
												</div>
											</div>
										@endif
										
									</div>  <!--/ "col-sm-8" -->

									<div class="col-sm-8">
										
									</div>  <!--/ "col-sm-8" -->

								</div>  <!--/ "col-sm-12" -->
							

								
							@endif
						</div><!--/product-information-->
					</div><!--/product-details-->
					
					<!-- Отзывы -->
					<div class="product-details"><!--product-details-->
						<div class="product-information"><!--/product-information-->
						Отзыв
						@if(isset($rating->review) || isset($rating->message))
							<div class="col-sm-9" >
								@if(isset($rating->review))
									<div class="form-group alert alert-success col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px;">
										<a href="" style="">{{ Auth::user()->name }}</a> (Вы) &nbsp;&nbsp; {{ $rating->getDateAttribute($rating->created_at, $date_offset) }}
										<p><?php echo $rating->review ?></p>
									</div>
								@endif
								@if(isset($rating->message))	
									<div class="form-group alert alert-info col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 100px; margin-right: 10px; align-self: right">
										<a href="" style="">{{ Auth::user()->id == $deal->author ? $deal->initiatorUser->name : $deal->authorUser->name }}</a> (контрагент) &nbsp;&nbsp; {{ $rating->getDateAttribute($rating->date_rating, $date_offset) }}
										<p><?php echo $rating->message ?></p>
									</div>
								@endif

								<p>&nbsp; </p>
								<p>&nbsp; </p>
							</div>
						@endif
						
						<div class="col-sm-9" >
		                	<p>&nbsp; </p>
		                	<p>&nbsp; </p>
		                	
			                @if(null == $rating->review)	
			                	<textarea name="review" cols="20" rows="5" maxlength="250" placeholder="Напишите подробный отзыв о сделке и контрагенте" style="padding: 10px; font-size: 120%"></textarea>
			                	<p>&nbsp; </p>
							@endif
							
							@if(null == $rating->review || $rating->local_star == 0 || $rating->local_price == 0 || $rating->local_availab == 0 || $rating->local_descr == 0 || $rating->local_term == 0 || $rating->local_contact == 0 || $rating->local_recom == 0)
								<input type="hidden" name="_method" id="_method" value="POST">
								<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
								<input type="hidden" name="deal_id" value="{{ $deal->id }}">
								<button class="btn btn-fefault cart" >Сохранить отзыв</button>
							@endif
							
							<p>&nbsp; </p>
	                	</div>
	                	
					
						
						</div><!--/product-information-->
					</div><!--/product-details-->
					</form>
				</div>
			</div>  <!-- /"heading" /Основная информация по рейтингу -->
			

			
			
			
		            @elseif(null != $rating_create && $rating_create == 2)
		            	Перед использованием сервиса необходимо 
		            	<a class="nav-link" href="/login">войти</a>
		            	 или 
		            	 <a class="nav-link" href="/register">зарегистрироваться</a>
		            @elseif(null != $rating_create && $rating_create == 4)
		            	По данной сделке Вы уже оставляли отзыв
		            @else
		            	Вы не можете оставить отзыв
		            @endif
			<p>&nbsp; </p>
			<p>&nbsp; </p>
		</div>  <!-- /"container" -->
	</section>

@endsection


@push('scripts')

<!-- Отображение оценки в зависимости от количества звезд -->
<script type="text/javascript">
	$('#rating_5').change(function(){
 	var rating = $(this).val();
 	if(rating == 5){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Отлично');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
    });
    $('#rating_4').change(function(){
 	var rating = $(this).val();
 	if(rating == 4){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Хорошо');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
    });
    $('#rating_3').change(function(){
 	var rating = $(this).val();
 	if(rating == 3){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Удовлетворительно');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
    });
    $('#rating_2').change(function(){
 	var rating = $(this).val();
 	if(rating == 2){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Плохо');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
    });
    $('#rating_1').change(function(){
 	var rating = $(this).val();
 	if(rating == 1){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Ужасно');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
    });
</script>    
    
<script>    
    jQuery(document).ready(function($){
 	if($('#rating_5').val() == 5){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Отлично');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
 	if($('#rating_4').val() == 4){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Хорошо');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
	if($('#rating_3').val() == 3){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Удовлетворительно');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
	if($('#rating_2').val() == 2){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Плохо');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
	if($('#rating_1').val() == 1){
	  	$("#esteem").prop("enabled", true);   // Разблокировка инпута
	    $("#esteem").empty();	// Очистка инпута
	    $('#esteem').val('Ужасно');
	    $("#esteem").prop("disabled", true);  // Блокировка инпута
	}
</script>





@endpush