
@extends('layouts.app_a')

@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Путь -->
					<div class="breadcrumbs">
						<ol class="breadcrumb">
						  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
						  <li><a href="{{ route('scores.index') }}">@lang('layouts.score')</a></li>
						  <li class="active">Транзакция №{{ $score->id }}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3"> <!--left-sidebar-->
					<div class="form-group">
		              <img src="{{$score->user->getImage()}}" alt="" width="200" class="img-responsive">
		              <label for="exampleInputFile" style="color:#0D1291">{{ $score->user->name }}</label>
		            </div>
					
					<!--left-sidebar-->
					@include('layouts._sidebar_myprofile')
				</div>
				
				<div class="col-sm-9 padding-right">
				

				
				
				<!--Показывать страницу только если найден пользователь-->
				@if(null != $score)
					<div class="features_items"><!--Данные пользователя-->
						<h2 class="title text-center"><small>Транзакция</small> №{{ $score->id }}</h2>
						<!-- Default box -->
					      <div class="box">
					        <!-- Движение средств -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-4">
					            <div class="form-group">
					              Сумма &nbsp; 
					              <span style="color:#0D1291; font-weight: bold;">
					              	<?php if($score->refill > 0){echo $score->refill;}elseif($score->expense){echo $score->expense;}else{echo 0;} ?> грн
					              </span>
					            </div>  <!-- end "col-sm-4" -->
					          </div>
					          <div class="col-sm-4">
					            <div class="form-group">
					              Операция &nbsp; 
					             <span style="color:#0D1291">
					             	<?php if($score->refill > 0){echo 'Зачисление';}elseif($score->expense > 0){echo 'Снятие';}else{echo 'Не проведена/ Ожидается';} ?>
					             </span>
					            </div>
					          </div>  <!-- end "col-sm-4" -->
					          <div class="col-sm-4">
					            <div class="form-group">
					            	Баланс &nbsp; 
					            	<span style="color:#0D1291">
					             		<?php if($score->balance > 0){echo $score->balance;}else{echo 0;} ?> грн
					             	</span>
					            </div>
					          </div>  <!-- end "col-sm-4" -->
					          
					        </div>  <!-- end "box-body" -->
					      
					        
					        <div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

							<!-- Причина -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-4">
					            <div class="form-group">
					              Вид транзакции &nbsp; 
					              <span style="color:#0D1291">
					              	<?php
				              			switch ($score->cause) {
										  case '1':
										    echo 'Пополнение пользователем';
										    break;
										  case '2':
										    echo 'Возврат';
										    break;
										  case '3':
										    echo 'Бонусная программа';
										    break;
										  case '4':
										    echo 'Оплата публикации';
										    break;
										  case '5':
										    echo 'Оплата рекламы';
										    break;
										  case '6':
										    echo 'Не проведен/ Ожидается';
										    break;
										  case '7':
										    echo 'Корректировка-';
										    break;
										  case '8':
										    echo 'Корректировка+';
										    break;
										  default:
										    break;
										}
				              		?>
					              </span>
					            </div>
					          </div>
					          <div class="col-sm-8">
					            <div class="form-group">
					              Дата / Время &nbsp;
				              	  <span style="color:#0D1291">
				              	  	{{ $score->getDateAttribute($score->date_trans, $date_offset) }}
				              	  </span>
					            </div>
						      </div>  <!-- end "col-sm-6" -->
						    </div>  <!-- end "box-body" -->

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->


							@if(null != $score->blurb_id || null != $score->service_id)
							<!--  -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-2">
					            <div class="form-group">
					              	<?php 
					              		if(null != $score->blurb_id){echo 'Оплачена реклама услуги';}elseif(null != $score->service_id){echo 'Оплачена публикация услуги';}
					              	?>
					            </div>
					          </div>  <!-- end "col-sm-2" -->
					          <div class="col-sm-2">
					            <div class="form-group">
					            	<span style="color:#0D1291">
					            		<?php 
					              			if(null != $score->blurb_id){echo $score->getBlurbTitle();}elseif(null != $score->service_id){echo $score->getRateBiddingTitle();}
					              		?>
					              	</span>
					            </div>
					          </div>  <!-- end "col-sm-2" -->
					          <div class="col-sm-2">
					            <div class="form-group">
					            	Код услуги &nbsp;
					            	<p><div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;"><?php echo (substr($score->getServiceCode(), 0, 6) . '-' . substr($score->getServiceCode(), 6, 4)) ?></div></p>
					            </div>
					          </div>  <!-- end "col-sm-2" -->
					          <div class="col-sm-6">
					            <div class="form-group">
					            	<span style="color:#0D1291">
					            		<?php if(isset($score->service->title)){echo $score->service->title;} ?>
					            	</span>
					            </div>
					          </div>  <!-- end "col-sm-6" -->
					        </div>  <!-- end "box-body" -->	
					        @endif		

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->


					      </div>
					      <!-- /.box -->


					</div><!--/Данные пользователя-->
					
					
					
					
					
					<div class="features_items"><!--***-->
						
						



					</div> <!--/***-->
					

				
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Нет подробной информации по транзакции</label>
					</div>
				@endif	
				</div>
			</div>
		</div>
	</section>

	
@endsection



