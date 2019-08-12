@extends('layouts.app_a')

@section('content')

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				
				<div class="col-sm-4 col-sm-offset-2">
					<div class="login-form"><!--login form-->
						<h2>@lang('auth.reset_password')</h2>
						<form method="POST" action="{{ route('password.update') }}">
	                        @csrf
	                        
	                        <input type="hidden" name="token" value="{{ $token }}">
	                        
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="@lang('auth.email')" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <div class="alert alert-danger" role="alert">
                                    	{{ $errors->first('email') }}
                                    </div>
                                </span>
                            @endif
                            
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="@lang('auth.password')" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <div class="alert alert-danger" role="alert">
                                    	{{ $errors->first('password') }}
                                    </div>
                                </span>
                            @endif
                                
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="@lang('auth.c_password')" required>    

							<button type="submit" class="btn btn-default">
                                @lang('auth.reset_password')
                            </button>
							
						</form>
					</div><!--/login form-->
				</div>

			</div>
		</div>
	</section><!--/form-->

@endsection
