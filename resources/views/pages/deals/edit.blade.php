@push('styles')
<!--	<style>
      	<link href="/css/pages/circle.css" rel="stylesheet">
	</style>-->



<!--https://edi.vchasno.com.ua/	   Кружочки с линией.   Элементы ::after, ::before сильно искажают страницу-->
	<style>
	.t565__circle {
	    width: 46px;
	    height: 46px;
	    position: absolute;
	    right: 0;
	    left: 0;
	    top: 5px;
	    margin: 0 auto;
	        margin-top: 0px;
	        margin-right: auto;
	        margin-bottom: 0px;
	        margin-left: auto;
	    background-color: #FE980F;
	    border-radius: 100%;
	        border-top-left-radius: 100%;
	        border-top-right-radius: 100%;
	        border-bottom-right-radius: 100%;
	        border-bottom-left-radius: 100%;
	    border: 2px solid #fff;
	        border-top-color: rgb(255, 255, 255);
	        border-top-style: solid;
	        border-top-width: 2px;
	        border-right-color: rgb(255, 255, 255);
	        border-right-style: solid;
	        border-right-width: 2px;
	        border-bottom-color: rgb(255, 255, 255);
	        border-bottom-style: solid;
	        border-bottom-width: 2px;
	        border-left-color: rgb(255, 255, 255);
	        border-left-style: solid;
	        border-left-width: 2px;
	        border-image-outset: 0;
	        border-image-repeat: stretch;
	        border-image-slice: 100%;
	        border-image-source: none;
	        border-image-width: 1;
	}
	.t565__number {
	    position: absolute;
	    top: 50%;
	    left: 0;
	    right: 0;
	    text-align: center;
	    -moz-transform: translateY(-50%);
	        transform: translateY(-50%);
	    -ms-transform: translateY(-50%);
	    -webkit-transform: translateY(-50%);
	        transform: translateY(-50%);
	    -o-transform: translateY(-50%);
	    transform: translateY(-50%);
	    color: #fff;
	}
	.t-name_md {
	    font-size: 20px;
	    line-height: 1.35;
	}
	.t-name {
	    font-family: 'Roboto',Arial,sans-serif;
	    font-weight: 600;
	    color: #000;
	}
	.t565__title {
	    margin-bottom: 6px;
	    margin-top: 10px;
	}
	.t-name_lg {
	    font-size: 22px;
	    line-height: 1.35;
	}
	.t565__descr {
	    margin-top: 10px;
	    margin-bottom: 5px;
	}
	.t-text_xs {
	    font-size: 15px;
	    line-height: 1.55;
	}
	.t-text {
	    font-family: 'Roboto',Arial,sans-serif;
	    font-weight: 300;
	    color: #000;
	}
	.t-container {
	    max-width: 1200px;
	}
	.t-container {
	    margin-left: auto;
	    margin-right: auto;
	    padding: 0;
	        padding-top: 0px;
	        padding-right: 0px;
	        padding-bottom: 0px;
	        padding-left: 0px;
	    width: 100%;
	}
	div{
	    margin: 0;
	    	margin-top: 0px;
	        margin-bottom: 0px;
	    padding: 0;
		    padding-top: 0px;
		    padding-right: 0px;
		    padding-bottom: 0px;
		    padding-left: 0px;
		border: 0;
	        border-top-color: currentcolor;
	        border-top-style: none;
	        border-top-width: 0px;
	        border-right-color: currentcolor;
	        border-right-style: none;
	        border-right-width: 0px;
	        border-bottom-color: currentcolor;
	        border-bottom-style: none;
	        border-bottom-width: 0px;
	        border-left-color: currentcolor;
	        border-left-style: none;
	        border-left-width: 0px;
	        border-image-outset: 0;
	        border-image-repeat: stretch;
	        border-image-slice: 100%;
	        border-image-source: none;
	        border-image-width: 1;
	}
	.t565__item {
	    position: relative;
	    padding-bottom: 30px;
	}
	.t565__mainblock {
	    margin: 0 auto;
	    	margin-top: 0px;
			margin-right: auto;
			margin-bottom: 0px;
			margin-left: auto;
	}
	.t-width_8 {
	    max-width: 760px;
	}
	.t-width {
	    width: 100%;
	}

	*, ::after, ::before {
	    -webkit-box-sizing: content-box;
	    	box-sizing: content-box;
	    -moz-box-sizing: content-box;
	    	box-sizing: content-box;
	    box-sizing: content-box;
	}
	.t565__col {
	    width: 50%;
	    text-align: right;
	}
	.t565__item:first-child .t565__line {
	    top: 10px;
	}
	.t565__line {
	    position: absolute;
	    width: 2px;
	    top: 0;
	    background: #222;
	        background-color: rgb(34, 34, 34);
	        background-position-x: 0%;
	        background-position-y: 0%;
	        background-repeat: repeat;
	        background-attachment: scroll;
	        background-image: none;
	        background-size: auto;
	        background-origin: padding-box;
	        background-clip: border-box;
	    bottom: 0;
	    left: 0;
	    right: 0;
	    margin: 0 auto;
	        margin-top: 0px;
	        margin-right: auto;
	        margin-bottom: 0px;
	        margin-left: auto;
	}
	.t565__block {
	    padding-right: 56px;
	    padding-left: 0 !important;
	}
	.t565__flipped {
	    float: right !important;
	    text-align: left;
	}
	.t565__block-flipped {
	    padding-right: 0 !important;
	    padding-left: 56px;
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
				  <li><a href="{{ route('deals.index') }}">Сделки</a></li>
				  <li class="active"> Сделка №{{ isset($deal_code) ? $deal_code : '' }}</li>
				</ol>
			</div>
					@if((isset($deal_create) && $deal_create == 1) || isset($deal) && ($deal->status_deal > 0 ) && ($deal->status_deal < 5 ))
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
			
			<!-- Этапы сделки -->
			<div class="heading">
				<div class="col-sm-12">
	                <p>&nbsp; </p>
					<!--  -->
					

					<?php $count = 1; ?>
					<div class="t-container t565__container"> <!-- Линия с кружечками уходящая вниз -->
						 
						 <!-- Пункт 1 -->
						 <div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 1 -->
							<div class="t-width t-width_8 t565__mainblock"> 
								<div class="t565__col"> 
									<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
										<div class="t565__line" style="width: 2px;"></div> 
										<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), Auth::user()->id == $deal->user_seller_id ? $deal->sig_approved_seller : $deal->sig_approved_buyer  ) ?>"> 
											<div class="t565__number t-name t-name_md" style="">
												{{ $count }}
											</div> 
										</div> 
									</div> 
									<div class="t565__block"> <!-- Название пункта --><!-- Описание пункта -->
										<div class="t565__title t-name t-name_lg" field="li_title__1479137044697" style="">
											Подтверждение условий сделки
										</div> 
										<div class="t565__descr t-text t-text_xs" field="li_descr__1479137044697" style="">
											@if(Auth::user()->id == $deal->user_seller_id)
											<!-- Если вошел Продавец -->
												@if($deal->sig_approved_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) ?>">
														Подтвердите, согласовали ли Вы все условия сделки с контрагентом
													</div>
													<form method="POST" action="{{ route('deals.prove') }}" > 
												  		@csrf
														<input type="hidden" name="_method" value="POST">
														<input type="hidden" name="sig" value="sig_approved_seller" />
														<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
														<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
												            Принять условия
												        </button>
											        </form>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) ?>;">
														Вы приняли условия сделки.<br/> Открыт следующий этап
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) ?>" >
													<b>Вы просрочили принятие условий сделки!<br /> Обсудите условия в сообщениях с контрагентом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@else
											<!-- Если вошел Покупатель -->
												@if($deal->sig_approved_buyer == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) ?>">
														Подтвердите, согласовали ли Вы все условия сделки с контрагентом
													</div>
													<form method="POST" action="{{ route('deals.prove') }}" > 
												  		@csrf
														<input type="hidden" name="_method" value="POST">
														<input type="hidden" name="sig" value="sig_approved_buyer" />
														<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
														<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
												            Принять условия
												        </button>
											        </form>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) ?>;">
														Вы приняли условия сделки.<br/> Открыт следующий этап
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) ?>" >
													<b>Вы просрочили принятие условий сделки!<br /> Обсудите условия в сообщениях с контрагентом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@endif
										</div> 
									</div> 
								</div> 
								
							</div> 
						</div> <!-- /Пункт 1 -->
						
						<!-- Пункт 2 -->
						<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 2 -->
							<div class="t-width t-width_8 t565__mainblock"> 
								<div class="t565__col t565__flipped"> 
									<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
										<div class="t565__line" style="width: 2px;"></div> 
										<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), Auth::user()->id != $deal->user_seller_id ? $deal->sig_approved_seller : $deal->sig_approved_buyer ) ?>;"> 
											<div class="t565__number t-name t-name_md" style="">
												{{ ++$count }}
											</div> 
										</div> 
									</div> 
									<div class="t565__block-flipped"> <!-- Название пункта --><!-- Описание пункта -->
										<div class="t565__descr t-text t-text_xs" field="li_descr__1479137356907" style="">
											@if(Auth::user()->id != $deal->user_seller_id)
											<!-- Если вошел Покупатель,а контрагент - продавец -->
												@if($deal->sig_approved_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) ?>">
														Ожидается подтверждение условий сделки контрагентом
													</div>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) ?>;">
														Контрагент принял условия сделки.<br/> Открыт следующий этап
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_seller) ?>" >
													<b>Контрагент просрочил принятие условий сделки!<br /> Обсудите условия в сообщениях с контрагентом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@else
											<!-- Если вошел Продавец, а контрагент - Покупатель -->
												@if($deal->sig_approved_buyer == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) ?>">
														Ожидается подтверждение условий сделки контрагентом
													</div>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) ?>;">
														Контрагент принял условия сделки.<br/> Открыт следующий этап
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_approved_buyer) ?>" >
													<b>Контрагент просрочил принятие условий сделки!<br /> Обсудите условия в сообщениях с контрагентом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
												
											@endif
										</div> 
									</div> 
								</div> 
							</div> 
						</div> <!-- /Пункт 2 -->
						 
						@if($deal->getTermsPayment() == 1 || $deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4)
							<!-- Пункт 3 -->
							<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 3 -->
								<div class="t-width t-width_8 t565__mainblock"> 
									<div class="t565__col "> 
										<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
											<div class="t565__line" style="width: 2px;"></div> 
											<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), Auth::user()->id == $deal->user_seller_id ? $deal->sig_pay0_seller : $deal->sig_pay0_buyer ) ?>"> 
												<div class="t565__number t-name t-name_md" style="">
													{{ ++$count }}
												</div> 
											</div> 
										</div> 
										<div class="t565__block"> <!-- Название пункта --><!-- Описание пункта -->
											<div class="t565__title t-name t-name_lg" field="li_title__1479137790652" style="">Предоплата</div> 
											<div class="t565__descr t-text t-text_xs" field="li_descr__1479137790652" style="">
											@if(Auth::user()->id == $deal->user_seller_id)
											<!-- Если вошел Продавец -->
												@if($deal->sig_pay0_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) ?>">
														Подтвердите, получена ли Вами Предоплата
													</div>
													<form method="POST" action="{{ route('deals.prove') }}" > 
												  		@csrf
														<input type="hidden" name="_method" value="POST">
														<input type="hidden" name="sig" value="sig_pay0_seller" />
														<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
														<button type="submit" class="btn1" onclick="return confirm('Are you sure?')" <?php if($deal->sig_approved_seller == 0) echo "disabled" ?> >
												            Подтвердить получение Предоплаты
												        </button>
											        </form>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) ?>;">
														Вы подтвердили получение Предоплаты
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) ?>" >
													<b>Вы просрочили подтверждение Предоплаты!<br /> Обсудите срок оплаты с Покупателем!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@else
											<!-- Если вошел Покупатель -->
												@if($deal->sig_pay0_buyer == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) ?>">
														Подтвердите, выполнили ли Вы предоплату
													</div>
													<form method="POST" action="{{ route('deals.prove') }}" > 
												  		@csrf
														<input type="hidden" name="_method" value="POST">
														<input type="hidden" name="sig" value="sig_pay0_buyer" />
														<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
														<button type="submit" class="btn1" onclick="return confirm('Are you sure?')" <?php if($deal->sig_approved_buyer == 0) echo "disabled" ?> >
												            Подтвердить выполнение Предоплаты
												        </button>
											        </form>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) ?>;">
														Вы выполнили Предоплату
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) ?>" >
													<b>Вы не выполнили срок Предоплаты!<br /> Обсудите срок Предоплаты в сообщениях с контрагентом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@endif
											</div> 
										</div> 
									</div> 
								</div> 
							</div> <!-- /Пункт 3 -->

							<!-- Пункт 4 -->
							<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 4 -->
								<div class="t-width t-width_8 t565__mainblock"> 
									<div class="t565__col t565__flipped"> 
										<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
											<div class="t565__line" style="width: 2px;"></div> 
											<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), Auth::user()->id != $deal->user_seller_id ? $deal->sig_pay0_seller : $deal->sig_pay0_buyer ) ?>"> 
												<div class="t565__number t-name t-name_md" style="">
													{{ ++$count }}
												</div> 
											</div> 
										</div> 
										<div class="t565__block-flipped"> <!-- Название пункта --><!-- Описание пункта -->
											<div class="t565__descr t-text t-text_xs" field="li_descr__1548859881073" style="">
											@if(Auth::user()->id != $deal->user_seller_id)
											<!-- Если вошел Покупатель,а контрагент - продавец -->
												
												@if($deal->sig_pay0_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) ?>">
														Ожидается подтверждение Продавцом получение Предоплаты
													</div>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) ?>;">
														Продавец подтвердил получение Предоплаты
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_seller) ?>" >
													<b>Продавец просрочил подтверждение Предоплаты!<br /> Обсудите срок оплаты с Продавцом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@else
											<!-- Если вошел Продавец, а контрагент - Покупатель -->
												@if($deal->sig_pay0_buyer == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) ?>">
														Ожидается подтверждение выполненной Предоплаты Покупателем
													</div>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) ?>;">
														Покупатель выполнил Предоплату
													</div>
												@endif
												
												@if($deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($deal->getDateMiddle($date_initial, $date_deadline), $deal->sig_pay0_buyer) ?>" >
													<b>Покупатель не выполнил Предоплату в срок!<br /> Обсудите срок Предоплаты в сообщениях с Покупателем!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@endif
											</div> 
										</div> 
									</div> 
								</div> 
							</div> <!-- /Пункт 4 -->
						@endif
						
						
						<!-- Пункт 5 - Подтверждение предоставления услугиа -->
						<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 5 -->
							<div class="t-width t-width_8 t565__mainblock"> 
								<div class="t565__col "> 
									<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
										<div class="t565__line" style="width: 2px;"></div> 
										<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($date_deadline, Auth::user()->id == $deal->user_seller_id ? $deal->sig_serv_seller : $deal->sig_serv_buyer ) ?>"> 
											<div class="t565__number t-name t-name_md" style="">
												{{ ++$count }}
											</div> 
										</div> 
									</div> 
									<div class="t565__block"> <!-- Название пункта --><!-- Описание пункта -->
										<div class="t565__title t-name t-name_lg" field="li_title__1479137790652" style="">Подтверждение предоставления услуги</div> 
										<div class="t565__descr t-text t-text_xs" field="li_descr__1479137790652" style="">
										@if(Auth::user()->id == $deal->user_seller_id)
										<!-- Если вошел Продавец -->
											@if($deal->sig_serv_seller == 0)
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_seller) ?>">
													Подтвердите, предоставили ли Вы услугу Покупателю
												</div>
												<form method="POST" action="{{ route('deals.prove') }}" > 
											  		@csrf
													<input type="hidden" name="_method" value="POST">
													<input type="hidden" name="sig" value="sig_serv_seller" />
													<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
													<button type="submit" class="btn1" onclick="return confirm('Are you sure?')" <?php if($deal->sig_approved_seller == 0) echo "disabled" ?> >
											            Подтвердить предоставление услуги
											        </button>
										        </form>
											@else
												<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_serv_seller) ?>;">
													Вы подтвердили предоставление услуги Покупателю
												</div>
											@endif
											
											@if($deal->verSwitchWarn($date_deadline, $deal->sig_serv_seller) == "alert-warning")
											<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_seller) ?>" >
												<b>Вы просрочили подтверждение предоставления услуги Покупателю!<br /> Обсудите срок предоставления услуги с Покупателем!</b><br /> (область сообщений внизу страницы)
											</div>
											@endif
										@else
										<!-- Если вошел Покупатель -->
											@if($deal->sig_serv_buyer == 0)
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_buyer) ?>">
													Подтвердите, получена ли Вами услуга от Продавца
												</div>
												<form method="POST" action="{{ route('deals.prove') }}" > 
											  		@csrf
													<input type="hidden" name="_method" value="POST">
													<input type="hidden" name="sig" value="sig_serv_buyer" />
													<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
													<button type="submit" class="btn1" onclick="return confirm('Are you sure?')" <?php if($deal->sig_approved_buyer == 0) echo "disabled" ?> >
											            Подтвердить получение услуги от Продавца
											        </button>
										        </form>
											@else
												<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_serv_buyer) ?>;">
													Вы подтвердили получение услуги от Продавца
												</div>
											@endif
											
											@if($deal->verSwitchWarn($date_deadline, $deal->sig_serv_buyer) == "alert-warning")
											<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_buyer) ?>" >
												<b>Вы не подтвердили получение услуги в срок!<br /> Обсудите срок получения услуги от Продавца!</b><br /> (область сообщений внизу страницы)
											</div>
											@endif
										@endif
										</div> 
									</div> 
								</div> 
							</div> 
						</div> <!-- /Пункт 5 -->

						<!-- Пункт 6 -->
						<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 6 -->
							<div class="t-width t-width_8 t565__mainblock"> 
								<div class="t565__col t565__flipped"> 
									<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
										<div class="t565__line" style="width: 2px;"></div> 
										<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($date_deadline, Auth::user()->id != $deal->user_seller_id ? $deal->sig_serv_seller : $deal->sig_serv_buyer ) ?>"> 
											<div class="t565__number t-name t-name_md" style="">
												{{ ++$count }}
											</div> 
										</div> 
									</div> 
									<div class="t565__block-flipped"> <!-- Название пункта --><!-- Описание пункта -->
										<div class="t565__descr t-text t-text_xs" field="li_descr__1548859881073" style="">
										@if(Auth::user()->id != $deal->user_seller_id)
										<!-- Если вошел Покупатель,а контрагент - продавец -->
											@if($deal->sig_serv_seller == 0)
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_seller) ?>">
													Ожидается подтверждение Продавцом предоставления услуги
												</div>
											@else
												<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_serv_seller) ?>;">
													Продавец подтвердил предоставление Вам услуги
												</div>
											@endif
											
											@if($deal->verSwitchWarn($date_deadline, $deal->sig_serv_seller) == "alert-warning")
											<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_seller) ?>" >
												<b>Продавец просрочил подтверждение предоставления услуги!<br /> Обсудите срок предоставления услуги с Продавцом!</b><br /> (область сообщений внизу страницы)
											</div>
											@endif
										@else
										<!-- Если вошел Продавец, а контрагент - Покупатель -->
											@if($deal->sig_serv_buyer == 0)
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_buyer) ?>">
													Ожидается подтверждение получения услуги Покупателем
												</div>
											@else
												<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_serv_buyer) ?>;">
													Покупатель подтвердил получение услуги
												</div>
											@endif
											
											@if($deal->verSwitchWarn($date_deadline, $deal->sig_serv_buyer) == "alert-warning")
											<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_serv_buyer) ?>" >
												<b>Покупатель не подтвердил получение услуги в срок!<br /> Обсудите срок предоставления услуги в сообщениях с Покупателем!</b><br /> (область сообщений внизу страницы)
											</div>
											@endif
										@endif
										</div> 
									</div> 
								</div> 
							</div> 
						</div> <!-- /Пункт 6 -->
						
						
						@if($deal->getTermsPayment() > 1 && $deal->getTermsPayment() < 6)
							<!-- Пункт 7 - Подтверждение окончательной Оплаты  -->
							<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 7 -->
								<div class="t-width t-width_8 t565__mainblock"> 
									<div class="t565__col "> 
										<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
											<div class="t565__line" style="width: 2px;"></div> 
											<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($date_deadline, Auth::user()->id == $deal->user_seller_id ? $deal->sig_pay_seller : $deal->sig_pay_buyer ) ?>"> 
												<div class="t565__number t-name t-name_md" style="">
													{{ ++$count }}
												</div> 
											</div> 
										</div> 
										<div class="t565__block"> <!-- Название пункта --><!-- Описание пункта -->
											<div class="t565__title t-name t-name_lg" field="li_title__1479137790652" style="">Подтверждение окончательной Оплаты</div> 
											<div class="t565__descr t-text t-text_xs" field="li_descr__1479137790652" style="">
											@if(Auth::user()->id == $deal->user_seller_id)
											<!-- Если вошел Продавец -->
												@if($deal->sig_pay_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_seller) ?>">
														Подтвердите, получили ли Вы окончательную Оплату от Покупателя
													</div>
													<form method="POST" action="{{ route('deals.prove') }}" > 
												  		@csrf
														<input type="hidden" name="_method" value="POST">
														<input type="hidden" name="sig" value="sig_pay_seller" />
														<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
														<button type="submit" class="btn1" onclick="return confirm('Are you sure?')" <?php if($deal->sig_approved_seller == 0) echo "disabled" ?> >
												            Подтвердить получение Оплаты
												        </button>
											        </form>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_pay_seller) ?>;">
														Вы подтвердили получение окончательной Оплаты от Покупателя
													</div>
												@endif
												
												@if($deal->verSwitchWarn($date_deadline, $deal->sig_pay_seller) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_seller) ?>" >
													<b>Вы просрочили подтверждение получение окончательной Оплаты от Покупателя!<br /> Обсудите срок получения окончательной Оплаты с Покупателем!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@else
											<!-- Если вошел Покупатель -->
												@if($deal->sig_pay_buyer == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_buyer) ?>">
														Подтвердите, выполнена ли Вами окончательная Оплата за услугу Продавцу
													</div>
													<form method="POST" action="{{ route('deals.prove') }}" > 
												  		@csrf
														<input type="hidden" name="_method" value="POST">
														<input type="hidden" name="sig" value="sig_pay_buyer" />
														<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
														<button type="submit" class="btn1" onclick="return confirm('Are you sure?')" <?php if($deal->sig_approved_buyer == 0) echo "disabled" ?> >
												            Подтвердить выполнение Оплаты
												        </button>
											        </form>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_pay_buyer) ?>;">
														Вы подтвердили выполнение окончательной Оплаты за услугу Продавцу
													</div>
												@endif
												
												@if($deal->verSwitchWarn($date_deadline, $deal->sig_pay_buyer) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_buyer) ?>" >
													<b>Вы не подтвердили выполнение окончательной Оплаты за услугу Продавцу в срок!<br /> Обсудите срок выполнение окончательной Оплаты за услугу с Продавцом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@endif
											</div> 
										</div> 
									</div> 
								</div> 
							</div> <!-- /Пункт 7 -->

							<!-- Пункт 8 -->
							<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 8 -->
								<div class="t-width t-width_8 t565__mainblock"> 
									<div class="t565__col t565__flipped"> 
										<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
											<div class="t565__line" style="width: 2px;"></div> 
											<div class="t565__circle" style="background-color: <?php echo $deal->verDateColor($date_deadline, Auth::user()->id != $deal->user_seller_id ? $deal->sig_pay_seller : $deal->sig_pay_buyer ) ?>"> 
												<div class="t565__number t-name t-name_md" style="">
													{{ ++$count }}
												</div> 
											</div> 
										</div> 
										<div class="t565__block-flipped"> <!-- Название пункта --><!-- Описание пункта -->
											<div class="t565__descr t-text t-text_xs" field="li_descr__1548859881073" style="">
											@if(Auth::user()->id != $deal->user_seller_id)
											<!-- Если вошел Покупатель,а контрагент - продавец -->
												@if($deal->sig_pay_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_seller) ?>">
														Ожидается подтверждение Продавцом получения окончательной Оплаты за услугу
													</div>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_pay_seller) ?>;">
														Продавец подтвердил получение окончательной Оплаты за услугу
													</div>
												@endif
												
												@if($deal->verSwitchWarn($date_deadline, $deal->sig_pay_seller) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_seller) ?>" >
													<b>Продавец просрочил подтверждение получения окончательной Оплаты за услугу!<br /> Обсудите срок окончательной Оплаты с Продавцом!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@else
											<!-- Если вошел Продавец, а контрагент - Покупатель -->
												@if($deal->sig_pay_buyer == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_buyer) ?>">
														Ожидается подтверждение выполнения окончательной Оплаты за услугу
													</div>
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, $deal->sig_pay_buyer) ?>;">
														Покупатель подтвердил выполнение окончательной Оплаты за услугу
													</div>
												@endif
												
												@if($deal->verSwitchWarn($date_deadline, $deal->sig_pay_buyer) == "alert-warning")
												<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, $deal->sig_pay_buyer) ?>" >
													<b>Покупатель не подтвердил выполнение окончательной Оплаты за услугу в срок!<br /> Обсудите срок окончательной Оплаты в сообщениях с Покупателем!</b><br /> (область сообщений внизу страницы)
												</div>
												@endif
											@endif
											</div> 
										</div> 
									</div> 
								</div> 
							</div> <!-- /Пункт 8 -->
						@endif
						

						<!-- Пункт 9 -->
						<div class="t565__item" style="padding-bottom:100px;"> <!-- Пункт 9 -->
							<div class="t-width t-width_8 t565__mainblock"> 
								<div class="t565__col"> 
									<div class="t565__linewrapper"> <!-- Линия --><!-- Кружок --><!-- Номер -->
										<div class="t565__circle" style="background-color: 
										<?php
										if($deal->getTermsPayment() == 1){
											if($deal->sig_approved_buyer == 1 && $deal->sig_pay0_buyer == 1 && $deal->sig_serv_buyer == 1 && $deal->sig_approved_seller == 1 && $deal->sig_pay0_seller == 1 && $deal->sig_serv_seller == 1){echo $deal->verDateColor($date_deadline, 1);}else{echo $deal->verDateColor($date_deadline, 0);}}
										if($deal->getTermsPayment() == 2 || $deal->getTermsPayment() == 5){
											if($deal->sig_approved_buyer == 1 && $deal->sig_pay_buyer == 1 && $deal->sig_serv_buyer == 1 && $deal->sig_approved_seller == 1 && $deal->sig_pay_seller == 1 && $deal->sig_serv_seller == 1){echo $deal->verDateColor($date_deadline, 1);}else{echo $deal->verDateColor($date_deadline, 0);}}
											if($deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4){
											if($deal->sig_approved_buyer == 1 && $deal->sig_pay_buyer == 1 && $deal->sig_pay0_buyer == 1 && $deal->sig_serv_buyer == 1 && $deal->sig_approved_seller == 1 && $deal->sig_pay_seller == 1 && $deal->sig_pay0_seller == 1 && $deal->sig_serv_seller == 1){echo $deal->verDateColor($date_deadline, 1);}else{echo $deal->verDateColor($date_deadline, 0);}}
										?>
										"> 
											<div class="t565__number t-name t-name_md" style="color: #000;">
												{{ ++$count }}
											</div> 
										</div> 
									</div>
									<div class="t565__block"> <!-- Название пункта --><!-- Описание пункта -->
										<div class="t565__title t-name t-name_lg" field="li_title__1479137044697" style="">Завершение сделки</div> 
										<div class="t565__descr t-text t-text_xs" field="li_descr__1479137044697" style="">
											<!-- Оплата только в начале сделки -->
											@if($deal->getTermsPayment() == 1)
												@if($deal->sig_approved_buyer == 0 || $deal->sig_pay0_buyer == 0 || $deal->sig_serv_buyer == 0 || $deal->sig_approved_seller == 0 || $deal->sig_pay0_seller == 0 || $deal->sig_serv_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>">
														Сделка не завершена. Не подтверждены все этапы сделки. Свяжитесь с контрагентом для решения оставшихся вопросов
													</div>
													@if($deal->verSwitchWarn($date_deadline, 0) == "alert-warning")
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
														<b>Конечный срок реализации сделки прошел!</b><br />Срочно свяжитесь с контрагентом для выяснения дальнейшей судьбы сделки!
													</div>
														@if($deal->sig_pay0_buyer == 0 && $deal->sig_serv_buyer == 0 && $deal->sig_pay0_seller == 0 && $deal->sig_serv_seller == 0)
			<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
			По истечении 30 дней (для услуг "Под заказ" 60 дней) сделка будет аннулирована!<br>
			@if(Auth::user()->id == $deal->author)
				Либо вы можете аннулировать ее сами (или по просьбе контрагента)
				<form method="POST" action="{{ route('deals.annul') }}" > 
			  		@csrf
					<input type="hidden" name="_method" value="POST">
					<input type="hidden" name="status_deal" value="5" />
					<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
					<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
			            Аннулировать сделку
			        </button>
		        </form>
		    </div>
		    @else
		    	Вы можете направить сообщение контрагенту с просьбой аннулировать сделку. При этом необходимо указать аргументированную причину
		    @endif
														@else
															<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
															Один из контрагентов не подтвердил текущий этап сделки!
															</div>
														@endif
													@endif
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, 1) ?>;">
														Сделка завершена. Теперь Вы можете оставить отзыв о контрагенте<br> 
														<form method="POST" action="{{ route('ratings.store') }}" > 
													  		@csrf
															<input type="hidden" name="_method" value="POST">
															<input type="hidden" name="user_auditor_id" value="{{ Auth::user()->id }}" />
															<input type="hidden" name="user_rated_id" value="{{ Auth::user()->id == $deal->author ? $deal->initiator : $deal->author }}" />
															<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
															<input type="hidden" name="service_id" value="{{ $deal->service->id }}" />
															<input type="hidden" name="title" value="{{ null != $deal->service->title ? $deal->service->title : ''}}" />
															<input type="hidden" name="kind_id" value="{{ null != $deal->service->kind_id ? $deal->service->kind_id : '' }}" />
															<input type="hidden" name="user_role" value="{{ Auth::user()->id == $deal->user_seller_id ? 1 : 2 }}" />
															<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
													            Оставить отзыв
													        </button>
												        </form>
													</div>
												@endif
											@endif
											
											<!-- Оплата только в конце сделки -->
											@if($deal->getTermsPayment() == 2 || $deal->getTermsPayment() == 5)
												@if($deal->sig_approved_buyer == 0 || $deal->sig_pay_buyer == 0 || $deal->sig_serv_buyer == 0 || $deal->sig_approved_seller == 0 || $deal->sig_pay_seller == 0 || $deal->sig_serv_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>">
														Сделка не завершена. Не подтверждены все этапы сделки. Свяжитесь с контрагентом для решения оставшихся вопросов
													</div>
													@if($deal->verSwitchWarn($date_deadline, 0) == "alert-warning")
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
														<b>Конечный срок реализации сделки прошел!</b><br />Срочно свяжитесь с контрагентом для выяснения дальнейшей судьбы сделки!
													</div>
														@if($deal->sig_pay_buyer == 0 && $deal->sig_serv_buyer == 0 && $deal->sig_pay_seller == 0 && $deal->sig_serv_seller == 0)
			<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
			По истечении 30 дней (для услуг "Под заказ" 60 дней) сделка будет аннулирована!<br>
			@if(Auth::user()->id == $deal->author)
				Либо вы можете аннулировать ее сами (или по просьбе контрагента)
				<form method="POST" action="{{ route('deals.annul') }}" > 
			  		@csrf
					<input type="hidden" name="_method" value="POST">
					<input type="hidden" name="status_deal" value="5" />
					<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
					<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
			            Аннулировать сделку
			        </button>
		        </form>
		    </div>
		    @else
		    	Вы можете направить сообщение контрагенту с просьбой аннулировать сделку. При этом необходимо указать аргументированную причину
		    @endif
														@else
															<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
															Один из контрагентов не подтвердил текущий этап сделки!
															</div>
														@endif
													@endif
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, 1) ?>;">
														Сделка завершена. Теперь Вы можете оставить отзыв о контрагенте<br> 
														<form method="POST" action="{{ route('ratings.store') }}" > 
													  		@csrf
															<input type="hidden" name="_method" value="POST">
															<input type="hidden" name="user_auditor_id" value="{{ Auth::user()->id }}" />
															<input type="hidden" name="user_rated_id" value="{{ Auth::user()->id == $deal->author ? $deal->initiator : $deal->author }}" />
															<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
															<input type="hidden" name="service_id" value="{{ $deal->service->id }}" />
															<input type="hidden" name="title" value="{{ null != $deal->service->title ? $deal->service->title : ''}}" />
															<input type="hidden" name="kind_id" value="{{ null != $deal->service->kind_id ? $deal->service->kind_id : '' }}" />
															<input type="hidden" name="user_role" value="{{ Auth::user()->id == $deal->user_seller_id ? 1 : 2 }}" />
															<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
													            Оставить отзыв
													        </button>
												        </form>
													</div>
												@endif
											@endif
											
											
											<!-- Оплата в начале и в конце сделки -->
											@if($deal->getTermsPayment() == 3 || $deal->getTermsPayment() == 4)
												@if($deal->sig_approved_buyer == 0 || $deal->sig_pay0_buyer == 0 || $deal->sig_pay_buyer == 0 || $deal->sig_serv_buyer == 0 || $deal->sig_approved_seller == 0 || $deal->sig_pay_seller == 0 || $deal->sig_pay_seller == 0 || $deal->sig_serv_seller == 0)
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>">
														Сделка не завершена. Не подтверждены все этапы сделки. Свяжитесь с контрагентом для решения оставшихся вопросов
													</div>
													@if($deal->verSwitchWarn($date_deadline, 0) == "alert-warning")
													<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
														<b>Конечный срок реализации сделки прошел!</b><br />Срочно свяжитесь с контрагентом для выяснения дальнейшей судьбы сделки!
													</div>
														@if($deal->sig_pay0_buyer == 0 && $deal->sig_pay_buyer == 0 && $deal->sig_serv_buyer == 0 && $deal->sig_pay0_seller == 0 && $deal->sig_pay_seller == 0 && $deal->sig_serv_seller == 0)
			<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
			По истечении 30 дней (для услуг "Под заказ" 60 дней) сделка будет аннулирована!<br>
			@if(Auth::user()->id == $deal->author)
				Либо вы можете аннулировать ее сами (или по просьбе контрагента)
				<form method="POST" action="{{ route('deals.annul') }}" > 
			  		@csrf
					<input type="hidden" name="_method" value="POST">
					<input type="hidden" name="status_deal" value="5" />
					<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
					<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
			            Аннулировать сделку
			        </button>
		        </form>
		    </div>
		    @else
		    	Вы можете направить сообщение контрагенту с просьбой аннулировать сделку. При этом необходимо указать аргументированную причину
		    @endif
														@else
															<div class="form-group alert <?php echo $deal->verSwitchWarn($date_deadline, 0) ?>" >
															Один из контрагентов не подтвердил текущий этап сделки!
															</div>
														@endif
													@endif
												@else
													<div style="padding: 5px 5px 5px 5px; border-radius: 5px; border: 2px solid <?php echo $deal->verDateColor($date_deadline, 1) ?>;">
														Сделка завершена. Теперь Вы можете оставить отзыв о контрагенте<br>
														<form method="POST" action="{{ route('ratings.store') }}" > 
													  		@csrf
															<input type="hidden" name="_method" value="POST">
															<input type="hidden" name="user_auditor_id" value="{{ Auth::user()->id }}" />
															<input type="hidden" name="user_rated_id" value="{{ Auth::user()->id == $deal->author ? $deal->initiator : $deal->author }}" />
															<input type="hidden" name="deal_id" value="{{ $deal->id }}" />
															<input type="hidden" name="service_id" value="{{ $deal->service->id }}" />
															<input type="hidden" name="title" value="{{ null != $deal->service->title ? $deal->service->title : ''}}" />
															<input type="hidden" name="kind_id" value="{{ null != $deal->service->kind_id ? $deal->service->kind_id : '' }}" />
															<input type="hidden" name="user_role" value="{{ Auth::user()->id == $deal->user_seller_id ? 1 : 2 }}" />
															<button type="submit" class="btn1" onclick="return confirm('Are you sure?')">
													            Оставить отзыв
													        </button>
												        </form> 
													</div>
												@endif
											@endif
											
											
											
										</div> 
									</div> 
								</div> 
							</div> 
						</div> <!-- /Пункт 9 -->
					</div> <!-- /Линия с кружечками уходящая вниз -->
						
					
					
					
					<!-- Область текстовых сообщений контрагентов -->
					<h2 style="text-align: center" >Сообщения по сделке</h2>
					<div class="col-sm-9" id="messages">
						@if(isset($messages))
							@foreach($messages as $message)
								@if(Auth::user()->id == $message->user_id)
									<div class="form-group alert alert-success col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px;">
										<a href="" style="">{{ Auth::user()->name }}</a> (Вы) &nbsp;&nbsp; {{ $message->getDateAttribute($message->created_at, $date_offset) }}
										<p><?php echo $message->message ?></p>
									</div>
								@endif
								
								@if(Auth::user()->id != $message->user_id)
									<div class="form-group alert alert-info col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 100px; margin-right: 10px; align-self: right">
										<a href="" style="">{{ Auth::user()->id == $deal->author ? $deal->initiatorUser->name : $deal->authorUser->name }}</a> (контрагент) &nbsp;&nbsp; {{ $message->getDateAttribute($message->created_at, $date_offset) }}
										<p><?php echo $message->message ?></p>
									</div>
								@endif
							@endforeach
						@endif

						<p>&nbsp; </p>
						<p>&nbsp; </p>
					</div>
	                	
	                	
	                	
	                <div class="col-sm-9" >
	                	<p>&nbsp; </p>
	                	<p>&nbsp; </p>
	                	<form id="myForm" method="post" action="{{ route('messages.store') }}" >
	                		{{csrf_field()}}
		                	<textarea name="message" id="message" cols="20" rows="5" maxlength="250" placeholder="Введите новое сообщение" style="padding: 10px; font-size: 120%"></textarea>
		                	<p></p>
							
							
								
							<input type="hidden" name="_method" id="_method" value="POST">
							<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
							<input type="hidden" name="deal_id" value="{{ $deal->id }}">
							<button class="btn btn-fefault cart" >Отправить</button>
						</form>
						
						<p>&nbsp; </p>
	                	
					</div>
	                <p>&nbsp; </p>
				</div>
			</div>
			
			
			
		            @elseif(isset($deal_create) && $deal_create == 2)
		            	Перед использованием сервиса необходимо 
		            	<a class="nav-link" href="/login">войти</a>
		            	 или 
		            	 <a class="nav-link" href="/register">зарегистрироваться</a>
		        	@elseif(isset($deal_create) && $deal_create == 4)
		            	Сделка успешно аннулирована  
		            	<a class="nav-link" href="{{ route('deals.index') }}">вернуться к перечню сделок</a>
		            @elseif(isset($deal_create) && $deal_create == 5)
		            	Сделка НЕ может быть аннулирована, поскольку уже частично выполнены ее этапы  
		            	<a class="nav-link" href="{{ route('deals.index') }}">вернуться к перечню сделок</a>
		            @else
		            	<div class="table-responsive cart_info">
							Нет текущих сделок или сделка аннулирована
						</div>
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

<!-- Этот элемент привязан к ссылке "Зареєструватись" -->
<script>
	function(e) {
	  var goTo = this.getAttribute("href");
	  if (goTo && goTo.substring(0, 4) == 'tel:') {
	    return true;
	  }
	  var target = $(this).attr("target");
	  if (target !== "_blank") {
	    e.preventDefault();
	    $(".t-records").removeClass("t-records_visible");
	    setTimeout(function() {
	      window.location = goTo;
	    }, 500);
	  }
	}
</script>

<!-- Отправка данных на сервер в фоновом режиме и получение контента -->
<script>  
//    $(document).ready(function(){  
//      
//        $('#myForm').submit(function(){  
//            $.ajax({  
//                method: "POST",  
//                url: "/messages/store",  
//                data: "message="+$("#message").val(),
//                		"user_id="+$("#user_id").val(),
//                		"deal_id="+$("#deal_id").val(),
//                		"_method=POST",
//                success: function(html){  
//                    $("#messages").html(html);  
//                }  
//            });  
//            return false;  
//        });  
//          
//    });  
</script>  

<script>  
//    $(document).ready(function(){  
//        $('#myForm').on('submit', function(e){  
//            e.preventDefault();
//            $.ajax({  
//                type: 'POST',  
//                url: '/messages/store',  
//                data: "message="+$("#message").val(),
//                		"user_id="+$("#user_id").val(),
//                		"deal_id="+$("#deal_id").val(),
//                		"_method="+$("#_method").val(),
//                success: function(html){  
//                    $("#messages").html(html);  
//                }  
//            });  
//        });  
//    });  
</script>  


<script>
//    function show() {
//        var url = $(this).attr('action');
//        $.ajax({
//            url:url,
//            dataType:'html',
//            data: {ajax:true},
//            type:'GET',
//            success:function(html){
//                $('#messages').html(html);
//            }
//        });
//    }
//    setInterval(show , 5000)
</script>


<script>  
//    function show()  
//    {  
//        $.ajax({  
//            url: "{{url('/messages/store')}}",  
//            cache: false,  
//            success: function(html){  
//                $("#messages").html(html);  
//            }  
//        });  
//    }  
//  
//    $(document).ready(function(){  
//        show();  
//        setInterval('show()',1000);  
//    });  
</script>  

@endpush