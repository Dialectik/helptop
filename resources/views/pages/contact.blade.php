@push('styles')
	<style>
      #sendmessage, #senderror {
		 display: none; 
		}
	</style>

@extends('layouts.app_a')

@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Путь -->
					<div class="breadcrumbs">
						<ol class="breadcrumb">
						  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
						  <li class="active">Контакты</li>
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
							<div class="form-group">
				              <img src="" alt="" width="200" class="img-responsive">
				            </div>
							
							<!--left-sidebar-->
							@include('layouts._sidebar_contact')
						</div>
				
				
			<div class="col-sm-9 ">
				<div class="features_items">
					<div class="box">
							<h2 class="title text-center">Напишите нам сообщение</h2>
							<p class="warning">Заполните, пожалуйста, <b>все</b> поля формы ниже</p>
							
							<form id="contact_form" class="contact_form" method="post">
								@csrf
								<input type="hidden" name="_method" value="POST" >	
							<div class="box-body col-sm-12">
								<ul>
									<li>
										<label for="name">Ваше имя:</label>
										<input type="text" name="name" id="name" required class="form-control" >
									</li>
									<li>
										<label for="email">Email:</label>
										<input type="text" name="email" id="email" required placeholder="Введите email" class="required email form-control">
									</li>	
									
									<li>
							            <label for="email">Тема:</label>
							            <input type="text" name="subject" placeholder="Введите тему сообщения" class="form-control"  required  />
							        </li>
									
									<li>
										<label for="message">Сообщение:</label>
										<textarea name="message" id="message" cols="100" rows="6" required  class="form-control"  ></textarea>
									</li>
									<p>&nbsp;</p>
									<li>
										<button type="submit" id="submit" class="btn1 ">Отправить</button>
									</li>	
								</ul>
							</div> <!--/"box-body col-sm-12"-->
								<p>&nbsp;</p>
								<div id="sendmessage" class="alert alert-info">
							        Ваше сообщение отправлено!
							    </div>
							    <div id="senderror" class="alert alert-warning">
							        При отправке сообщения произошла ошибка. Продублируйте его, пожалуйста, на почту администратора <span>{{ env('MAIL_ADMIN_EMAIL') }}</span>
							    </div>				
											
							</form>
						</div>
					</div>
				</div>  <!--/"col-sm-9"-->
			</div>
		</div>
	</section>				
					
@endsection


@push('scripts')
	
	<!-- Contactform -->
	<script>
		$(document).ready(function(){
		    $('#contact_form').on('submit', function(e){
		        e.preventDefault();
		         
		        $.ajax({
		            type: 'POST',
		            url: '/sendmail',
		            data: $('#contact_form').serialize(),
		            success: function(data){
		                if(data.result)
		                {
		                    $('#senderror').hide();
		                    $('#sendmessage').show();
		                }
		                else
		                {
		                    $('#senderror').show();
		                    $('#sendmessage').hide();
		                }
		            },
		            error: function(){
		                $('#senderror').show();
		                $('#sendmessage').hide();
		            }
		        });
		    });
		});
	</script>
@endpush