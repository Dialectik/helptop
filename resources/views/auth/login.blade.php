@extends('layouts.app_a')

@section('content')

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				@if(session('status'))
					<div class="alert alert-success">
						{{session('status')}}
					</div>                		
				@endif
				
				<div class="col-sm-4 col-sm-offset-2">
					<div class="login-form"><!--login form-->
						<h2>@lang('auth.login')</h2>
						<form method="POST" action="{{ route('login_post') }}">
	                        @csrf
	                        
							<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('auth.email')" required autofocus>
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
	                                
							<span>
								<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
	                            @lang('auth.remember_me')
							</span>
							
							<button type="submit" class="btn btn-default">
                                @lang('auth.login')
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    @lang('auth.forgot_password')
                                </a>
                            @endif
							
						</form>
					</div><!--/login form-->
				</div>

			</div>
		</div>
	</section><!--/form-->
	
@endsection
