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
				  @if(null != $rating)
				  	@if(Auth::user()->id && Auth::user()->id != $rating->user_rated_id)
				 	 	<li><a href="{{ route('ratings.show', $rating->user_rated_id) }}">Рейтинги</a></li>
				  	@else
				  		<li><a href="{{ route('myprofile.index') }}">@lang('layouts.pers_data')</a></li>
				  	@endif
				  @endif
				  <li class="active"> Рейтинг пользователя <b><u>{{ null != $rating ? $rating->ratedUser->name : '' }}</u></b></li>
				</ol>
			</div>
					
			
			@if(null != $rating && $rating->rating_star != 0)  <!-- Проверка иммеется ли рейтинг у пользователя -->
			<!-- Основная информация по рейтингу -->
			<div class="heading">
				<div class="col-sm-12">
					<form id="myForm" method="post" action="{{ route('ratings.store') }}" >
	                	{{csrf_field()}}
					<div class="product-details"><!--product-details-->
						<div class="product-information"><!--/product-information-->

							<div class="col-sm-12">
									<h1>{{ $rating->rating_star }} % положительных отзывов из {{ $rating_count }} отзывов</h1>
									
									<div class="col-sm-8">
										<div class="col-sm-7">
											<p>Актуальность цены</p>
										</div>
										<div class="col-sm-5">
											{{ $rating->rating_price }} %
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<div class="col-sm-7">
											<p>Актуальность наличия</p>
										</div>
										<div class="col-sm-2">
											{{ $rating->rating_availab }} %
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<div class="col-sm-7">
											<p>Актуальность описания</p>
										</div>
										<div class="col-sm-5">
											{{ $rating->rating_descr }} %
										</div>
									</div>  <!--/ "col-sm-8" -->
									
									<div class="col-sm-8">
										<div class="col-sm-7">
											<p>Выполнение заказа в срок</p>
										</div>
										<div class="col-sm-5">
											{{ $rating->rating_term }} %
										</div>
									</div>  <!--/ "col-sm-8" -->
								</div>  <!--/ "col-sm-12" -->	
								
							

								
							
						</div><!--/product-information-->
					</div><!--/product-details-->
					
					
					<!-- Обо мне -->
					<div class="product-details"><!--product-details-->
						О фирме (пользователе)
						<div class="product-information"><!--/product-information-->
							<div class="col-sm-8" >
								<?php echo $user->firm ?>
							</div>
						
							<div class="col-sm-4" >
								<img src="{{$user->getImage()}}" alt="" width="400" class="img-responsive">
							</div>
						</div><!--/product-information-->
					</div><!--/product-details-->
					
					
					<!-- Отзывы -->
					<div class="product-details"><!--product-details-->
						Отзывы
						<div class="product-information"><!--/product-information-->
						
						@foreach($ratings as $rating)

							<div class="col-sm-9" >
								@if(isset($rating->review))
									
									<div class="form-group alert alert-success col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px;">
										<!-- Звездочки -->
										<p style="margin-bottom:0px; color: #F49925"><?php
						              			switch ($rating->local_star) {
												  case '5':
												    echo '<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>';
												    break;
												  case '4':
												    echo '<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>';
												    break;
												  case '3':
												    echo '<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i></p>';
												    break;
												  case '2':
												    echo '<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i></p>';
												    break;
												  case '1':
												    echo '<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i></p>';
												    break;
												  default:
												    break;
												}
						              		?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('service.show', $rating->service_id) }}">"@if($rating->service){!! $rating->service->title !!}"@endif</a></p>
										<a href="{{ route('ratings.show', $rating->auditorUser->id) }}" style="">{{ $rating->auditorUser->name }}</a> &nbsp;&nbsp; {{ $rating->getDateAttribute($rating->created_at, $date_offset) }}
										<p><?php echo $rating->review ?></p>
										@if((Auth::user()->id == $rating->user_rated_id) && ($rating->message == null))
											<p></p>
											<p style="text-align: right; color: #F49925" ><a href="#window3" style="color: #eb8a14">Ответить</a></p>
										@endif
									</div>
								@endif
								@if(isset($rating->message))	
									<div class="form-group alert alert-info col-sm-9" style="margin-top: 0px; margin-bottom: 10px; margin-left: 100px; margin-right: 10px; align-self: right">
										<a href="{{ route('ratings.show', $rating->ratedUser->id) }}" style="">{{ $rating->ratedUser->name }}</a> (ответ) &nbsp;&nbsp; {{ $rating->getDateAttribute($rating->date_rating, $date_offset) }}
										<p><?php echo $rating->message ?></p>
									</div>
								@endif

								<p>&nbsp; </p>
								<p>&nbsp; </p>
							</div>
						@endforeach
			
						
						</div><!--/product-information-->
					</div><!--/product-details-->
					</form>
				</div>
			</div>  <!-- /"heading" /Основная информация по рейтингу -->
			@else
				Пользователь не имеет рейтинга
			@endif

			
			
			
		            
			<p>&nbsp; </p>
			<p>&nbsp; </p>
		</div>  <!-- /"container" -->
	</section>

@endsection


@push('scripts')







@endpush