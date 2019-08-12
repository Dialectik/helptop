
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
						  <li><a href="{{ route('blurbs.index') }}">@lang('layouts.blurb')</a></li>
						  <li class="active">Рекламная опция №{{ null != $blurb ? $blurb->id : '' }}</li>
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
		              <img src="{{Auth::user()->getImage()}}" alt="" width="200" class="img-responsive">
		              <label for="exampleInputFile" style="color:#0D1291">{{ Auth::user()->name }}</label>
		            </div>
					
					<!--left-sidebar-->
					@include('layouts._sidebar_myprofile')
				</div>
				
				<div class="col-sm-9 padding-right">
				

				
				
				<!--Показывать страницу только если найден пользователь-->
				@if(null != $blurb)
					<div class="features_items"><!--Данные пользователя-->
						<h2 class="title text-center"><small>Рекламная опция</small> №{{ $blurb->id }}&nbsp;&nbsp;
							<?php 
				              	  if(isset($blurb->status) && $blurb->status == 0){
				              	  		echo '<div style="border: 1px solid #e83217; padding: 4px 4px 4px 4px; ">Реклама НЕАКТИВНА</div>';
				              	  }else{
				              	  	echo '';
				              	  } 
			              	  ?>
						</h2>
						<!-- Default box -->
					      <div class="box"
					      	  <?php 
				              	  if(isset($blurb->status) && $blurb->status == 0){
				              	  		echo 'style="color: #778881"';
				              	  }else{
				              	  	echo '';
				              	  } 
			              	  ?>
					      >
					        <!-- Движение средств -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-4">
					            <div class="form-group">
					              Стоимость рекламы &nbsp; 
					              <span 
				              	  <?php 
					              	  if(isset($blurb->status) && $blurb->status == 0){
					              	  		echo 'style="color: #778881"; font-weight: bold;';
					              	  }else{
					              	  	echo 'style="color: #0D1291"; font-weight: bold;';
					              	  } 
				              	  ?> >
					              	<?php if($blurb->blurb_cost){echo $blurb->blurb_cost;}?> грн</h2>
					              </span>
					            </div>  <!-- end "col-sm-4" -->
					          </div>
					          <div class="col-sm-4">
					            <div class="form-group">
					              Рекламный пакет &nbsp;<br/> 
					             <span 
				              	  <?php 
					              	  if(isset($blurb->status) && $blurb->status == 0){
					              	  		echo 'style="color: #778881"';
					              	  }else{
					              	  	echo 'style="color: #0D1291"';
					              	  } 
				              	  ?> >
					             	<?php 
				              			if(null != $blurb->id){echo $blurb->getBlurbTitle();}
				              		?>
					             </span>
					            </div>
					          </div>  <!-- end "col-sm-4" -->
					          <div class="col-sm-4">
					            <div class="form-group">
					            	Период рекламирования &nbsp; 
					            	<span 
				              	  <?php 
					              	  if(isset($blurb->status) && $blurb->status == 0){
					              	  		echo 'style="color: #778881"';
					              	  }else{
					              	  	echo 'style="color: #0D1291"';
					              	  } 
				              	  ?> >
					             		<?php if($blurb->id){echo $blurb->getBlurbPeriod();} ?> дней
					             	</span>
					            </div>
					          </div>  <!-- end "col-sm-4" -->
					          
					        </div>  <!-- end "box-body" -->
					      
					        
					        <div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->

							<!-- Причина -->
					        <div class="box-body col-sm-12">
					          <div class="col-sm-6">
					            <div class="form-group">
					              Реклама запущена &nbsp;
				              	  <span 
				              	  <?php 
					              	  if(isset($blurb->status) && $blurb->status == 0){
					              	  		echo 'style="color: #778881"';
					              	  }else{
					              	  	echo 'style="color: #0D1291"';
					              	  } 
				              	  ?> >
				              	  	{{ $blurb->getDateAttribute($blurb->date_on_blurb, $date_offset) }}
				              	  </span>
					            </div>
					          </div>
					          <div class="col-sm-6">
					            <div class="form-group">
					              	Дата снятия рекламы &nbsp;
					              </span>
				              	  <span 
				              	  <?php 
					              	  if(isset($blurb->status) && $blurb->status == 0){
					              	  		echo 'style="color: #778881"';
					              	  }else{
					              	  	echo 'style="color: #0D1291"';
					              	  } 
				              	  ?> >
				              	  	{{ $blurb->getDateAttribute($blurb->date_off_blurb, $date_offset) }}
				              	  </span>
					            </div>
						      </div>  <!-- end "col-sm-6" -->
						    </div>  <!-- end "box-body" -->

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->


							
							<!--  -->
					        <div class="box-body col-sm-12">
					          <!-- Картинка -->
					          <div class="col-sm-3">
					            <div class="form-group">
					            	<a href="{{ route('service.show', $blurb->service_id) }}"><img src="{{ $blurb->getImage() }}" alt="" style="max-width: 100px; max-height: 100px" /></a>
					            </div>
					          </div>  <!-- end "col-sm-3" -->
					          <div class="col-sm-3">
					            <div class="form-group">
					            	Код услуги &nbsp;
					            	<p><div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;"><?php echo (substr($blurb->getServiceCode(), 0, 6) . '-' . substr($blurb->getServiceCode(), 6, 4)) ?></div></p>
					            </div>
					          </div>  <!-- end "col-sm-3" -->
					          <div class="col-sm-6">
					            <div class="form-group">
					            	<a href="<?php if($blurb->getServiceID()) echo route('service.show', $blurb->getServiceID()) ?>">{{ $blurb->getServiceTitle() }}</a>
					            </div>
					          </div>  <!-- end "col-sm-6" -->
					        </div>  <!-- end "box-body" -->	
					        		

							<div class="col-sm-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-sm-12" -->


					      </div>
					      <!-- /.box -->


					</div><!--/Данные пользователя-->
					
				
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Нет подробной информации по рекламе данной услуги</label>
					</div>
				@endif	
				</div>
			</div>
		</div>
	</section>

	
@endsection



