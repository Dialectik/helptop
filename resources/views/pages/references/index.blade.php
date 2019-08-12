@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li class="active">@lang('pages.regulations_help')</li>
				</ol>
			</div>
			
			<div class="heading">
				<div class="col-sm-9">
					<div >
	                	<h2 class="heading">@lang('pages.regulations_help')</h2>
	                </div>
	                <p>&nbsp; </p>
					<!-- Перечень правил и справочных данных -->
	                <div >
						@foreach($references as $reference)
							<p><a href="{{ route('refer.show', $reference->id) }}">{{ $reference->title }}</a></p>
						@endforeach
	                </div>
	                <p>&nbsp; </p>
	                <p>&nbsp; </p>
				</div>
			</div>
		</div>
	</section>

@endsection