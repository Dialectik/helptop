@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Транзакция №{{ $score->id }}
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
           
            <div class="box-header">
              <h3 class="box-title">Транзакция №{{ $score->id }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{ route('scoreusers.edit', $score->id) }}" class="btn btn-success">Изменить счет</a>
              </div>
				
				<!--Показывать страницу только если найден пользователь-->
				@if(null != $score->id)
					<div class="features_items"><!--Данные пользователя-->
						<h2 class="title text-center"><small>Транзакция</small> №{{ $score->id }}</h2>
						<!-- Default box -->
					      <div class="box">
					        <!-- Движение средств -->
					        <div class="box-body col-md-12">
					          <div class="col-md-4">
					            <div class="form-group">
					              Сумма &nbsp; 
					              <span style="color:#0D1291; font-weight: bold;">
					              	<?php if($score->refill > 0){echo $score->refill;}elseif($score->expense){echo $score->expense;}else{echo 0;} ?> грн
					              </span>
					            </div>  <!-- end "col-md-4" -->
					          </div>
					          <div class="col-md-4">
					            <div class="form-group">
					              Операция &nbsp; 
					             <span style="color:#0D1291">
					             	<?php if($score->refill > 0){echo 'Зачисление (+)';}elseif($score->expense > 0){echo 'Снятие (-)';}else{echo 'Не проведена/ Ожидается';} ?>
					             </span>
					            </div>
					          </div>  <!-- end "col-md-4" -->
					          <div class="col-md-4">
					            <div class="form-group">
					            	Баланс &nbsp; 
					            	<span style="color:#0D1291">
					             		<?php if($score->balance > 0){echo $score->balance;}else{echo 0;} ?> грн
					             	</span>
					            </div>
					          </div>  <!-- end "col-md-4" -->
					          
					        </div>  <!-- end "box-body" -->
					      
					        
					        <div class="col-md-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-md-12" -->

							<!-- Причина -->
					        <div class="box-body col-md-12">
					          <div class="col-md-4">
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
										  case null:
											echo 'Сбой! Ошибка!';
											break;
										  default:
										    break;
										}
				              		?>
					              </span>
					            </div>
					          </div>
					          <div class="col-md-8">
					            <div class="form-group">
					              Дата / Время &nbsp;
				              	  <span style="color:#0D1291">
				              	  	{{ $score->getDateAttribute($score->date_trans, $date_offset) }}
				              	  </span>
					            </div>
						      </div>  <!-- end "col-md-6" -->
						    </div>  <!-- end "box-body" -->

							<div class="col-md-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-md-12" -->


							@if(null != $score->blurb_id || null != $score->service_id)
							<!--  -->
					        <div class="box-body col-md-12">
					          <div class="col-md-2">
					            <div class="form-group">
					              	<?php 
					              		if(null != $score->blurb_id){echo 'Оплачена реклама услуги';}elseif(null != $score->service_id){echo 'Оплачена публикация услуги';}
					              	?>
					            </div>
					          </div>  <!-- end "col-md-2" -->
					          <div class="col-md-2">
					            <div class="form-group">
					            	<span style="color:#0D1291">
					            		<?php 
					              			if(null != $score->blurb_id){echo $score->getBlurbTitle();}elseif(null != $score->service_id){echo $score->getRateBiddingTitle();}
					              		?>
					              	</span>
					            </div>
					          </div>  <!-- end "col-md-2" -->
					          <div class="col-md-2">
					            <div class="form-group">
					            	Код услуги &nbsp;
					            	<p><div style="border: 1px solid #dbc524; padding: 1px 3px 1px 3px; display: inline;"><?php echo (substr($score->getServiceCode(), 0, 6) . '-' . substr($score->getServiceCode(), 6, 4)) ?></div></p>
					            </div>
					          </div>  <!-- end "col-md-2" -->
					          <div class="col-md-6">
					            <div class="form-group">
					            	<span style="color:#0D1291">
					            		<?php if(isset($score->service->title)){echo $score->service->title;} ?>
					            	</span>
					            </div>
					          </div>  <!-- end "col-md-6" -->
					        </div>  <!-- end "box-body" -->	
					        @endif		

							<div class="col-md-12">
					        	<hr /> <!-- горизонтальная линия -->
					        </div>  <!-- end "col-md-12" -->


					      </div>
					      <!-- /.box -->


					</div><!--/Данные пользователя-->
				
				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Нет подробной информации по транзакции</label>
					</div>
				@endif	
				
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection