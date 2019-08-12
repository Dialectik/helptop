@push('styles')
<!--	<style>
      	<link href="/css/pages/circle.css" rel="stylesheet">
	</style>-->


	
@endpush


@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li><a href="{{ route('deals.index') }}">Сделки</a></li>
				  <li class="active"> Сделка №{{ isset($deal_code) ? $deal_code : '' }}</li>
				</ol>
			</div>
					@if((isset($deal_create) && $deal_create == 1) || isset($deal) && ($deal->status_deal > 0 ) && ($deal->status_deal < 6 ))
			<!-- Основная информация по сделке -->
			<div class="heading">
				<div class="col-sm-12">
					<a href="{{ route('service.show', $deal->service_id) }}" >
					<img src="{{ $deal->getImage() }}" alt="" style="max-width: 200px; max-height: 200px; display: inline;"  />
					</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<p style="font-size: 300%; display: inline;">

									Сделка №: {{ isset($deal_code) ? $deal_code : '' }}&nbsp;&nbsp;
									<div style="border: 2px solid #dbc524; padding: 1px 3px 1px 3px; display: inline; font-size: 200%;">
										<?php
					              			switch ($deal->status_deal) {
											  case '1':
											    echo 'В процессе';
											    break;
											  case '2':
											    echo 'Успешно завершена';
											    break;
											  case '3':
											    echo 'Заверена продавцом';
											    break;
											  case '4':
											    echo 'Заверена покупателем';
											    break;
											  case '5':
											    echo 'Аннулирована';
											    break;
											  default:
											    break;
											}
					              		?>
					              	</div>								

					</p>
				<div class="col-sm-12">
					<div class="product-details"><!--product-details-->
							<div class="product-information"><!--/product-information-->
								
								
								<h2><span style="font-weight: normal">По услуге:</span> &nbsp;&nbsp;
								<a href="{{ route('service.show', $deal->service_id) }}" >
									{{ $deal->service->title }}</a></h2>
								
								
								
								
								<p style="display: inline;">@lang('pages.service_code'): &nbsp;  <div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;">{{ isset($deal->service->product_code_id) ? (substr($deal->service->product_code_id, 0, 6) . '-' . substr($deal->service->product_code_id, 6, 4)) : '' }}</div></p>
								<p>Заказано услуг: &nbsp;<b><?php echo $deal->number_unit ?></b></p>
								<p>Общей стоимостью: &nbsp;<b><?php echo $deal->total_cost ?> грн</b></p>
								<p>
									Тип торгов: &nbsp;
									<b>
									<?php
				              			switch ($deal->bidding_type) {
										  case '2':
										    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
										    break;
										  case '3':
										    echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
										    break;
										  case '4':
										    echo '<i class="fa fa-gavel" aria-hidden="true"></i>';
										    break;
										  case '5':
										    echo '<i class="fa fa-bar-chart-o" aria-hidden="true"></i>';
										    break;
										  case '6':
										    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i> <i class="fa fa-gavel" aria-hidden="true"></i>';
										    break;
										  case '7':
										    echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <i class="fa fa-bar-chart-o" aria-hidden="true"></i>';
										    break;
										  default:
										    break;
										}
				              		?>
				              		{{ $deal->biddingTypeTitle() }}
				              		</b>
								</p>
								
								
								<!-- Краткое описание -->
								<p>@lang('pages.description'): &nbsp;<b><?php echo $deal->getDescription() ?></b></p>
								<p><a href="" >
									<i class="fa fa-clock-o"></i>
									Услуга должна быть
									@if(Auth::user()->id == $deal->user_seller_id)
										ПРЕДОСТАВЛЕНА
									@else
										ПОЛУЧЕНА
									@endif
									в период:
									&nbsp; с
										
										<b>{{$deal->getDateWH($date_initial, $date_offset)}}</b>
										по
										<b>{{$deal->getDateWH($date_deadline, $date_offset)}}</b>
								</a></p>
								
								<p>
									Автор услуги:
									@if(Auth::user()->id == $deal->author)
										<b>Вы</b>
										@if(Auth::user()->id == $deal->user_seller_id)
											(Продавец)
										@else
											(Покупатель)
										@endif
									@else	
										<a href="" title="{{ isset($deal->authorUser->firm) ? $deal->authorUser->firm : '' }}">
											<b>{{ $deal->authorUser->name }}</b>
										</a>
										@if($deal->author == $deal->user_seller_id)
											(Продавец)
										@else
											(Покупатель)
										@endif
									@endif
									
									
								</p>
								<p>
									Инициатор услуги:
										@if(Auth::user()->id == $deal->initiator)
										<b>Вы</b>
										@if(Auth::user()->id == $deal->user_seller_id)
											(Продавец)
										@else
											(Покупатель)
										@endif
									@else	
										<a href="" title="{{ isset($deal->initiatorUser->firm) ? $deal->initiatorUser->firm : '' }}">
											<b>{{ $deal->initiatorUser->name }}</b>
										</a>
										@if($deal->initiator == $deal->user_seller_id)
											(Продавец)
										@else
											(Покупатель)
										@endif
									@endif
									
									
								</p>

								<p>
									@if($deal->service->getScalable())
										<b ><i class="fa fa-external-link " title="@lang('pages.scalable_service_title')"></i>
										@lang('pages.scalable_service')</b>
									@endif
									
									&nbsp; &nbsp; &nbsp; &nbsp;
									@if($deal->service->getExpandable())
										<b ><i class="fa fa-plus-square " title="@lang('pages.expandable_service_title')"></i>
										@lang('pages.expandable_service')</b>
									@endif
								</p>
								
								<p><a href="" title="@lang('pages.terms_payment_title')">
									
										<i class="fa fa-money "></i> 
										Оплата услуги:&nbsp;
										<b >
				              			@if($deal->getTermsPayment())
					              			@if($deal->getTermsPayment() == 1)
											    @lang('pages.prepayment')
											@endif
											@if($deal->getTermsPayment() == 2)
											    @lang('pages.payment_after')
											@endif
											@if($deal->getTermsPayment() == 3)
											    @lang('pages.prepaid_expense')
											@endif
											@if($deal->getTermsPayment() == 4)
											    @lang('pages.phased_payment')
											@endif
											@if($deal->getTermsPayment() == 5)
											    @lang('pages.any_payment_method')
											@endif
										@endif
										</b>
									<p>Услуга должна быть ОПЛАЧЕНА в период:
										@if($deal->getTermsPayment())
					              			@if($deal->getTermsPayment() == 1)
											    с
											    <b><?php echo $deal->getDateWH($date_initial, $date_offset) ?></b>
											    по
											    <b><?php echo $deal->getDateWH($deal->getDateMiddle($date_initial, $date_deadline), $date_offset) ?></b>
											@endif
											@if($deal->getTermsPayment() == 2 || $deal->getTermsPayment() == 5)
											    с
											    <b><?php echo $deal->getDateWH($date_initial, $date_offset) ?></b>
											    по
											    <b><?php echo $deal->getDateWH($date_deadline, $date_offset) ?></b>
											@endif
											@if($deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4)
											    <p>&nbsp;&nbsp;&nbsp;&nbsp;ПРЕДОПЛАТА: с
												    <b><?php echo $deal->getDateWH($date_initial, $date_offset) ?></b>
												    по
												    <b><?php echo $deal->getDateWH($deal->getDateMiddle($date_initial, $date_deadline), $date_offset) ?></b>
											    </p>
											    <p>&nbsp;&nbsp;&nbsp;&nbsp;ОПЛАТА ОСТАТКА: с
											    	<b><?php echo $deal->getDateWH($deal->getDateMiddle($date_initial, $date_deadline), $date_offset) ?></b>
											    	по
											    	<b><?php echo $deal->getDateWH($date_deadline, $date_offset) ?></b>
											    </p>
											@endif
										@endif
									</p>
									
								</a></p>
								
								
								
							</div><!--/product-information-->
						
					</div><!--/product-details-->
				</div>
					
				</div>
			</div>  <!-- /Основная информация по сделке -->
			

			
			
			
		            @elseif(isset($deal_create) && $deal_create == 2)
		            	Перед использованием сервиса необходимо 
		            	<a class="nav-link" href="/login">войти</a>
		            	 или 
		            	 <a class="nav-link" href="/register">зарегистрироваться</a>
		            @endif
			
		</div>  <!-- /"container" -->
	</section>

@endsection


@push('scripts')

<!-- ***** ИЗМЕНИТЬ   Расчет суммарной стоимости -->
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