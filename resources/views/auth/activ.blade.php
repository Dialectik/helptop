@push('scripts_google')

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145440075-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145440075-1');
</script>

@endpush

@extends('layouts.app_a')

@section('content')

	<section>
		<div class="container">
			<div class="row">
				
				<div class="col-sm-8 col-sm-offset-1">
					
						<h2>@lang('auth.register')</h2>
						
						@include('admin.errors')
						
						@if(session('status'))
							<div class="alert alert-info">
								{{session('status')}}
							</div>                		
						@endif

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
						
				<p>&nbsp; </p>
	            <p>&nbsp; </p>
					
				</div>

			</div>
		</div>
	</section>

@endsection
