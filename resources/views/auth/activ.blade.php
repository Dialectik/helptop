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
						<h2>Активація аккаунта</h2>
						@include('admin.errors')
									
						Реєстрація пройшла успішно, на Ваш email надіслано листа з посиланням для активації облікового запису. 
						Для завершення реєстрації будь ласка відкрийте лист, що прийшов на Ваш ящик і перейдіть по посиланню.
						
					</section>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
