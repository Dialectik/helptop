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
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li><a href="{{ route('scores.index') }}">@lang('layouts.score')</a></li>
				  <li class="active">Пополнение счета</li>
				</ol>
			</div>
			
			<div class="heading">
				<div class="col-sm-12">
	                <p>&nbsp; </p>
		            	Ваша заявка на пополнение счета принята.<br/>
		            	На Вашу электронную почту отправлено сообщение с реквизитами для оплаты счета №
		            	{{ $score->id }}.<br/>
		            	Для успешного пололнения счета придерживайтесь инструкций, приведенных в письме
	                <p>&nbsp; </p>
	                <p>&nbsp; </p>
				</div>
			</div>
		</div>
	</section>

@endsection