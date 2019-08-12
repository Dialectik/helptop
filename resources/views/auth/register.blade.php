@extends('layouts.app_a')

@section('content')

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">

				<div class="col-sm-4 col-sm-offset-2">
					<div class="login-form"><!--register form-->
						<h2>@lang('auth.register')</h2>
						
						<form method="POST" action="/register">
	                        @csrf
	                        
							<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required placeholder="@lang('auth.name')" autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <div class="alert alert-danger" role="alert">
                                    	{{ $errors->first('name') }}
                                    </div>
                                </span>
                            @endif
                            
							<input id="text" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('auth.email')" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <div class="alert alert-danger" role="alert">
                                    	{{ $errors->first('email') }}
                                    </div>
                                </span>
                            @endif
							
							<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="@lang('auth.password')">
	                        @if ($errors->has('password'))
	                            <span class="invalid-feedback" role="alert">
	                                <div class="alert alert-danger" role="alert">
	                                	{{ $errors->first('password') }}
	                                </div>
	                            </span>
	                        @endif
	                        
	                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="@lang('auth.c_password')">
	                                
							<!--Галочка о принятии соглашения-->
							<span>
								<input class="form-check-input" type="checkbox" name="accept" id="remember" {{ old('accept') ? 'checked' : '' }}>
								@include('admin.errors')
								
                                    @lang('auth.accept') 
                                    <a href="/refer/1">Соглашения</a>
                                    @lang('auth.accept1')
                                    <a href="/refer/1">Соглашению</a>
                                    @lang('auth.accept2')
                                    
 							</span>
							
							<button type="submit" class="btn btn-default">
                                @lang('auth.register')
                            </button>

						</form>
					</div><!--/register form-->
				</div>

			</div>
		</div>
	</section><!--/form-->

@endsection
