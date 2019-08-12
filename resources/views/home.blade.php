@extends('layouts.app_a')

@section('content')
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div >
	                	<h2 class="heading">@lang('auth.dashboard')</h2>
	                </div>

	                <div class="register-req">
	                    @if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif

	                    @lang('auth.logged')
	                </div>
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection
