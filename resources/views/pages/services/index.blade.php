@push('styles')

	<!--Форматирование списков и календаря-->
	<link href="/css/admin1.css" rel="stylesheet">
	<link href="/css/pages/main.css" rel="stylesheet">
	<!-- Скрытие фрагментов на странице -->
	<style>
		#district_all, #code_un, #date_un, #price_all, #price_f, #price_s, #price_type {
			display: none;
		}

	</style>
@endpush


@extends('layouts.app_asi')

@section('content')
	<section >
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Путь -->
					<div class="breadcrumbs">
						<ol class="breadcrumb">
						  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
						  @if(isset($section_id))
						  <li><a href="{{ route('section.show', $section_id) }}">{{ $section_title }}</a></li>
						  @endif
						  @if(isset($category_id))
						  <li><a href="{{ route('category.show', $category_id) }}">{{ $category_title }}</a></li>
						  @endif
						  @if(isset($bidding_id))
						  	@if(isset($kind_id))
							  <li><a href="{{ route('kind.edit', $kind_id) }}">{{ $kind_title }}</a></li>
							@endif
						  	<li class="active"> > {{$bidding_title}}</li>
						  @else
						  	@if(isset($kind_id))
							  <li class="active">{{ $kind_title }}</li>
							@endif
						  @endif
						  @if(isset($bidding_bs))
							  <li class="active">
								@if($bidding_bs == 22)
									@lang('layouts.bidding_22')
								@endif
								@if($bidding_bs == 23)
									@lang('layouts.bidding_23')
								@endif
							  </li>
						  @endif
						  @if(isset($status))
			                <li class="active">
			                    {{ $status }}
			                </li>
			             @endif
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	<section id="cart_items" >

		
		<div class="container">
			<div class="row">

				@if(isset($status))
	                <div class="alert alert-info">
	                    {{ $status }}
	                </div>
	            @endif
				<div class="col-sm-9 padding-right">
					<!-- Реклама-->
					<?php if(isset($servicesLid)){foreach($servicesLid as $service){if($id = $service->id){	}	};} ?>
					<?php if(isset($servicesMid)){foreach($servicesMid as $service){if($id = $service->id){	}	};} ?>
					@if(isset($id))
						<div class="order-message">
							<label>@lang('pages.advertising')</label>
						</div>
					@endif
					<!-- Объявления Lider пакета-->
					<?php $countLid = 0; ?>
					<div class="features_items">  <!-- Объявления Lider пакета-->
						@if(isset($servicesLid))
						@foreach($servicesLid as $service)
							<?php $countLid++ ?>
							@if($countLid == 4 || $countLid > 4)
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
						@endif
					</div>  <!-- /Объявления Lider пакета-->

					<!-- Объявления Middle пакета-->
					<?php $countMid = 0; ?>
					<div class="features_items">  <!-- Объявления Middle пакета-->
						@if(isset($servicesMid))
						@foreach($servicesMid as $service)
							<?php $countMid++ ?>
							@if($countMid == 4 || $countMid > 4)
								@break
							@endif
							
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="{{ route('service.show', $service->id) }}"class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
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
											
											
											
										</div>
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
						@endif
					</div>  <!-- /Объявления Middle пакета-->
					
					<!-- Обычные объявления -->
					<?php foreach($services as $service){if($idS = $service->id){	}	} ?>
					<div class="order-message">
					@if(isset($idS))
						<label>@lang('pages.оrdinary_ads')</label>
					@else
						<label style="font-weight:bold;">@lang('pages.no_results_request')...</label>
						<p>&nbsp;</p>
					@endif
					</div>
					
					<div class="features_items">
					<?php $count = 0; ?>
					@foreach($services as $service)
						<?php $count++ ?>
						@if($count % 3 == 1)
							</div>
							<div class="features_items">
						@endif
					
					<div class="col-sm-4" >
						<div class="product-image-wrapper" <?php if(null != $service->blurb_type_id) echo 'style="background-color: #b1feb9; "' ?> >
							<div class="single-products">
								<div class="productinfo text-center" >
									<a href="{{ route('service.show', $service->id) }}" class="view-product"><img src="{{ $service->getImage() }}" alt="" style="max-width: 230px; max-height: 230px" />
									@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6 || $service->bidding_type == 102)
										<h3 style="color: #030303">@lang('pages.buy_one')</h3>
									@else
										<h3 style="color: #030303">@lang('pages.sell_the_service')</h3>
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
									
									
								</div>
							</div>
							<div class="choose" >
								<ul class="nav nav-pills nav-justified" >
									<li ><a href="<?php if(isset($service->user_id)) echo  route('ratings.show', $service->user_id) ?>" >
										@lang('pages.rating'):
										<p style="margin-bottom:0px; color: #F49925"><?php if(isset($service->user_id)) echo $service->ratingView($service->user_id) ?></p>
									</a></li>
									<li ><a href="#"><i class="fa fa-map-marker "></i>
										
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
									<li ><a href="#" >
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
					</div>  <!-- /"features_items" -->


					
				<div>
					<form method="POST" action="{{ route('services.req_offset') }}" > 
	  					@csrf
						<!--Передача данных для отображения со следующими услугами-->
						<?php if(isset($services_title)) echo "<input type='hidden' name='services_title' value='$services_title' />" ?>
						<?php if(isset($in_content)) echo "<input type='hidden' name='in_content' value='$in_content' />" ?>
						<?php if(isset($product_code_id)) echo "<input type='hidden' name='product_code_id' value='$product_code_id' />" ?>
						<?php if(isset($section_id)) echo "<input type='hidden' name='section_id' value='$section_id' />" ?>
						<?php if(isset($section_title)) echo "<input type='hidden' name='section_title' value='$section_title' />" ?>
						<?php if(isset($category_id)) echo "<input type='hidden' name='category_id' value='$category_id' />" ?>
						<?php if(isset($category_title)) echo "<input type='hidden' name='category_title' value='$category_title' />" ?>
						<?php if(isset($kind_id)) echo "<input type='hidden' name='kind_id' value='$kind_id' />" ?>
						<?php if(isset($kind_title)) echo "<input type='hidden' name='kind_title' value='$kind_title' />" ?>
						<?php if(isset($bidding_id)) echo "<input type='hidden' name='bidding_id' value='$bidding_id' />" ?>
						<?php if(isset($bidding_title)) echo "<input type='hidden' name='bidding_title' value='$bidding_title' />" ?>
						<?php if(isset($date_on_start)) echo "<input type='hidden' name='date_on_start' value='$date_on_start' />" ?>
						<?php if(isset($date_on_end)) echo "<input type='hidden' name='date_on_end' value='$date_on_end' />" ?>
						<?php if(isset($date_off_start)) echo "<input type='hidden' name='date_off_start' value='$date_off_start' />" ?>
						<?php if(isset($date_off_end)) echo "<input type='hidden' name='date_off_end' value='$date_off_end' />" ?>
						<?php if(isset($price_f_min)) echo "<input type='hidden' name='price_f_min' value='$price_f_min' />" ?>
						<?php if(isset($price_f_max)) echo "<input type='hidden' name='price_f_max' value='$price_f_max' />" ?>
						<?php if(isset($price_s_min)) echo "<input type='hidden' name='price_s_min' value='$price_s_min' />" ?>
						<?php if(isset($price_s_max)) echo "<input type='hidden' name='price_s_max' value='$price_s_max' />" ?>
						<?php if(isset($region)) echo "<input type='hidden' name='region' value='$region' />" ?>
						<?php if(isset($city)) echo "<input type='hidden' name='city' value='$city' />" ?>
						<?php if(isset($district)) echo "<input type='hidden' name='district' value='$district' />" ?>
						<?php if(isset($services_on_page)) echo "<input type='hidden' name='services_on_page' value='$services_on_page' />" ?>
						<?php if(isset($bidding_bs)) echo "<input type='hidden' name='bidding_bs' value='$bidding_bs' />" ?>
						<input type="hidden" name="date_offset_c" id="date_offset_c"/>
						&nbsp;
						@if(isset($idS) && $count > $services_on_page - 1)
							<button type="submit" class="btn1" style="align:center;">
				            	@lang('pages.display_next') 
				            	{{ isset($services_on_page) ? $services_on_page : 50 }} 
				            	@lang('pages.services') >>
				        	</button>
						@endif
						
						
					</form>
				</div>
				
					
				</div> <!-- /col-sm-9 padding-right -->
				
				<!--left-sidebar-->
				<div class="col-sm-3"> <!--left-sidebar-->
					<!--left-sidebar-->
					@include('layouts._sidebar_find')
				</div>  <!--/left-sidebar-->
				
			</div>
		</div>
	</section>
@endsection


@push('scripts')

	


<!--Форматирование списков и календаря-->
<script src="/js/admin1.js"></script>
<script src="/js/pages/bootstrap.min.js"></script>


<!-- Связанные списки разделов и категорий -->
<script type="text/javascript">
    $('#section_id').change(function(){
        var sectionID = $(this).val();    
        //var kindID = $("#kind_id_hidden").val();    
        if(sectionID){
            
            $.ajax({
               type:'GET',
               url: "{{url('/kind/edit/getcat')}}?section_id="+sectionID,
               success:function(res){               
                if(res){
                    $("#category_id").empty();
                    $("#kind_id").empty();
                    $("#category_id").append('<option value="">- выберете категорию -</option>');
                    $.each(res,function(key,value){
                        $("#category_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#category_id").empty();
                   $("#kind_id").empty();
                }
               }
            });
        }else{
            $("#category_id").empty();
            $("#kind_id").empty();
        }      
       });
        
        $('#category_id').on('change',function(){
        var categoryID = $(this).val();    
        if(categoryID){
            $.ajax({
               type:"GET",
               url:"{{url('/kind/edit/getkind')}}?category_id="+categoryID,
               success:function(res){               
                if(res){
                    $("#kind_id").empty();
                    $("#kind_id").append('<option value="">- выберете вид услуг -</option>');
                    $.each(res,function(key,value){
                        $("#kind_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                   $("#kind_id").empty();
                }
               }
            });
        }else{
            $("#kind_id").empty();
        }

       });
</script>

<!-- Подключение jQuery плагина Masked Input -->
<script src="/js/jquery.maskedinput.min.js"></script>
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
		$('#price_f_min').forceNumbericOnly();
		$('#price_f_max').forceNumbericOnly();
		$('#price_s_min').forceNumbericOnly();
		$('#price_s_max').forceNumbericOnly();
	});

	/**
	* Маска ввода товарного кода услуги
	* 
	* плагин: jquery.maskedinput.min.js
	* Цифра 9 – соответствует цифре от 0 до 9.
	* Символ a – представляет собой любой английский символ (A-Z, a-z).
	* Знак * - представляет собой любой алфавитно-цифровой символ (A-Z, a-z, 0-9).
	*
	* задание заполнителя с помощью параметра placeholder
	* $("#date").mask("99.99.9999", {placeholder: "дд.мм.гггг" });
	*
	* https://itchief.ru/lessons/javascript/input-mask-for-html-input-element
	*/
  	$(function(){
	  //Получить элемент, к которому необходимо добавить маску
	  $("#product_code").mask("999999-9999");
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

<!-- Деактивация остальных полей при вводе товарного кода услуги -->
<script type="text/javascript">
	$('#product_code_id').change(function(){
        var productCodeID = $(this).val();    
        if(productCodeID){
			$("#code_un").css("display", "inline-block");
            
            $("#services_title").empty();	// Очистка инпута
            $("#in_content").empty();
            $("#availability").empty();
            $("#terms_payment").empty();
            $("#section_id").empty();
            $("#category_id").empty();
            $("#kind_id").empty();
            $("#datepicker").empty();
            $("#datepicker1").empty();
            $("#bidding_type").empty();
            $("#price_min").empty();
            $("#price_max").empty();
            $("#region").empty();
            $("#city").empty();
            $("#district").empty();
            
            $("#services_title").val('');
            $("#availability").val('');
            $("#terms_payment").val('');
            $("#section_id").val('');
            $("#category_id").val('');
            $("#kind_id").val('');
            $("#datepicker").val('');
            $("#datepicker1").val('');
            $("#bidding_type").val('');
            $("#price_min").val('');
            $("#price_max").val('');
            $("#region").val('');
            $("#city").val('');
            $("#district").val('');
            
            $("#services_title").prop("disabled", true);  // Блокировка инпута
            $("#in_content").prop("disabled", true);
            $("#availability").prop("disabled", true);
            $("#terms_payment").prop("disabled", true);
            $("#section_id").prop("disabled", true);
            $("#category_id").prop("disabled", true);
            $("#kind_id").prop("disabled", true);
            $("#datepicker").prop("disabled", true);
            $("#datepicker1").prop("disabled", true);
            $("#bidding_type").prop("disabled", true);
            $("#price_min").prop("disabled", true);
            $("#price_max").prop("disabled", true);
            $("#region").prop("disabled", true);
            $("#city").prop("disabled", true);
            $("#district").prop("disabled", true);
        }
        if(productCodeID == ''){
			$("#services_title").prop("enabled", true);   // Разблокировка инпута 
            $("#in_content").prop("enabled", true);
            $("#availability").prop("enabled", true);
            $("#terms_payment").prop("enabled", true);
            $("#section_id").prop("enabled", true);
            $("#category_id").prop("enabled", true);
            $("#kind_id").prop("enabled", true);
            $("#datepicker").prop("enabled", true);
            $("#datepicker1").prop("enabled", true);
            $("#bidding_type").prop("enabled", true);
            $("#price_min").prop("enabled", true);
            $("#price_max").prop("enabled", true);
            $("#region").prop("enabled", true);
            $("#city").prop("enabled", true);
            $("#district").prop("enabled", true);
		}
    });
    
 
	//Если при обновлении страницы в инпуте товарного кода есть содержимое - блокировать остальные поля
	jQuery(document).ready(function($){
		var $d = $('#product_code_id');
		if($d.val()) {
			$("#code_un").css("display", "inline-block");
			
			$("#services_title").empty();	// Очистка инпута
            $("#in_content").empty();
            $("#availability").empty();
            $("#terms_payment").empty();
            $("#section_id").empty();
            $("#category_id").empty();
            $("#kind_id").empty();
            $("#datepicker").empty();
            $("#datepicker1").empty();
            $("#bidding_type").empty();
            $("#price_min").empty();
            $("#price_max").empty();
            $("#region").empty();
            $("#city").empty();
            $("#district").empty();
            
            $("#services_title").val('');
            $("#availability").val('');
            $("#terms_payment").val('');
            $("#section_id").val('');
            $("#category_id").val('');
            $("#kind_id").val('');
            $("#datepicker").val('');
            $("#datepicker1").val('');
            $("#bidding_type").val('');
            $("#price_min").val('');
            $("#price_max").val('');
            $("#region").val('');
            $("#city").val('');
            $("#district").val('');
            
            $("#services_title").prop("disabled", true);  // Блокировка инпута
            $("#in_content").prop("disabled", true);
            $("#availability").prop("disabled", true);
            $("#terms_payment").prop("disabled", true);
            $("#section_id").prop("disabled", true);
            $("#category_id").prop("disabled", true);
            $("#kind_id").prop("disabled", true);
            $("#datepicker").prop("disabled", true);
            $("#datepicker1").prop("disabled", true);
            $("#bidding_type").prop("disabled", true);
            $("#price_min").prop("disabled", true);
            $("#price_max").prop("disabled", true);
            $("#region").prop("disabled", true);
            $("#city").prop("disabled", true);
            $("#district").prop("disabled", true);
		}
	});



</script>

<!-- Показ предупреждений о корректности выбора дат публикации услуги в запросе -->
<script type="text/javascript">
	//Перевод вводимого в input значения даты в формат, допустимый в JAVA
	function formatDate(value){
		var date = "20" + value[6] + value[7] + ", " + value[3] + value[4] + ", " + value[0] + value[1];
		return date;
	}
	
	//Проверка корректности заданных в запросе дат начала и окончатня публикации услуги
	function compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end){
		if($date_on_start > $date_on_end || $date_off_start > $date_off_end || $date_off_start < $date_on_start || $date_off_end < $date_on_end || $date_off_start < $date_on_end || $date_off_end < $date_on_start){
			$("#date_un").css("display", "inline-block");
		}else{
			$("#date_un").css("display", "none");
		}
	}
    
    jQuery(document).ready(function($){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
    
    $('#datepicker').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
    $('#datepicker1').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
	$('#datepicker2').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
	$('#datepicker3').change(function(){
		var $date_on_start = new Date(formatDate($("#datepicker").val()));
		var $date_on_end = new Date(formatDate($("#datepicker1").val()));
		var $date_off_start = new Date(formatDate($("#datepicker2").val()));
		var $date_off_end = new Date(formatDate($("#datepicker3").val()));
		compareDates($date_on_start, $date_on_end, $date_off_start, $date_off_end);
	});
</script>

<!-- Проверка типа аукциона и приведние страницы в соответствие с ним -->
<script type="text/javascript">
		jQuery(document).ready(function($){
			var BID = $("#bidding_type").val();
			var BID_H = $("#bidding_type_h").val();
			if(BID){
				switch (BID) {
				  case '2':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '3':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '4':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '5':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '6':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '7':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  default:
				    break;
				}
				$("#bidding_bs").empty();
				$("#bidding_bs_h").empty();
            	$("#bidding_bs").val(null);
            	$("#bidding_bs_h").val(null);
            	$("#bidding_bs").prop("disabled", true);  // Блокировка инпута
            	$("#bidding_bs_h").prop("disabled", true);  // Блокировка инпута
			}else{
				$("#price_f").css("display", "none");
				$("#price_s").css("display", "inline-block");
				$("#bidding_bs").prop("enabled", true);  // Разблокировка инпута
            	$("#bidding_bs_h").prop("enabled", true);  // Разблокировка инпута
				
			}
			if(BID_H){
				switch (BID_H) {
				  case '2':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '3':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '4':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '5':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '6':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '7':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  default:
				    break;
				}
				$("#bidding_bs").empty();
				$("#bidding_bs_h").empty();
            	$("#bidding_bs").val(null);
            	$("#bidding_bs_h").val(null);
            	$("#bidding_bs").prop("disabled", true);  // Блокировка инпута
            	$("#bidding_bs_h").prop("disabled", true);  // Блокировка инпута
			}
		});
		
		
		$('#bidding_type').change(function(){
			var biddingID = $(this).val();
			
			$("#price_f").css("display", "none");
			$("#price_s").css("display", "none");
		
			if(biddingID){
				switch (biddingID) {
				  case '2':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '3':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "none");
				    break;
				  case '4':

				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '5':
				    $("#price_f").css("display", "none");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '6':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  case '7':
				    $("#price_f").css("display", "inline-block");
				    $("#price_s").css("display", "inline-block");
				    break;
				  default:
				    break;
				}
				$("#bidding_bs").empty();
				$("#bidding_bs_h").empty();
            	$("#bidding_bs").val(null);
            	$("#bidding_bs_h").val(null);
            	$("#bidding_bs").prop("disabled", true);  // Блокировка инпута
            	$("#bidding_bs_h").prop("disabled", true);  // Блокировка инпута
			}else{
				$("#price_f").css("display", "none");
				$("#price_s").css("display", "inline-block");
				$("#bidding_bs").prop("enabled", true);  // Разблокировка инпута
            	$("#bidding_bs_h").prop("enabled", true);  // Разблокировка инпута
			}
		
	});
</script>

<!-- Проверка условия "купить/продать" и блокирование поля типа торгов -->
<script type="text/javascript">
		jQuery(document).ready(function($){
			var BBID = $("#bidding_bs").val();
			var BBID_H = $("#bidding_bs_h").val();
			if(BID){
				$("#bidding_type").empty();
				$("#bidding_type_h").empty();
            	$("#bidding_type").val(null);
            	$("#bidding_type_h").val(null);
            	$("#bidding_type").prop("disabled", true);  // Блокировка инпута
            	$("#bidding_type_h").prop("disabled", true);  // Блокировка инпута
			}else{
				$("#bidding_type").prop("enabled", true);  // Разблокировка инпута
            	$("#bidding_type_h").prop("enabled", true);  // Разблокировка инпута
			}
			if(BBID_H){
				$("#bidding_type").empty();
				$("#bidding_type_h").empty();
            	$("#bidding_type").val(null);
            	$("#bidding_type_h").val(null);
            	$("#bidding_type").prop("disabled", true);  // Блокировка инпута
            	$("#bidding_type_h").prop("disabled", true);  // Блокировка инпута
			}
		});
		
		
		$('#bidding_bs').change(function(){
			var biddingBS = $(this).val();
			if(biddingBS){
				$("#bidding_type").empty();
				$("#bidding_type_h").empty();
            	$("#bidding_type").val(null);
            	$("#bidding_type_h").val(null);
            	$("#bidding_type").prop("disabled", true);  // Блокировка инпута
            	$("#bidding_type_h").prop("disabled", true);  // Блокировка инпута
			}else{
				$("#bidding_type").prop("enabled", true);  // Разблокировка инпута
            	$("#bidding_type_h").prop("enabled", true);  // Разблокировка инпута
			}
		
	});
</script>

<!-- Проверка соответствия диапазонов цен -->
<script type="text/javascript">
   //Функция сравнения минимальной и максимальной цен
   function comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max){
   		if((($price_f_max - $price_f_min < 0) && $price_f_max && $price_f_min) || (($price_s_max - $price_s_min < 0) && $price_s_max && $price_s_min)){
			$("#price_all").css("display", "inline-block");
		}else{
			$("#price_all").css("display", "none");
		}
   }
   function priceInfo(){
   		if(!$("#bidding_type").val()){
			$("#price_type").css("display", "inline-block");
		}else{
			$("#price_type").css("display", "none");
		}
   }
   
   jQuery(document).ready(function($){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
	});
    
    $('#price_f_min').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#price_f_max').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#price_s_min').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#price_s_max').change(function(){
		var $price_f_min = $("#price_f_min").val();
		var $price_f_max = $("#price_f_max").val();
		var $price_s_min = $("#price_s_min").val();
		var $price_s_max = $("#price_s_max").val();
		comparePrices($price_f_min, $price_f_max, $price_s_min, $price_s_max);
		priceInfo();
	});
	$('#bidding_type').change(function(){
		priceInfo();
	});
</script>

@endpush
