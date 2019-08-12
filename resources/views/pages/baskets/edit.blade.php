@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li class="active">Корзина</li>
				</ol>
			</div>
			
			<div class="heading">
				<div class="col-sm-12">
	                <p>&nbsp; </p>
					<!--  -->
					@if(isset($basket_create) && $basket_create == 1)
							<div class="table-responsive cart_info">
								<table class="table table-condensed">
									<thead>
										<tr class="cart_menu">
											<td class="image"></td>
											<td ></td>
											<td class="price">Цена</td>
											<td class="quantity">Количество</td>
											<td >@lang('layouts.bidding_types')</td>
											<td class="total">Стоимость</td>
											<td>Удалить</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td >
												<a href="{{ route('service.show', $service->id) }}"><img src="{{$service->getImage()}}" alt="" style="width: 150px"></a>
											</td>
											<td >
												<h4><a href="{{ route('service.show', $service->id) }}">{{$service->title}}</a></h4>
												<p style="display: inline;">@lang('pages.service_code'): &nbsp;  <div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;">{{substr($service->product_code_id, 0, 6) . '-' . substr($service->product_code_id, 6, 4)}}</div></p>
											</td>
											<td class="cart_price">
												<p>{{ $basket->price_fin }} грн</p>
												<input type="hidden" name="price_fin_h" id="price_fin_h" value="{{ $basket->price_fin }}" />
											</td>
											
											
											@if($service->bidding_type == 2 || $service->bidding_type == 6)
												@if($service->number_total > 1)
													<td class="cart_quantity">
														<div class="cart_quantity_button">
															<input class="cart_quantity_input" type="number" min="1" max="{{$service->number_total}}" name="number_unit" id="number_unit1" value="{{ $basket->number_unit }}" autocomplete="off" size="2" style="width: 70px" />
														</div>
													</td>
												@else
													<td class="cart_quantity">
														<div class="cart_quantity_button">
															<input class="cart_quantity_input" type="text" name="number_unit" id="number_unit2" value="{{ $basket->number_unit }}" autocomplete="off" size="2" disabled/>
														</div>
													</td>
												@endif
									        	<td >
													<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													@lang('pages.buy_now')
												</td>
											@endif
											
											@if($service->bidding_type == 3 || $service->bidding_type == 7)
												@if($service->number_total > 1)
													<td class="cart_quantity">
														<div class="cart_quantity_button">
															<input class="cart_quantity_input" type="number" min="1" max="{{$service->number_total}}" name="number_unit" id="number_unit3" value="{{ $basket->number_unit }}" autocomplete="off" size="2" style="width: 70px" />
														</div>
													</td>
												@else
													<td class="cart_quantity">
														<div class="cart_quantity_button">
															<input class="cart_quantity_input" type="text" name="number_unit" id="number_unit4" value="{{ $basket->number_unit }}" autocomplete="off" size="2" disabled/>
														</div>
													</td>
												@endif
									        	<td >
													<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
													@lang('pages.sell_now')
												</td>
											@endif

											<td class="cart_total">
												<p class="cart_total_price">
													<input type="text" name="total_cost_v" id="total_cost_v" style="width: 80px; height: 30px; font-size: 12pt;" disabled />
													грн
												</p>
											</td>
											<td class="cart_delete" style="padding-top: 40px;">
												<form method="POST" action="{{ route('baskets.destroy', $basket->id) }}">
									  				@csrf
									  				<input type="hidden" name="_method" value="DELETE">
								                  
									                  <button onclick="return confirm('Are you sure?')" type="submit" class="cart_quantity_delete">
									                   <i class="fa fa-times"></i>
									                  </button>

								                </form>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div style="text-align: right">
								<form method="POST" action="{{ route('deals.store') }}">
									@csrf
									<input type="hidden" name="number_unit" id="number_unit5" />
									<input type="hidden" name="basket_id" value="{{ $basket->id }}" />
									<input type="hidden" name="service_id" value="{{ $service->id }}" />
									<input type="hidden" name="price_fin" value="{{ $basket->price_fin }}" />
									<input type="hidden" name="user_seller_id" value="{{ $basket->user_seller_id }}" />
									<input type="hidden" name="user_buyer_id" value="{{ $basket->user_buyer_id }}" />
									<input type="hidden" name="bidding_type" value="{{ $basket->bidding_type }}" />
									
									<button class="btn btn-fefault cart" >Оформление сделки</button>
								</form>
							</div>
			
		            @elseif(isset($basket_create) && $basket_create == 2)
		            	Перед использованием сервиса необходимо 
		            	<a class="nav-link" href="/login">войти</a>
		            	 или 
		            	 <a class="nav-link" href="/register">зарегистрироваться</a>
		            @elseif(isset($basket_create) && $basket_create == 3)
		            	Превышено доступное количество единиц услуги.
		            	Попробуйте выбрать меньшее <a href="/service/<?php isset($service_id) ? $service_id : '' ?>#window1">число</a> единиц услуги
		            @elseif(isset($basket_create) && $basket_create == 4)
		            	У Вас есть незавершенная операция по оформлению заказа в Корзине. До ее завершения Вы не можете назначать новые сделки
		            @else
		            	Ваша Корзина пуста
		            @endif
	                <p>&nbsp; </p>
	                <p>&nbsp; </p>
				</div>
			</div>
		</div>
	</section>

@endsection


@push('scripts')

<!-- Расчет суммарной стоимости -->
<script type="text/javascript">
	$('#number_unit1').change(function(){
        var number_unit = $(this).val();
        var price = $('#price_fin_h').val();
        var total_cost = number_unit * price;
        if(number_unit){
         	$("#total_cost_v").prop("enabled", true);   // Разблокировка инпута
            $("#total_cost_v").empty();	// Очистка инпута
            $("#total_cost_v").val(total_cost);
            $("#number_unit5").val(number_unit);
            $("#total_cost_v").prop("disabled", true);  // Блокировка инпута
        }
    });
    $('#number_unit2').change(function(){
        var number_unit = $(this).val();
        var price = $('#price_fin_h').val();
        var total_cost = number_unit * price;
        if(number_unit){
         	$("#total_cost_v").prop("enabled", true);   // Разблокировка инпута
            $("#total_cost_v").empty();	// Очистка инпута
            $("#total_cost_v").val(total_cost);
            $("#number_unit5").val(number_unit);
            $("#total_cost_v").prop("disabled", true);  // Блокировка инпута
        }
    });
    $('#number_unit3').change(function(){
        var number_unit = $(this).val();
        var price = $('#price_fin_h').val();
        var total_cost = number_unit * price;
        if(number_unit){
         	$("#total_cost_v").prop("enabled", true);   // Разблокировка инпута
            $("#total_cost_v").empty();	// Очистка инпута
            $("#total_cost_v").val(total_cost);
            $("#number_unit5").val(number_unit);
            $("#total_cost_v").prop("disabled", true);  // Блокировка инпута
        }
    });
    $('#number_unit4').change(function(){
        var number_unit = $(this).val();
        var price = $('#price_fin_h').val();
        var total_cost = number_unit * price;
        if(number_unit){
         	$("#total_cost_v").prop("enabled", true);   // Разблокировка инпута
            $("#total_cost_v").empty();	// Очистка инпута
            $("#total_cost_v").val(total_cost);
            $("#number_unit5").val(number_unit);
            $("#total_cost_v").prop("disabled", true);  // Блокировка инпута
        }
    });
    
    
    jQuery(document).ready(function($){
 		var number_unit1 = $('#number_unit1').val();
 		var number_unit2 = $('#number_unit2').val();
 		var number_unit3 = $('#number_unit3').val();
 		var number_unit4 = $('#number_unit4').val();
 		if(number_unit1 && number_unit1 > 0){
			number_unit = number_unit1;
		}else{
			if(number_unit2 && number_unit2 > 0){
				number_unit = number_unit2;
			}else{
				if(number_unit3 && number_unit3 > 0){
					number_unit = number_unit3;
				}else{number_unit = number_unit4;}
			}
		}
			
		var price = $('#price_fin_h').val();
		var total_cost = number_unit * price;
		
		$("#total_cost_v").prop("enabled", true);   // Разблокировка инпута
        $("#total_cost_v").empty();	// Очистка инпута
        $("#total_cost_v").val(total_cost);
        $("#number_unit5").val(number_unit);
        $("#total_cost_v").prop("disabled", true);  // Блокировка инпута
	});
</script>

@endpush