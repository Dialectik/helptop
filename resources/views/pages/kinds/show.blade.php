
@extends('layouts.app_cat')

@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Путь -->
					<div class="breadcrumbs">
						<ol class="breadcrumb">
						  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
						  <li><a href="{{ route('section.show', $section_id) }}">{{ $section_title }}</a></li>
						  <li class="active">{{ $category_current }}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3"> <!--left-sidebar-->
					<!--left-sidebar-->
					@include('layouts._sidebar_kind')
				</div>
				
				<div class="col-sm-9 padding-right">
				
									<div class="features_items"><!--Выбор вида-->
						<h2 class="title text-center">@lang('pages.select_kind') <small>@lang('pages.in_category'):</small>
							{{$category_current}}	
						</h2>
						<div class="features_items">
						<?php $count = 0 ?>
						@foreach($kinds_cat as $kind)
							<?php $count++ ?>
							@if($count % 4 == 1)
								</div><div class="features_items">
							@endif
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<a href="{{ route('kind.edit', $kind->id) }}" ><img src="/images/kinds/{{ $kind->code }}.jpg" alt="" /></a>
												<a href="{{ route('kind.edit', $kind->id) }}"><p>{{ $kind->title }}</p></a>
											</div>
											<a href="{{ route('kind.edit', $kind->id) }}">
												<div class="product-overlay">
													<div class="overlay-content">
														<p>{{ $kind->title }}</p>
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							
						@endforeach
						</div>

					</div><!--/Выбор вида-->
				
				<!--Показывать страницу только если найдены услуги-->
				@if(!($servicesLidBuy->isEmpty()) || !($servicesLidSell->isEmpty()) || !($servicesMidBuy->isEmpty()) || !($servicesMidSell->isEmpty()) || !($servicesStaBuy->isEmpty()) || !($servicesStaSell->isEmpty()) || !($servicesBuy->isEmpty()) || !($servicesSell->isEmpty()))
				


					<div class="features_items"><!--Купить услуги-->
						<h2 class="title text-center">@lang('pages.buy_services') <small>@lang('pages.in_category'):</small>
							{{$category_current}}
						</h2>
						<!-- Объявления Lider пакета-->
						<?php $countBuy = 0; ?>
						@foreach($servicesLidBuy as $service)
							<?php $countBuy++ ?>
							@if($countBuy > 3)
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
							@if($countBuy > 3)
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
							@if($countBuy > 3)
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
							@if($countBuy > 3)
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
					</div><!--/Купить услуги-->
					
					<div class="features_items"><!--Продать услуги-->
						<h2 class="title text-center">@lang('pages.sell_services') <small>@lang('pages.in_category'):</small>
							{{$category_current}}	
						</h2>
						<!-- Объявления Lider пакета-->
						<?php $countSell = 0; ?>
						@foreach($servicesLidSell as $service)
							<?php $countSell++ ?>
							@if($countSell > 3)
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
							@if($countSell > 3)
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
							@if($countSell > 3)
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
							@if($countSell > 3)
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
					</div><!--/Продать услуги-->
					
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



