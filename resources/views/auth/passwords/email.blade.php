@extends('layouts.app_a')

@section('content')

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				
				<div class="col-sm-4 col-sm-offset-2">
					<div class="login-form"><!--login form-->
						<h2>@lang('auth.reset_password')</h2>
						
						@if (session('status'))
	                        <div class="alert alert-success" role="alert">
	                            {{ session('status') }}
	                        </div>
	                    @endif
						
						<form method="POST" action="{{ route('password.email') }}">
	                        @csrf
	                        
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('auth.email')" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <div class="alert alert-danger" role="alert">
                                    	{{ $errors->first('email') }}
                                    </div>
                                </span>
                            @endif
                            
                            <button type="submit" class="btn btn-default">
                                @lang('auth.send_pr_link')
                            </button>
							
						</form>
					</div><!--/login form-->
				</div>

			</div>
		</div>
	</section><!--/form-->

@endsection
