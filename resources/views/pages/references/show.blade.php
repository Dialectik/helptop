@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li><a href="{{route('refer.index')}}">@lang('pages.regulations_help')</a></li>
				  <li class="active">{{ $reference->title }}</li>
				</ol>
			</div>
			
			<div class="heading">
				<div class="col-sm-9">
	                <p>&nbsp; </p>
					<!-- Вывод справочного материала -->
	                <div>
						<?php
							echo $reference->content;
						?>
	                </div>
	                <p>&nbsp; </p>
	                <p>&nbsp; </p>
				</div>
			</div>
		</div>
	</section>

@endsection