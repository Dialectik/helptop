<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php if(isset($kind->description)){ echo $kind->description;}else{ echo 'Разместить объявление для продажи услуги. Найти исполнителя. В вашем городе. Надежные поставщики';} ?>">
    <meta name="author" content="">
    <meta name="keywords" content="<?php if(isset($kind->keywords)){ echo $kind->keywords;}else{ echo 'консультации, бизнес, фриланс, задание, обучение, лечение, спорт, перевозки, такси, автосервис, отдых, хозяйство, еда, театр, кино, растения, животные, отели, туры, салоны, ремонт, уборка, строительные, веб, it, аренда, нотариус, адвокат, страхование';} ?>">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title><?php if(isset($kind->title)){ echo $kind->title;} ?></title>

    <link href="/css/pages/bootstrap.min.css" rel="stylesheet">
    <link href="/css/pages/font-awesome.min.css" rel="stylesheet">
    <link href="/css/pages/prettyPhoto.css" rel="stylesheet">
    <link href="/css/pages/price-range.css" rel="stylesheet">
    <link href="/css/pages/animate.css" rel="stylesheet">
	<link href="/css/pages/main.css" rel="stylesheet">
	<link href="/css/pages/responsive.css" rel="stylesheet">
	<link href="/css/pages/menu-vertical.css" rel="stylesheet">
	<link href="/css/pages/menu-horiz.css" rel="stylesheet">
	<link href="/css/pages/search.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <style>
      #window {
        background: rgba(102, 102, 102, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
      }
      #okno {
        width: 300px;
        height: 350px;
        text-align: center;
        padding: 15px;
        border: 3px solid #FE980F;
        border-radius: 10px;
        color: #0000cc;
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        margin-top: 100px;
        background: #fff;
        z-index:1000;
      }
      #window:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 18px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
      }
      .close:hover {background: #FE980F;}
    </style>
    <style>
      #window1 {
        background: rgba(102, 102, 102, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
      }
      #okno1 {
        width: 300px;
        height: 180px;
        text-align: center;
        padding: 25px;
        border: 3px solid #FE980F;
        border-radius: 10px;
        color: #0000cc;
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        margin-top: 200px;
        background: #fff;
        z-index:1000;
      }
      #window1:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 18px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
      }
      .close:hover {background: #FE980F;}
    </style>
    <style>
      #window2 {
        background: rgba(102, 102, 102, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
      }
      #okno2 {
        width: 300px;
        height: 180px;
        text-align: center;
        padding: 25px;
        border: 3px solid #FE980F;
        border-radius: 10px;
        color: #0000cc;
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        margin-top: 200px;
        background: #fff;
        z-index:1000;
      }
      #window2:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 18px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
      }
      .close:hover {background: #FE980F;}
    </style>
    <style>
      #window4 {
        background: rgba(102, 102, 102, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
      }
      #okno4 {
        width: 430px;
        height: 500px;
        text-align: center;
        padding: 15px;
        border: 3px solid #FE980F;
        border-radius: 10px;
        color: #0000cc;
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        margin-top: 100px;
        background: #fff;
        z-index:1000;
      }
      #window4:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 18px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
      }
      .close:hover {background: #FE980F;}
    </style>
	<style>
	#district_all, #code_un, #date_un, #price_all, #price_f, #price_s, #price_type {
		display: none;
	}

	</style>
	
	<style>
		#testElement {
		-webkit-animation:name 2s infinite;
		animation:name 2s infinite;   
		}

		@-webkit-keyframes name
		{
		0% {background-color:#ffffff;}
		100% {background-color:#4fb328;}
		0% {color:#737b7a;}
		100% {color:#ffffff;}
		}
		    @keyframes name {
		        0% {background-color:#ffffff;}
		        100% {background-color:#4fb328;}
		        0% {color:#737b7a;}
				100% {color:#ffffff;}
		    }
	</style>
	
	<style>
		#testElement1 {
		-webkit-animation:name 2s infinite;
		animation:name 2s infinite;   
		}

		@-webkit-keyframes name
		{
		0% {background-color:#ffffff;}
		100% {background-color:#4fb328;}
		0% {color:#737b7a;}
		100% {color:#ffffff;}
		}
		    @keyframes name {
		        0% {background-color:#ffffff;}
		        100% {background-color:#4fb328;}
		        0% {color:#737b7a;}
				100% {color:#ffffff;}
		    }
	</style>
	
    
    <!--Вставка индивидуальных стилей страницы-->
    @stack('styles')
    
</head><!--/head-->

<body>
	
	
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="social-icons">
							<ul class="nav navbar-nav">
<!--								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="contactinfo pull-right">
							<ul class="nav nav-pills">
		                        
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{ route('welcome') }}">
			                    <img src="/images/Logo3__.jpg" alt="{{ config('app.name', 'HelpTop') }}" width="165"/>
			                </a>
						</div>
						<div class="btn-group pull-right">
							<div class="nav navbar-nav" style="vertical-align:middle; text-align:center; margin:10px">
								@lang('layouts.slogan')<br> 
								@lang('layouts.slogan_')
							</div>
							<!-- Языковая панель -->
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									@lang('layouts.language')
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									@include('locales.locale')
								</ul>
							</div>
							
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li title="@lang('layouts.buy_hint')"><a href="{{ route('biddingtype.edit', 22) }}"><i class="fa fa-coffee"></i> @lang('layouts.buy')</a></li>
								<li title="@lang('layouts.sell_hint')"><a href="{{ route('biddingtype.edit', 23) }}"><i class="fa fa-money"></i> @lang('layouts.sell')</a></li>
								<li ><a href="{{ route('baskets.edit', isset(Auth::user()->id) ? Auth::user()->id : 0) }}" <?php  if(isset($basket_mark)){echo $basket_mark;} ?>  ><i class="fa fa-shopping-cart"></i> @lang('layouts.cart')</a></li>
								<li><a href="{{route('refer.index')}}"><i class="fa fa-file-text-o"></i> @lang('layouts.regulations')</a></li>
								
								<!-- Authentication Links -->
		                        @guest
		                            @if(Route::has('login'))
		                            <li class="nav-item">
		                                <a class="nav-link" href="/login">
		                                	<i class="fa fa-lock"></i>
		                                	@lang('auth.login')
		                                </a>
		                            </li>
		                            @endif
		                            
		                            @if(Route::has('register'))
	                                <li class="nav-item">
	                                    <a class="nav-link" href="/register">
	                                    	<i class="fa fa-users"></i>
	                                    	@lang('auth.register')
	                                    </a>
	                                </li>
		                            @endif
		                        @else
									<li><a href="{{ route('logout') }}"
		                                    onclick="event.preventDefault();
		                                    document.getElementById('logout-form').submit();">
		                                    <i class="fa fa-unlock"></i>
		                                    @lang('auth.logout')
		                                </a>
	                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
		                            </li>
		                            <li>
		                            	<div class="btn-group pull-right">
			                            <div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
												<i class="fa fa-user"> </i>
												{{ Auth::user()->name }}
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
												<li>
				                                    <a class="nav-link" href="{{ route('myprofile.index') }}">
				                                    	<i class="fa fa-cog"></i>
				                                    	@lang('layouts.pers_data')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('deals.index') }}">
				                                    	<i class="fa fa-suitcase"></i>
				                                    	@lang('layouts.deals')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="">
				                                    	<i class="fa fa-eye"></i>
				                                    	@lang('layouts.biddings')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('service.mysell') }}">
				                                    	<i class="fa fa-gavel"></i>
				                                    	@lang('layouts.my_sale_ads')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('service.mybuy') }}">
				                                    	<i class="fa fa-bar-chart-o"></i>
				                                    	@lang('layouts.my_purchase')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('scores.index') }}">
				                                    	<i class="fa fa-credit-card"></i>
				                                    	@lang('layouts.score') 
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('blurbs.index') }}">
				                                    	<i class="fa fa-magnet"></i>
				                                    	@lang('layouts.blurb')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="">
				                                    	<i class="fa fa-star"></i>
				                                    	@lang('layouts.favorites')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('messages.index') }}">
				                                    	<i class="fa fa-envelope-o"></i>
				                                    	@lang('layouts.messages')
				                                    </a>
				                                </li>
				                                <!--<li>
				                                    <a class="nav-link" href="">
				                                    	<i class="fa fa-comment-o"></i>
				                                    	@lang('layouts.reviews')
				                                    </a>
				                                </li>-->
				                                <li>
				                                    <a class="nav-link" href="{{ route('ratings.show', Auth::user()->id) }}">
				                                    	<i class="fa fa-heart"></i>
				                                    	@lang('layouts.rating')
				                                    </a>
				                                </li>
				                                <li>
				                                    <a class="nav-link" href="{{ route('baskets.edit', isset(Auth::user()->id) ? Auth::user()->id : 0) }}">
				                                    	<i class="fa fa-shopping-cart"></i>
				                                    	@lang('layouts.cart')
				                                    </a>
				                                </li>
				                                <li><a href="{{ route('logout') }}"
					                                    onclick="event.preventDefault();
					                                    document.getElementById('logout-form').submit();">
					                                    <i class="fa fa-unlock"></i>
					                                    @lang('auth.logout')
					                                </a>
				                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
					                            </li>
											</ul>
										</div>
										</div>
		                            
		                            </li>
		                            
		                        @endguest
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			
			<!--Всплывающее окошко выбора города-->
			<div id="window">
				<form method="POST" action="{{ route('city.index') }}" > 
	  				@csrf
			      <div id="okno">
			        <!-- Адрес предоставления услуги -->
					<div class="order-message">
						<label>@lang('layouts.region_service'):</label>
					</div>
					<!-- Область -->

					<div class="form-group">
						<select class="form-control select2" name="region" id="region" style="width: 100%;" >
							<option value="@if(isset($region)){{$region}}@else{{""}}@endif">@if(isset($region)){{$region}}@else- @lang('layouts.choose_region') -@endif</option>
							@foreach($address as $addr)
								<option value="{{$addr->region}}">{{$addr->region}}</option>
							@endforeach
							<option value="">- @lang('layouts.choose_region') -</option>
						</select>
				    </div>
					<!-- Город -->
					<div class="order-message">
						<label>@lang('layouts.city'):</label>
					</div>
				    <div class="form-group">
						
						<select class="form-control select2" name="city" id="city" style="width: 100%;" >
						<option selected value="@if(isset($city)){{$city}}@else{{""}}@endif">
							@if(isset($city))
								{{$city}}
							@else
								- @lang('layouts.choose_city') -
							@endif
						</option>
						</select>
				    </div>
					<!-- Район -->
				    <div id="district_all">    
				        <div class="order-message">
							<label>@lang('layouts.district'):</label>
						</div>
				        <div class="form-group">
							<select class="form-control select2" name="district" id="district" style="width: 100%;">
							<option selected value="@if(isset($district)){{$district}}@else{{""}}@endif">
								@if(isset($district))
									{{$district}}
								@else
									- @lang('layouts.choose_district') -
								@endif
							</option>
							</select>
				        </div>
				    </div>
			        
			        <input type="hidden" name="date_offset_c" id="date_offset_c"/>
			        <button type="submit" class="close" >
		            	@lang('layouts.choose')
		        	</button>
			        &nbsp;
			        <a href="#" class="close">Cancel</a>
			        
			      </div>
		      
				</form>
		    </div>
			
			
			<!--Всплывающее ставки или покупки/продажи-->
			@if(isset($service))
			<div id="window1"> <!--покупки/продажи-->
				<form method="POST" action="{{ route('baskets.store') }}" > 
	  				@csrf
			      <div id="okno1">
			        
			        <input type="hidden" name="date_offset_c" id="date_offset_c"/>
			        <input type="hidden" name="service_id" value="{{ $service->id }}" />
			        <input type="hidden" name="bidding_type" value="{{ $service->bidding_type }}" />
			        <input type="hidden" name="initiator" value="{{ isset(Auth::user()->id) ? Auth::user()->id : 0 }}" />
			        <!-- Цены фиксированных торгов -->
					@if($service->bidding_type == 2 || $service->bidding_type == 6)
						<label>{{ $service->price_buy_now }} грн</label>
						<input type="hidden" name="price_fin" value="{{ $service->price_buy_now }}" />
						<input type="hidden" name="user_seller_id" value="{{ $service->user_id }}" />
						<input type="hidden" name="user_buyer_id" value="{{ isset(Auth::user()->id) ? Auth::user()->id : 0 }}" />
						@if($service->number_total > 1)
							<input type="number" min="1" max="{{$service->number_total}}" name="number_unit" id="number_unit1" value="1" style="text-align: center; width: 50px;"/> единиц
						@else
							<input type="hidden" name="number_unit" value="1" />
						@endif
			        	<p></p>
			        	<button type="submit" class="btn btn-fefault cart">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
							@lang('pages.buy_now')
						</button>
					@endif
					@if($service->bidding_type == 3 || $service->bidding_type == 7)
						<label>{{ $service->price_sell_now }} грн</label>
						<input type="hidden" name="price_fin" value="{{ $service->price_sell_now }}" />
						<input type="hidden" name="user_seller_id" value="{{ isset(Auth::user()->id) ? Auth::user()->id : 0 }}" />
						<input type="hidden" name="user_buyer_id" value="{{ $service->user_id }}" />
						@if($service->number_total > 2)
							<input type="number" min="1" max="{{$service->number_total - 1}}" name="number_unit" id="number_unit2" value="1" style="text-align: center; width: 50px;"/> единиц
						@else
							<input type="hidden" name="number_unit" value="1" />
						@endif
						<p></p>
			        	<button type="submit" class="btn btn-fefault cart">
							<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
							@lang('pages.sell_now')
						</button>
					@endif
			        &nbsp;
			        <a href="" class="close" >Cancel</a>
			        
			      </div>
		      
				</form>
		    </div> <!--/покупки/продажи-->
		    
		    <div id="window2"> <!--ставки-->
				<form method="POST" action="" > 
	  				@csrf
			      <div id="okno2">
			        
			        <input type="hidden" name="date_offset_s" id="date_offset_s"/>
			        <input type="hidden" name="service_id" value="{{ $service->id }}" />
			        <input type="hidden" name="bidding_type" value="{{ $service->bidding_type }}" />
			        <input type="hidden" name="initiator" value="{{ isset(Auth::user()->id) ? Auth::user()->id : 0 }}" />
			        <!-- Цены аукционов -->
					@if($service->bidding_type == 4 || $service->bidding_type == 6)
						<?php 
							if(isset($service->price_lower)){
								if($service->price_lower > $service->price_current){
									$price_base = $service->price_lower;
								}else{$price_base = $service->price_current;}
							}
							if(isset($service->bet_step)){
								$step = $service->bet_step;
							}else{$step = 10;}
						?>	
						<input type="number" min="{{$service->price_base + $step}}" step="{{$step}}" name="price_fin" id="price_fin1" value="{{ $service->price_current + $service->bet_step}}" style="text-align: center; width: 50px;"/> грн
						<p></p>
						<button type="submit" class="btn btn-fefault cart">
							<i class="fa fa-gavel" aria-hidden="true"></i>
							@lang('pages.bid_auction')
						</button>
					@endif
					@if($service->bidding_type == 5 || $service->bidding_type == 7)
						<?php
							if(isset($service->bet_step)){
								$step = $service->bet_step;
							}else{$step = 10;}
						?>
						<input type="number" min="{{isset($service->price_lower) ? $service->price_lower : 20}}" max="{{ $service->price_current - $step}}" step="{{$step}}" name="price_fin" id="price_fin2" value="{{ $service->price_current - $step}}" style="text-align: center; width: 50px;"/> грн
						<p></p>
						<button type="submit" class="btn btn-fefault cart">
							<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
							@lang('pages.tender_bet')
						</button>
					@endif
			        &nbsp;
			        <a href="" class="close" >Cancel</a>
			        
			      </div>
		      
				</form>
		    </div> <!--/ставки-->
			@endif
			
			<div class="container">
				<div class="row">
					<div class="col-sm-4">

						<div class="mainmenu pull-left" id="menuHorizontal"> <!-- menuHorizontal -->
							<ul class="nav navbar-nav collapse navbar-collapse" >
								<li><a href="#window" class="active" >
									<!-- Выбор города -->
									@if(isset($city_id))
										{{ $city }}
									@elseif(isset($region_id))
										{{ $region }}
									@else
										@lang('layouts.choose_city')
									@endif
								</a></li>
								<li class="dropdown"><a href="#" >@lang('layouts.sections')<i class="fa fa-angle-down"></i></a>
                                    <!-- Выбор Раздела/Категории/Вида -->
                                    <ul role="menu" class="sub-menu">
                                        @foreach($sections as $section)
		                					<li><a href="{{route('section.show', $section->id)}}">{{$section->title}}</a>
		                						<ul role="menu" class="sub-menu">
		                							@foreach($categories->where('section_id', $section->id) as $category)
		                							<li><a href="{{route('category.show', $category->id)}}">{{$category->title}}</a>
		                								<ul role="menu" class="sub-menu">
		                									@foreach($kinds->where('category_id', $category->id) as $kind)
																<li><a href="{{ route('kind.edit', $kind->id) }}">{{$kind->title}}</a></li>
															@endforeach
		                								</ul>
		                							</li>
		                							@endforeach
		                						</ul>
		                					</li>
		              					@endforeach
                                    </ul>
                                </li>
							</ul>
						</div> <!-- /menuHorizontal -->
					</div>
					<div class="col-sm-8">
						<form method="POST" action="{{ route('services.req') }}" class="main-search">
							@csrf
							<div class="input-text-wrapper search_box">
								<input class="search_box" type="text" placeholder="@lang('layouts.search_box')" id="services_title" name="services_title" />
							</div>
							<select class="search-type-select" name="bidding_type" id="bidding_type">
								<option selected value="">- @lang('layouts.bidding_types') -</option>
								@foreach($bidding_types as $bidding_type)
									<option value="{{$bidding_type->id}}">{{$bidding_type->title}}</option>
								@endforeach
							</select>
							<input type='hidden' name='services_on_page' value='50' />
							<input type="hidden" name="date_offset_f" id="date_offset_f"/>
							<input class="search-btn" type="submit" value="Искать"/>
						</form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	
	
	<!--Уникальное содержимое страницы-->
    @yield('content')




	<footer id="footer"><!--Footer-->
		
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="companyinfo">
							<h2><span>Help</span>top</h2>
							<p>@lang('layouts.footer-top1')</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="companyinfo">
							<p>@lang('layouts.footer-top2')</p>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="companyinfo">
							<p>@lang('layouts.footer-top3')</p>
						</div>
					</div>
				</div>
			</div>
		</div>  <!-- /footer-top -->
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<!--<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>-->
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>@lang('layouts.where_to_begin')</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="/refer/6" >@lang('layouts.how_search')</a></li>
								<li><a href="/refer/7" >@lang('layouts.how_buy')</a></li>
								<li><a href="/refer/8" >@lang('layouts.how_sell')</a></li>
								<li><a href="/refer/9" >@lang('layouts.how_add')</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>@lang('layouts.regulations')</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="/refer/1" >@lang('layouts.agreement')</a></li>
								<li><a href="/refer/2" >@lang('layouts.personal_information')</a></li>
								<li><a href="/refer/3" >@lang('layouts.prohibited_services')</a></li>
								<li><a href="/refer/4" >@lang('layouts.tariffs')</a></li>
								<li><a href="/refer/5" >@lang('layouts.technical_breaks')</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>@lang('layouts.about_helptop')</h2> 
							<ul class="nav nav-pills nav-stacked">
								<li><a href="/refer/10">@lang('layouts.about_helptop')</a></li>
								<li><a href="/contacts" >@lang('layouts.contacts')</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<!--<h2>About Helptop</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>-->
						</div>
					</div>
					
				</div>
			</div>
		</div>  <!-- /footer-widget -->
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © {{date('Y')}} HELPTOP. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.helptop.com.ua">HELPTOP</a></span></p>
				</div>
			</div>
		</div>  <!-- /footer-bottom -->
		
	</footer><!--/Footer-->
	

  
    <script src="/js/pages/jquery.js"></script>
	<script src="/js/pages/bootstrap.min.js"></script>
	<script src="/js/pages/jquery.scrollUp.min.js"></script>
	<script src="/js/pages/price-range.js"></script>
    <script src="/js/pages/jquery.prettyPhoto.js"></script>
    <script src="/js/pages/main.js"></script>
    
    <!-- Получение часового пояса пользователя -->
	<script type="text/javascript">
		jQuery(document).ready(function($){
			var date_on = new Date();
			var offset = -1 * date_on.getTimezoneOffset() * 60;  /* Вычисление смещения часового пояса пользователя относительно 'UTC'.  На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */
			$("#date_offset").val(offset);
			$("#date_offset_s").val(offset);
			$("#date_offset_c").val(offset);
			$("#date_offset_p").val(offset);
			$("#date_offset_f").val(offset);
		});
	</script>
    
    <!-- Связанные списки областей, городов, районов -->
	<script type="text/javascript">
	    //Связанные списки областей, городов, районов
	    $('#region').change(function(){
	        var region = $(this).val();    
	        if(region){
	            $.ajax({
	               type:'GET',
	               url: "{{url('/kind/edit/getcities')}}?region="+region,
	               success:function(res){               
	                if(res){
	                    $("#city").empty();
	                    $("#district").empty();
	                    $("#city").append('<option value="">- выберете город -</option>');
	                    $.each(res,function(id, value){
	                        $("#city").append('<option value="'+value+'">'+value+'</option>');
	                    });

	                }else{
	                   $("#city").empty();
	                   $("#district").empty();
	                }
	               }
	            });
	        }else{
	            $("#city").empty();
	            $("#district").empty();
	        }      
	       });
	        
	        //Связанные списки городов и районов (разделить города с одинаковым названием), городов и улиц (когда город один в области)
	        $('#city').on('change',function(){
	        var city = $(this).val();    
	        var region = $("#region").val();    
	        if(city){
	            $.ajax({
	               type:"GET",
	               url:"{{url('/kind/edit/getdistricts')}}?city="+city+"&region="+region,
	               success:function(res){               
			            if(res[1]){
			                $("#district_all").css("display", "inline-block");
			                $("#district").empty();
			                $("#district").append('<option value="">- выберете район -</option>');
			                $.each(res,function(id,value){
			                    $("#district").append('<option value="'+value+'">'+value+'</option>');
			                });

			                }
		               } //end success:function(res)
		            });
		        }else{
		            $("#district").empty();
		            $("#district").val('');
		            $("#district_all").css("display", "none");
		        }
	       	}); //end  $('#city').on
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
		$('#number_unit1').forceNumbericOnly();
		$('#number_unit2').forceNumbericOnly();
		$('#price_fin1').forceNumbericOnly();
		$('#price_fin2').forceNumbericOnly();
	});
</script>
    
    <!--Вставка индивидуальных скриптов страницы-->
    @stack('scripts')
    
</body>
</html>
