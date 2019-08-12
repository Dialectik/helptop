@push('styles')

	
@endpush


@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li><a href="{{ route('messages.index') }}">Сообщения</a></li>
				  <li class="active"> Сообщения по услуге </li>
				</ol>
			</div>
					<?php if(isset($messages)){foreach($messages as $mes){if($id = $mes->id){	}	};} ?>
			@if(isset($user_id) && $user_id == Auth::user()->id && isset($id))
			<!-- Основная информация -->
			<div class="heading">
				<div class="col-sm-12">
					<p style="font-size: 300%; display: inline;">
						Сообщения
					</p>
					<div class="col-sm-12">
						<div class="product-details"><!--product-details-->
							<div class="product-information"><!--/product-information-->

								<!-- Область текстовых сообщений контрагентов -->
								<h2 style="text-align: center" >Сообщения по услуге <a href="{{ route('service.show', $service_id) }}">{{ $service_title }}</a></h2>
								<div class="col-sm-9" id="messages">
									@if(isset($messages))
										@foreach($messages as $message)
											@if(Auth::user()->id == $message->user_id)
												<div class="form-group alert alert-success col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 100px; margin-right: 10px;">
													<a href="" style="">{{ Auth::user()->name }}</a> (Вы) &nbsp;&nbsp; {{ $message->getDateAttribute($message->updated_at, $date_offset) }}
													<p><?php echo $message->message ?></p>
												</div>
											@endif
											
											@if(Auth::user()->id != $message->user_id)
												<div class="form-group alert alert-info col-sm-9" style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px; align-self: right">
													<a href="" style="">{{ $message->user->name }}</a> (контрагент) &nbsp;&nbsp; {{ $message->getDateAttribute($message->updated_at, $date_offset) }}
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
										<input type="hidden" name="recipient" id="recipient" value="{{ $recipient }}">
										<input type="hidden" name="service_id" value="{{ $service_id }}">
										<button class="btn btn-fefault cart" >Отправить</button>
									</form>
									
									<p>&nbsp; </p>
				                	
								</div>
				                <p>&nbsp; </p>
								
								
							</div><!--/product-information-->
						</div><!--/product-details-->
					</div>
				</div>
			</div>  <!-- /Основная информация  -->
			

            @elseif(isset($user_id) && $user_id == Auth::user()->id && !isset($id))
            	<div class="table-responsive cart_info">
					Нет текущих сделок или сделка аннулирована
				</div>
            @else
            	Перед использованием сервиса необходимо 
            	<a class="nav-link" href="/login">войти</a>
            	 или 
            	 <a class="nav-link" href="/register">зарегистрироваться</a>
            @endif
			
		</div>  <!-- /"container" -->
	</section>

@endsection


@push('scripts')





@endpush