@push('styles')

	<!--Форматирование списков и календаря-->
	<link href="/css/admin1.css" rel="stylesheet">
	<link href="/css/pages/main.css" rel="stylesheet">
	<!-- Скрытие фрагментов на странице -->
	<style>
		#district_all, #code_un, #date_un, #price_all, #price_f, #price_s, #price_type {
			display: none;
		}
		
		#not_enough_date, #not_enough_blurb, #not_public {
			display: none;
		}

	</style>
@endpush


@extends('layouts.app_s')

@section('content')
	
	@if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && $service->blurb_type_id == null && $service->status == 1)
	<!--Рекламировать-->
	<div id="window5"> <!--Рекламировать-->
	    <div id="okno5">
		      <form method="POST" action="{{ route('blurbs.store') }}" > 
			  @csrf
			  <input type="hidden" name="_method" value="POST">
			  <!--Передача цен на рекламу и периодов рекламы в JavaScript-->
		        <input type="hidden" id="blurb_prises" name="blurb_prises" value="{{ $blurb_prises }}"  />
		        <input type="hidden" id="blurb_periods" name="blurb_periods" value="{{ $blurb_periods }}"  />
		        <!--Передача баланса счета пользователя в JavaScript-->
		        <input type="hidden" id="balance0" name="balance0" value="{{ $balance0 }}"  />
		        <!--Передача даты окончания публикации услуги в JavaScript-->
		        <input type="hidden" name="date_off" id="date_off" value="{{ $date_off_str }}" >
		        
		        <!--Передача периодов предоставления рекламы, ID пользователя и услуги-->
		        <input type="hidden" id="date_on_blurb" name="date_on_blurb" />
		        <input type="hidden" id="date_off_blurb" name="date_off_blurb" />
		        <input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}" />
		        <input type="hidden" id="service_id" name="service_id" value="{{ $service->id }}" />
	      
				<p>&nbsp;</p>
				<div style="text-align: left" class="col-md-12">
					Выберите один из рекламных пакетов
					<p></p>
					<div class="col-sm-7">
						<label>Название</label>
						<select class="form-control select2" name="blurb_type_id" id="blurb_type_id" style="width: 100%;" >
			              	<option value="">- выберите рекламный пакет -</option>
			              	@foreach($blurb_types as $blurb_type)
		                		<option value="{{$blurb_type->id}}">{{$blurb_type->title}}</option>
		              		@endforeach
			            </select>
					</div>
					
					<div class="col-sm-2">
						<label>Период</label>
						<input type="text" id="period_blurb" name="period_blurb" style="width: 50px; text-align: center;" disabled />
						дней
					</div> 
					
					<div class="col-sm-3">
						<label>Стоимость</label>
						<input type="text" id="price_blurb" name="price_blurb" style="width: 50px; text-align: center;" disabled />
						грн
					</div> 
		        </div> <!-- end "col-md-12" -->
			<div class="col-md-12">
	        	<hr /> <!-- горизонтальная линия -->
	        </div>  <!-- end "col-md-12" -->
			
			<p>&nbsp;</p>
	        <div class="col-sm-12">	
	        	<div class="col-sm-4">
	        		<a href="" class="close" >Cancel</a>  
	        	</div>
	        	<div class="col-sm-6" id="allow_public">
		        	<button type="submit" class="btn btn-default cart">
						<i class="fa fa-rss"></i> Рекламировать
					</button>
				</div>
				<div class="col-sm-6" id="not_public">
		        	<a class="btn btn-default cart" href="{{ route('scores.index') }}">
						<i class="fa fa-credit-card"></i> Пополнить счет
					</a>
				</div>
	        </div>
	        <div class="col-md-12 alert alert-danger" id="not_enough_date">
	        	Конечная дата рекламирования услуги больше конечной даты публикации услуги!
	        </div>
	        <div class="col-md-12 alert alert-danger" id="not_enough_blurb">
	        	На балансе не достаточно средств для использования выбранной рекламной опции!
	        </div>
	        </form>
		</div>
	</div> <!--/Рекламировать-->
	@endif
	
	<section >
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Путь -->
					<div class="breadcrumbs">
						<ol class="breadcrumb">
						  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
						  <li><a href="{{ route('section.show', $service->section_id) }}">{{ $service->getSectionTitle() }}</a></li>
						  <li><a href="{{ route('category.show', $service->category_id) }}">{{ $service->getCategoryTitle() }}</a></li>
						  <li><a href="{{ route('kind.edit', $service->kind_id) }}">{{ $service->getKindTitle() }}</a></li>
						  <li class="active">{{ $service->title }}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	<section id="cart_items" >
			
		<div class="container">
			@if(session('status'))
                <div class="alert alert-info">
                    {{session('status')}}
                </div>
            @endif
			<div class="row">
				@if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && ($service->status != 1 || $service->blurb_type_id == null))
					<div class="col-sm-12">
				        <div class="col-sm-4"></div>
				        @if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && $service->blurb_type_id == null && $service->status == 1)
					        <div class="col-sm-4">
					        	<a href="#window5" class="btn1 pull-right">
						  			<i class="fa fa-magnet"></i>&nbsp;&nbsp;
						  			Рекламировать услугу
						  		</a>
							</div>
						@endif
						<div class="col-sm-4">
							@if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && $service->status != 1)
								@if($service->bidding_type % 2 == 0)
							  		<a href="{{route('service.mysell.edit', $service->id)}}" class="btn1 pull-right">
							  			<i class="fa fa-gavel"></i>&nbsp;&nbsp;
							  			Редактировать - Опубликовать услугу
							  		</a>
							  	@elseif($service->bidding_type % 2 != 0)
							  		<a href="{{route('service.mybuy.edit', $service->id)}}" class="btn1 pull-right">
							  			<i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;
							  			Редактировать - Опубликовать услугу
							  		</a>
							    @endif
							@endif
						</div>
			        </div>
			    @endif
			    
		    	@if($service->status != 1)
		        	<h2 style="text-align: center; color:#707870;">Данная услуга находится в архиве (не активна)</h2>
		        @endif
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{ $service->getImage() }}" alt="" />
								@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6  || $service->bidding_type == 102)
									<h3>@lang('pages.buy_one')</h3>
								@else
									<h3>@lang('pages.sell_the_service')</h3>
								@endif
							</div>
							

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<h2>{{ $service->title }}</h2>
								<p style="display: inline;">@lang('pages.service_code'): &nbsp;  <div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;">{{substr($service->product_code_id, 0, 6) . '-' . substr($service->product_code_id, 6, 4)}}</div></p>
								
								<span >
									<!-- Цены аукционов -->
									@if($service->bidding_type == 4 || $service->bidding_type == 6)
										<span>{{ $service->price_current }} грн</span>
										@if($service->status == 1)	
											<a href="#window2" class="btn btn-default cart" <?php if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id) echo 'disabled' ?>>
												<i class="fa fa-gavel" aria-hidden="true"></i>
												@lang('pages.bid_auction')
											</a>
										@endif
									@endif
									@if($service->bidding_type == 5 || $service->bidding_type == 7)
										<span>{{ $service->price_current }} грн</span>
										@if($service->status == 1)
											<a href="#window2" class="btn btn-default cart" <?php if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id) echo 'disabled' ?>>
												<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
												@lang('pages.tender_bet')
											</a>
										@endif
									@endif
									<p>&nbsp;</p>
									<!-- Цены фиксированных торгов -->
									@if($service->bidding_type == 2 || $service->bidding_type == 6)
										<span>{{ $service->price_buy_now }} грн</span>
										@if($service->number_total > 1)
											<label>@lang('pages.quantity'):</label>
											<input type="text" value="{{$service->number_total}}" disabled/>
										@endif
										@if($service->status == 1)
											<a href="#window1" class="btn btn-default cart" <?php if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id) echo 'disabled' ?>>
												<i class="fa fa-shopping-cart" aria-hidden="true"></i>
												@lang('pages.buy_now')
											</a>
										@endif
									@endif
									@if($service->bidding_type == 3 || $service->bidding_type == 7)
										<span>{{ $service->price_sell_now }} грн</span>
										@if($service->number_total > 1)
											<label>@lang('pages.quantity'):</label>
											<input type="text" value="{{$service->number_total}}" disabled/>
										@endif
										@if($service->status == 1)
											<a href="#window1" class="btn btn-default cart" <?php if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id) echo 'disabled' ?>>
												<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
												@lang('pages.sell_now')
											</a>
										@endif
									@endif
									
									<!--Реклама Helptop-->
									@if($service->bidding_type == 102)
										@if($service->status == 1)	
											<a href="{{route('service.mysell.create')}}" class="btn btn-default cart" >
												<i class="fa fa-gavel" aria-hidden="true"></i>
												Создать новую услугу Продажи
											</a>
										@endif
									@endif
									@if($service->bidding_type == 103)
										@if($service->status == 1)	
											<a href="{{route('service.mybuy.create')}}" class="btn btn-default cart" >
												<i class="fa fa-bar-chart-o" aria-hidden="true"></i>
												Создать новую заявку на Покупку услуги
											</a>
										@endif
									@endif
									<!--/Реклама Helptop-->
								</span>
								
								<!-- Краткое описание -->
								<p><b>@lang('pages.description'):</b> &nbsp;<?php echo $service->ServiceDesc->description ?></p>
								<p><b><a href="#">
									<i class="fa fa-calendar"></i>
									@lang('pages.date_off_bidding'):</b>&nbsp;
									{{$service->getDateAttribute($service->date_off, $date_offset)}}
								</a></p>
								<p><b> 
									<i class="fa fa-clock-o"></i>
									@if($service->bidding_type == 2 || $service->bidding_type == 4 || $service->bidding_type == 6)
										@lang('pages.get_service'):</b>&nbsp;
									@else
										@lang('pages.provide_service'):</b>&nbsp;
									@endif
									@lang('pages.in') 
									<b style="color:#000000;">{{ $service->distance->period_initial }} - {{ $service->distance->period_deadline }}</b>
									@lang('pages.days')
								</p>
								<p>
									<div class="col-sm-6">
										<a href="{{ route('ratings.show', $service->user_id) }}" >
											<b>@lang('pages.rating'):</b>&nbsp;
												<?php echo $service->ratingView($service->user_id) ?>
										</a>
									</div>
									<div class="col-sm-6">
										@if(isset(Auth::user()->id) && Auth::user()->id != $service->user_id)
											<a href="#window6" style="border: 1px solid #3c42c4; padding: 1px 3px 1px 3px; ">Написать автору</a>
										@else
											&nbsp;&nbsp;&nbsp;&nbsp;
										@endif
									</div>
									
								</p>
								<p style="margin: 0px; padding: 0px" >&nbsp;</p>
								<p>
									<div class="col-sm-6">
										@lang('pages.user'):
										<a href="" title="{{ isset($service->author->firm) ? $service->author->firm : '' }}">
											<b>{{ $service->author->name }}</b>
										</a>
									</div>
									<div class="col-sm-6">
										@if(isset(Auth::user()->id) && Auth::user()->id != $service->user_id || !isset(Auth::user()->id))
											<a href="{{ route('services.showuservice', $service->user_id) }}" style="border: 1px solid #3c42c4; padding: 1px 3px 1px 3px; ">Все услуги автора</a>
										@else
											&nbsp;&nbsp;&nbsp;&nbsp;
										@endif
									</div>
								</p>
								<p style="margin: 0px; padding: 0px" >&nbsp;</p>
								<p><b>
									<i class="fa fa-map-marker "></i>
									@lang('pages.service_provided'):</b>&nbsp;
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
								</p>
								<p>
									<b>@lang('pages.primary_address_service'):</b>&nbsp;
									@if($service->getRegion())
										{{ $service->getRegion() }} @lang('pages.region'), 
									@endif
									@if($service->getCity())
										{{ $service->getCity() }}, 
									@endif
									@if($service->getDistrict())
										{{ $service->getDistrict() }} @lang('pages.district'),
									@endif
									@if($service->getStreet())
										{{ $service->getStreet() }},
									@endif
									@if($service->getHouse())
										@lang('pages.house') {{ $service->getHouse() }}
									@endif
								</p>
								<p><a href="" title="@lang('pages.scalable_service_title')">
									@if($service->getScalable())
										<b><i class="fa fa-external-link "></i>
										@lang('pages.scalable_service')</b>
									@endif
									</a>
									&nbsp; &nbsp; &nbsp; &nbsp;
									<a href="" title="@lang('pages.expandable_service_title')">
									@if($service->getExpandable())
										<b><i class="fa fa-plus-square "></i>
										@lang('pages.expandable_service')</b>
									@endif
									</a>
								</p>
								<p>
									<b title="@lang('pages.service_availability_title')">
										@lang('pages.service_availability'):</b>&nbsp;
				              			@if($service->getAvailability())
					              			@if($service->getAvailability() == 1)
											    <i class="fa fa-bolt "></i>
											    @lang('pages.available')
											@endif
											@if($service->getAvailability() == 2)
											    <i class="fa fa-truck "></i>
											    @lang('pages.to_order')
											@endif
										@endif
								</p>
								<p><a href="">
									<b title="@lang('pages.terms_payment_title')">
										<i class="fa fa-money "></i> 
										@lang('pages.terms_payment'):</b>&nbsp;
				              			@if($service->getTermsPayment())
					              			@if($service->getTermsPayment() == 1)
											    @lang('pages.prepayment')
											@endif
											@if($service->getTermsPayment() == 2)
											    @lang('pages.payment_after')
											@endif
											@if($service->getTermsPayment() == 3)
											    @lang('pages.prepaid_expense')
											@endif
											@if($service->getTermsPayment() == 4)
											    @lang('pages.phased_payment')
											@endif
											@if($service->getTermsPayment() == 5)
											    @lang('pages.any_payment_method')
											@endif
										@endif
								</a></p>
								
								
								
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#content" data-toggle="tab">@lang('pages.content')</a></li>
								<li><a href="#result" data-toggle="tab">@lang('pages.result_receiving_service')</a></li>
								<li><a href="#scope" data-toggle="tab">@lang('pages.scope_and_structure')</a></li>
								@if($service->getTermsProvision() || $service->getAddTerms())
									<li ><a href="#additional_terms" data-toggle="tab">@lang('pages.additional_terms')</a></li>
								@endif
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="content" > <!--content-->
								<div class="col-sm-9">
									<?php echo $service->getContent() ?>
								</div>
								<div class="col-sm-3">
									@if($service->getDuration())
										<b>@lang('pages.duration')</b>:&nbsp;<p></p>
										<?php echo $service->getDuration() ?>
										@lang('pages.hours')
									@endif
									<p>&nbsp;</p>
									@if($service->getPeriodSchedule())
										<b>@lang('pages.schedule')</b>:<p></p>
										<?php echo $service->getPeriodSchedule() ?>
									@endif
								</div>
							</div> <!--/content-->
							
							<div class="tab-pane fade" id="result" > <!--result-->
								<div class="col-sm-3">
									<?php echo $service->getResult() ?>
								</div>
							</div> <!--/result-->
							
							<div class="tab-pane fade" id="scope" >
								<div class="col-sm-7">
									<b>@lang('pages.scope_and_structure')</b><p></p>
									<?php echo $service->getValueService() ?>
								</div>
								<div class="col-sm-5">
									@if($service->getExpandable() || $service->getAddMaterials())
										@if($service->getExpandable())
											<b>@lang('pages.expandable_service')</b> - @lang('pages.expandable_service_title')
										@endif
										<p></p>
										@if($service->getAddMaterials())
											<b>@lang('pages.add_materials')</b><p></p>
											<?php echo $service->getAddMaterials() ?>
										@endif
										
										
									@endif
								</div>
							</div>
							
								@if($service->getTermsProvision() || $service->getAddTerms())
									<div class="tab-pane fade" id="additional_terms" >
										<div class="col-sm-6">
											@if($service->getTermsProvision())
												<b>@lang('pages.terms_service')</b> - @lang('pages.terms_service_title')
												<p></p>
											@endif
											<?php echo $service->getTermsProvision() ?>
										</div>
										<div class="col-sm-6">
											@if($service->getAddTerms())
												<b>@lang('pages.additional_terms')</b><p></p>
											@endif
											<?php echo $service->getAddTerms() ?>
										</div>
									</div>
								@endif

						</div>
					</div><!--/category-tab-->
				</div> <!-- /col-sm-9 padding-right -->
				
				
				
				
				
				@if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && ($service->status != 1 || $service->blurb_type_id == null))
					<div class="col-sm-12">
				        <div class="col-sm-4"></div>
				        @if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && $service->blurb_type_id == null && $service->status == 1)
					        <div class="col-sm-4">
					        	<a href="#window5" class="btn1 pull-right">
						  			<i class="fa fa-magnet"></i>&nbsp;&nbsp;
						  			Рекламировать услугу
						  		</a>
							</div>
						@endif
						<div class="col-sm-4">
							@if(isset(Auth::user()->id) && Auth::user()->id == $service->user_id && $service->status != 1)
								@if($service->bidding_type % 2 == 0)
							  		<a href="{{route('service.mysell.edit', $service->id)}}" class="btn1 pull-right">
							  			<i class="fa fa-gavel"></i>&nbsp;&nbsp;
							  			Редактировать - Опубликовать услугу
							  		</a>
							  	@elseif($service->bidding_type % 2 != 0)
							  		<a href="{{route('service.mybuy.edit', $service->id)}}" class="btn1 pull-right">
							  			<i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;
							  			Редактировать - Опубликовать услугу
							  		</a>
							    @endif
							@endif
						</div>
			        </div>
			    @endif
				<p>&nbsp;</p>
				
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

<!-- Определение тарифа за рекламирование услуги -->
<script type="text/javascript">
	$('#blurb_type_id').change(function(){
		var blurb_type_id = $(this).val();
		if(blurb_type_id){
			//Передача тарифа на рекламу
			var str = $("#blurb_prises").val();
			var blurb_prises = str.split(",");
			var blurb_pr = blurb_prises[blurb_type_id - 1];
			$("#price_blurb").prop("enabled", true);      /* Разблокировка инпута */
			$("#price_blurb").val(blurb_pr);
			$("#price_blurb").prop("disabled", true);     /* Блокировка инпута */
			//Передача периода рекламы
			var str1 = $("#blurb_periods").val();
			var blurb_periods = str1.split(",");
			var blurb_pe = blurb_periods[blurb_type_id - 1];
			$("#period_blurb").prop("enabled", true);      /* Разблокировка инпута */
			$("#period_blurb").val(blurb_pe);
			$("#period_blurb").prop("disabled", true);     /* Блокировка инпута */
		}

		
		//Корректировка конечного периода в зависимости от выбранного пакета рекламы
		function formatDate1(date) {
			var dd = date.getDate();
			if (dd < 10) dd = '0' + dd;

			var mm = date.getMonth() + 1;
			if (mm < 10) mm = '0' + mm;

			var yy = date.getFullYear();
			if (yy < 10) yy = '0' + yy;
			
			var hh = date.getHours();
			if (hh < 10) hh = '0' + hh;
			
			var mi = date.getMinutes();
			if (mi < 10) mi = '0' + mi;
			
			var ss = date.getSeconds();
			if (ss < 10) ss = '0' + ss;			

			return dd + '-' + mm + '-' + yy + ' ' + hh + ':' + mi + ':' + ss;
		}
		
		function addDays1(days) {
		  var date_on_blurb = new Date();
		  var offset = -1 * date_on_blurb.getTimezoneOffset() * 60;  /* Вычисление смещения часового пояса пользователя относительно 'UTC'.  На "-1" умножено, поскольку для западного отклонения получается отрицательное смещение */

		  var ms = date_on_blurb.getTime() + 86400000 * days;
		  var result = new Date(ms);
		  
		  //Передать в контроллер начальную дату рекламного периода
		  $("#date_on_blurb").val(formatDate1(date_on_blurb));
		  
		  return result;
		}
		
		
		var date_off_str = $("#date_off").val();
		var date_off = new Date(date_off_str);
		var date_off_blurb = addDays1(blurb_pe); //Берем период рекламы и зменяем им ранее выбранный период если период рекламы больше
		
		$("#date_off_blurb").val(formatDate1(date_off_blurb));
		
		if(blurb_pe){
			if(date_off < date_off_blurb){
				$("#not_enough_date").css("display", "inline-block");
				$("#allow_public").css("display", "none");
			}else{
				$("#not_enough_date").css("display", "none");
				$("#allow_public").css("display", "inline-block");
			}
		}
		

		var balance0 = $("#balance0").val() * 1;

		var delta = balance0 - blurb_pr;
		if(delta < 0){
			$("#not_enough_blurb").css("display", "inline-block");
			$("#not_public").css("display", "inline-block");
			$("#allow_public").css("display", "none");
		}else{
			$("#not_enough_blurb").css("display", "none");
			$("#not_public").css("display", "none");
			if(blurb_pe && date_off > date_off_blurb){
				$("#allow_public").css("display", "inline-block");
			}
		}
		
		
		
	});
</script>


@endpush
