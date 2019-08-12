

@extends('layouts.app')

@section('content')
	<!--slider-->
	
	@if(!($servicesLidCar->isEmpty()) || !($servicesCarS->isEmpty()))
	<section id="slider">  <!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<!-- "carousel-inner" -->
						<div class="carousel-inner">  <!-- "carousel-inner" -->
							<!-- Объявления Первый слайд-->
							<?php $countCar = 0; ?>
							@foreach($servicesLidCar as $service)
								<?php $countCar++ ?>
								@if($countCar > 1)
									@break
								@endif
							<div class="item active">
								<div class="col-sm-6">
									<a href="{{ route('service.show', $service->id) }}" ><h1 style="font-size: 200%"><span><?php echo $service->serviceDesc->slogan ?></span></h1></a>
									<a href="{{ route('service.show', $service->id) }}" ><h2><?php echo $service->title ?></h2></a>
									
									<!--Реклама Helptop-->
									@if($service->bidding_type == 102)
										<a href="{{route('service.mysell.create')}}" class="btn btn-default cart" >
											<i class="fa fa-gavel" aria-hidden="true"></i>
											Создать новую услугу Продажи
										</a>
									@endif
									@if($service->bidding_type == 103)
										<a href="{{route('service.mybuy.create')}}" class="btn btn-default cart" >
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											Создать новую заявку на Покупку услуги
										</a>
									@endif
									<!--/Реклама Helptop-->
									
									<!-- Цены аукционов -->
									@if($service->bidding_type == 4 || $service->bidding_type == 6)
										<div class="price-search">
											{{ $service->price_current }} грн
										</div>
										<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-gavel" aria-hidden="true"></i>
											@lang('pages.bid_auction')
										</a>
									@endif
									@if($service->bidding_type == 5 || $service->bidding_type == 7)
										<div class="price-search">
											{{ $service->price_current }} грн
										</div>
										<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											@lang('pages.tender_bet')
										</a>
									@endif
									<!-- Цены фиксированных торгов -->
									<span style="display:block;">
									@if($service->bidding_type == 2 || $service->bidding_type == 6)
										<div class="price-search">
											{{ $service->price_buy_now }} грн
										</div>
										<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											@lang('pages.buy_now')
										</a>
									@endif
									@if($service->bidding_type == 3 || $service->bidding_type == 7)
										<div class="price-search">
											{{ $service->price_sell_now }} грн
										</div>
										<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
											@lang('pages.sell_now')
										</a>
									@endif
									</span>
									
									
									
									
									
								</div>
								<div class="col-sm-6 outer2">
									<a href="{{ route('service.show', $service->id) }}" ><img src="{{ $service->getImage() }}" style="width: 450px; max-height: 400px" alt="" /></a>
								</div>
							</div>
							@endforeach

							<!-- Объявления Остальные слайды-->
							@foreach($servicesCarS as $service)
								<?php $countCar++ ?>
								@if($countCar > 3)
									@break
								@endif
							<div class="item">
								<div class="col-sm-6">
									<a href="{{ route('service.show', $service->id) }}" ><h1 style="font-size: 200%"><span><?php echo $service->serviceDesc->slogan ?></span></h1></a>
									<a href="{{ route('service.show', $service->id) }}" ><h2><?php echo $service->title ?></h2></a>
									<!-- Цены аукционов -->
									@if($service->bidding_type == 4 || $service->bidding_type == 6)
										<div class="price-search">
											{{ $service->price_current }} грн
										</div>
										<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-gavel" aria-hidden="true"></i>
											@lang('pages.bid_auction')
										</a>
									@endif
									@if($service->bidding_type == 5 || $service->bidding_type == 7)
										<div class="price-search">
											{{ $service->price_current }} грн
										</div>
										<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											@lang('pages.tender_bet')
										</a>
									@endif
									<!-- Цены фиксированных торгов -->
									<span style="display:block;">
									@if($service->bidding_type == 2 || $service->bidding_type == 6)
										<div class="price-search">
											{{ $service->price_buy_now }} грн
										</div>
										<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
											@lang('pages.buy_now')
										</a>
									@endif
									@if($service->bidding_type == 3 || $service->bidding_type == 7)
										<div class="price-search">
											{{ $service->price_sell_now }} грн
										</div>
										<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
											<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
											@lang('pages.sell_now')
										</a>
									@endif
									</span>
									
									
									<!--Реклама Helptop-->
									@if($service->bidding_type == 102)
										<a href="{{route('service.mysell.create')}}" class="btn btn-default cart" >
											<i class="fa fa-gavel" aria-hidden="true"></i>
											Создать новую услугу Продажи
										</a>
									@endif
									@if($service->bidding_type == 103)
										<a href="{{route('service.mybuy.create')}}" class="btn btn-default cart" >
											<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
											Создать новую заявку на Покупку услуги
										</a>
									@endif
									<!--/Реклама Helptop-->
									
									
								</div>
								<div class="col-sm-6 outer2">
									<a href="{{ route('service.show', $service->id) }}" ><img src="{{ $service->getImage() }}" style="width: 400px; max-height: 330px" alt="" /></a>
								</div>
							</div>
							@endforeach
							
						</div>  <!-- /"carousel-inner" -->
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section>  <!--/slider-->
	@endif
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3"> <!--left-sidebar-->
					<!--left-sidebar-->
					@include('layouts._sidebar')
				</div>  <!--/left-sidebar-->
				
				
				<div class="col-sm-9 padding-right">
				<!--Показывать страницу только если найдены услуги-->
				@if(!($servicesLidBuy->isEmpty()) || !($servicesLidSell->isEmpty()) || !($servicesMidBuy->isEmpty()) || !($servicesMidSell->isEmpty()) || !($servicesStaBuy->isEmpty()) || !($servicesStaSell->isEmpty()) || !($servicesBuy->isEmpty()) || !($servicesSell->isEmpty()) || !($servicesLidRec->isEmpty()) || !($servicesLidRec1->isEmpty()) || !($servicesMidRec->isEmpty()) || !($servicesMidRec1->isEmpty()) || !($servicesStaRec->isEmpty()) || !($servicesStaRec1->isEmpty()) || !($servicesRec->isEmpty()) || !($servicesRec1->isEmpty()))
					<!--Купить услуги-->
					<div class="features_items">  <!--Купить услуги-->
						<h2 class="title text-center">@lang('pages.buy_services')</h2>
						
						<!-- Объявления Lider пакета-->
						<?php $countBuy = 0; ?>
						@foreach($servicesLidBuy as $service)
							<?php $countBuy++ ?>
							@if($countBuy == 4 || $countBuy > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 4 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													@lang('pages.bid_auction')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 2 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_buy_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													@lang('pages.buy_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
						<!-- Объявления Middle пакета-->
						@foreach($servicesMidBuy as $service)
							<?php $countBuy++ ?>
							@if($countBuy == 4 || $countBuy > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 4 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													@lang('pages.bid_auction')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 2 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_buy_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													@lang('pages.buy_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
						<!-- Объявления Старт пакета-->
						@foreach($servicesStaBuy as $service)
							<?php $countBuy++ ?>
							@if($countBuy == 4 || $countBuy > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 4 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													@lang('pages.bid_auction')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 2 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_buy_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													@lang('pages.buy_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
						<!-- Объявления Обычных объявлений-->
						@foreach($servicesBuy as $service)
							<?php $countBuy++ ?>
							@if($countBuy == 4 || $countBuy > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 4 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													@lang('pages.bid_auction')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 2 || $service->bidding_type == 6)
												<div class="price-search">
													{{ $service->price_buy_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													@lang('pages.buy_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
					</div>  <!--/Купить услуги-->
					
					<!--Продать услуги-->
					<div class="features_items"><!--Продать услуги-->
						<h2 class="title text-center">@lang('pages.sell_services')</h2>
						
						<!-- Объявления Lider пакета-->
						<?php $countSell = 0; ?>
						@foreach($servicesLidSell as $service)
							<?php $countSell++ ?>
							@if($countSell == 4 || $countSell > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 5 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													@lang('pages.tender_bet')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 3 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_sell_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
													@lang('pages.sell_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
						<!-- Объявления Middle пакета-->
						@foreach($servicesMidSell as $service)
							<?php $countSell++ ?>
							@if($countSell == 4 || $countSell > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 5 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													@lang('pages.tender_bet')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 3 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_sell_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
													@lang('pages.sell_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
						<!-- Объявления Старт пакета-->
						@foreach($servicesStaSell as $service)
							<?php $countSell++ ?>
							@if($countSell == 4 || $countSell > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 5 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													@lang('pages.tender_bet')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 3 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_sell_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
													@lang('pages.sell_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
						<!-- Объявления Обычных объявлений-->
						@foreach($servicesSell as $service)
							<?php $countSell++ ?>
							@if($countSell == 4 || $countSell > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
											@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
												<h3>@lang('pages.buy_one')</h3>
											@else
												<h3>@lang('pages.sell_the_service')</h3>
											@endif
											</a>
											<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
											<!-- Цены аукционов -->
											@if($service->bidding_type == 5 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_current }} грн
												</div>
												<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													@lang('pages.tender_bet')
												</a>
											@endif
											<!-- Цены фиксированных торгов -->
											<span style="display:block;">
											@if($service->bidding_type == 3 || $service->bidding_type == 7)
												<div class="price-search">
													{{ $service->price_sell_now }} грн
												</div>
												<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
													<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
													@lang('pages.sell_now')
												</a>
											@endif
											</span>
											
											<!--Реклама Helptop-->
											@if($service->bidding_type == 102)
												<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-gavel" aria-hidden="true"></i>
													Создать новую услугу Продажи
												</a>
											@endif
											@if($service->bidding_type == 103)
												<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
													<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
													Создать новую заявку на Покупку услуги
												</a>
											@endif
											<!--/Реклама Helptop-->
											
										</div>  <!-- /productinfo -->
									</div>
									<div class="choose" >
										<ul class="nav nav-pills nav-justified" >
											<li ><a href="{{ route('ratings.show', $service->user_id) }}" >
												@lang('pages.rating'):
												<p style="margin-bottom:0px; color: #F49925"><?php echo $service->ratingView($service->user_id) ?></p>
											</a></li>
											<li><a href="#"><i class="fa fa-map-marker "></i>
												
												<?php
							              			switch ($service->place_id) {
													  case '11':
													    echo 'По адресу Заказчика';
													    break;
													  case '12':
													    echo 'По адресу Поставщика';
													    break;
													  case '13':
													    echo 'Любой адрес в городе Заказчика';
													    break;
													  case '14':
													    echo 'Любой адрес в городе Поставщика';
													    break;
													  case '15':
													    echo 'Выезд в другой город';
													    break;
													  case '16':
													    echo 'Любое место';
													    break;
													  default:
													    break;
													}
							              		?>
											</a></li>
										</ul>
									</div>
									
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><a href="#">
												<i class="fa fa-calendar"></i>
												@lang('pages.date_off_bidding'):
												{{$service->getDateAttribute($service->date_off, $date_offset)}}
											</a></li>
											<li><a href="#">
												<i class="fa fa-clock-o"></i>
												@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
													@lang('pages.get_service'):</b>&nbsp;
												@else
													@lang('pages.provide_service'):</b>&nbsp;
												@endif
												@lang('pages.in') 
												<b style="color:#000000;">{{ $service->distance->period_initial }}</b>
												@lang('pages.days')
											</a></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
						
					</div>  <!--/Продать услуги-->
					
					
					<!--recommended_items-->
					<div class="recommended_items">  <!--recommended_items-->
						<h2 class="title text-center">@lang('pages.latest_offers')</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active" style="height:350px;">	
									<!-- Объявления Lider пакета-->
									<?php $countRec = 0; ?>
									@foreach($servicesLidRec as $service)
										<?php $countRec++ ?>
										@if($countRec == 4 || $countRec > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 180px; max-height: 180px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
									<!-- Объявления Middle пакета-->
									@foreach($servicesMidRec as $service)
										<?php $countRec++ ?>
										@if($countRec == 4 || $countRec > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 170px; max-height: 170px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
									<!-- Объявления Старт пакета-->
									@foreach($servicesStaRec as $service)
										<?php $countRec++ ?>
										@if($countRec == 4 || $countRec > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 170px; max-height: 170px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
									<!-- Объявления Обычных объявлений-->
									@foreach($servicesRec as $service)
										<?php $countRec++ ?>
										@if($countRec == 4 || $countRec > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 170px; max-height: 170px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
								</div>
								
								<div class="item" style="height:350px;">	
									<!-- Объявления Lider пакета-->
									<?php $countRec1 = 0; ?>
									@foreach($servicesLidRec1 as $service)
										<?php $countRec1++ ?>
										@if($countRec1 == 4 || $countRec1 > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 180px; max-height: 180px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
									<!-- Объявления Middle пакета-->
									@foreach($servicesMidRec1 as $service)
										<?php $countRec1++ ?>
										@if($countRec1 == 4 || $countRec1 > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 170px; max-height: 170px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
									<!-- Объявления Старт пакета-->
									@foreach($servicesStaRec1 as $service)
										<?php $countRec1++ ?>
										@if($countRec1 == 4 || $countRec1 > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 170px; max-height: 170px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
									<!-- Объявления Обычных объявлений-->
									@foreach($servicesRec1 as $service)
										<?php $countRec1++ ?>
										@if($countRec1 == 4 || $countRec1 > 4)
											@break
										@endif
										
										<div class="col-sm-4">
											<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
												<div class="single-products"  >
													<div class="productinfo text-center">
														<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 170px; max-height: 170px" />
														@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
															<h3>@lang('pages.buy_one')</h3>
														@else
															<h3>@lang('pages.sell_the_service')</h3>
														@endif
														</a>
														<a href="{{ route('service.show', $service->id) }}"><p>{{ $service->title }}</p></a>
														<!-- Цены аукционов -->
														@if($service->bidding_type == 4 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																@lang('pages.bid_auction')
															</a>
														@endif
														@if($service->bidding_type == 5 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_current }} грн
															</div>
															<a href="#" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																@lang('pages.tender_bet')
															</a>
														@endif
														<!-- Цены фиксированных торгов -->
														<span style="display:block;">
														@if($service->bidding_type == 2 || $service->bidding_type == 6)
															<div class="price-search">
																{{ $service->price_buy_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																@lang('pages.buy_now')
															</a>
														@endif
														@if($service->bidding_type == 3 || $service->bidding_type == 7)
															<div class="price-search">
																{{ $service->price_sell_now }} грн
															</div>
															<a href="/service/{{$service->id}}#window1" class="btn btn-default add-to-cart" style="font-size:10pt;">
																<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
																@lang('pages.sell_now')
															</a>
														@endif
														</span>
														
														<!--Реклама Helptop-->
														@if($service->bidding_type == 102)
															<a href="{{route('service.mysell.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-gavel" aria-hidden="true"></i>
																Создать новую услугу Продажи
															</a>
														@endif
														@if($service->bidding_type == 103)
															<a href="{{route('service.mybuy.create')}}" class="btn btn-default add-to-cart" style="font-size:8pt;">
																<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
																Создать новую заявку на Покупку услуги
															</a>
														@endif
														<!--/Реклама Helptop-->
														
													</div>  <!-- /productinfo -->
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">@lang('pages.no_results_request')...</label>
					</div>
				@endif
				</div>
				
			</div>
		</div>
	</section>
	
	

	
	
@endsection



