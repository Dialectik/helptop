@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                	@lang('auth.register')
                	
                	@include('admin.errors')
                </div>

                
                
                <div class="card-body">
                    

	                @if(session('status'))
						<div class="alert alert-danger">
							{{session('status')}}
						</div>                		
					@endif
					

					
					
					<section class="grid col-three-quarters mq2-col-two-thirds mq3-col-full">
						<h2>Активация аккаунта
						<p></p>
						<small>Account activation</small>
						</h2>
						@include('admin.errors')
						Регистрация прошла успешно, на Ваш email отправлено письмо с ссылкой для активации аккаунта.
						Для завершения регистрации пожалуйста откройте письмо, пришедшее на Ваш ящик и перейдите по ссылке.
						<p></p>			
						Реєстрація пройшла успішно, на Ваш email надіслано листа з посиланням для активації облікового запису. 
						Для завершення реєстрації будь ласка відкрийте лист, що прийшов на Ваш ящик і перейдіть по посиланню.
						<p></p>
						<small>
							The registration has been successful, an email has been sent to your email with the link to activate the account.
							To complete the registration, please open the letter that came to your box and go to the link.
						</small>
						
					</section>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
