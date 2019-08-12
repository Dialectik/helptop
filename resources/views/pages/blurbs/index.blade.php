@push('styles')

	<!--Форматирование таблиц-->
	<link href="/css/table/jquery.dataTables.min.css" rel="stylesheet">
	

@endpush


@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li><a href="{{ route('myprofile.index') }}">@lang('layouts.pers_data')</a></li>
				  <li class="active">Реклама</li>
				</ol>
			</div>
			


	               <div class="cart_info">
	               	<div class="col-sm-4">
	               		<h2>Реклама</h2>
	               	</div>
	               	<div class="col-sm-4" style="padding-top: 25px;">
	               		<a href="{{ route('blurbs.adversell') }}" class="btn1" ><i class="fa fa-gavel"></i>&nbsp;&nbsp; Рекламировать услугу продажи</a>
	               	</div>
	               	<div class="col-sm-4" style="padding-top: 25px;">
	               		<a href="{{ route('blurbs.adverbuy') }}" class="btn1" ><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp; Рекламировать услугу покупки</a>
	               	</div>
	               </div>
					
					<p>&nbsp; </p>
					<?php if(isset($blurbs)){foreach($blurbs as $bl){if($id = $bl->id){ }	};} ?>
					
					@if(isset($id))
						<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#public" data-toggle="tab">
								  	<i class="fa fa-rss"></i>&nbsp;&nbsp;
									Действующая
								</a></li>
								<li><a href="#archive" data-toggle="tab">
								  	<i class="fa fa-ban"></i>&nbsp;&nbsp;
									Архивная
								</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="public" > <!--public-->
								<!-- Default box -->
							    <div class="box">
						            <!-- /.box-header -->
						            <div class="box-body">
										<table id="myTable" >
											<thead>
												<tr class="cart_menu" style="text-align: center;">
													<td title="Нажмите для сортировки">Услуга</td>
													<td title="Нажмите для сортировки">Код услуги</td>
													<td title="Нажмите для сортировки">Тип торгов</td>
													<td title="Нажмите для сортировки">Дата снятия рекламы</td>
													<td title="Нажмите для сортировки">Наз-вание рекламы</td>
													<td >Действия</td>
												</tr>
											</thead>
											<tbody>
												@foreach($blurbs as $blurb)
													<tr >
														<td style="font-size: 90%;">
															<a href="<?php if($blurb->getServiceID()) echo route('service.show', $blurb->getServiceID()) ?>">{{ $blurb->getServiceTitle() }}</a>
														</td>
														<td style="font-size: 90%; text-align: center;">
															<?php echo (substr($blurb->getServiceCode(), 0, 6) . '-' . substr($blurb->getServiceCode(), 6, 4)) ?>
														</td>
														<td style="font-size: 90%; text-align: center;" title="<?php  echo $blurb->biddingTypeTitle()	?>">
															<?php
																switch ($blurb->getServiceBT()) {
																  case '2':
																    echo '<i class="fa fa-shopping-cart" aria-hidden="true">';
																    break;
																  case '3':
																    echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
																    break;
																  case '4':
																    echo '<i class="fa fa-gavel" aria-hidden="true"></i>';
																    break;
																  case '5':
																    echo '<i class="fa fa-bar-chart-o" aria-hidden="true"></i>';
																    break;
																  case '6':
																    echo '<i class="fa fa-gavel" aria-hidden="true"></i> &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true">';
																    break;
																  case '7':
																    echo '<i class="fa fa-bar-chart-o" aria-hidden="true"></i> &nbsp; <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
																    break;
																  default:
																    break;
																}
															?>
														</td>
														<td style="font-size: 90%; text-align: center;" title="Реклама запущена: {{ $blurb->getDateAttributeYmd($blurb->date_on_blurb, $date_offset) }}">
															{{ $blurb->getDateAttributeYmd($blurb->date_off_blurb, $date_offset) }}
														</td>
														<td style="font-size: 90%; text-align: center;" title="Стоимость пакета: {{ $blurb->getBlurbPrice() }} грн">
															<?php 
										              			if(null != $blurb->id){echo $blurb->getBlurbTitle();}
										              		?>
														</td>
														
														<td style="text-align: center; margin: 10px">
										                   <a href="{{ route('blurbs.show', $blurb->id) }}" class="fa fa-eye" title="Подробнее Рекламная опция №{{ $blurb->id }}"></a>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div> <!--/"box-body"-->
							    </div> <!-- /.box -->
							</div> <!--/public-->
							
							<div class="tab-pane fade" id="archive" > <!--archive-->
								<!-- Default box -->
							    <div class="box">
							        <div class="box-body">
							            <table id="myTable_a" >
											<thead>
												<tr class="cart_menu" style="text-align: center;">
													<td title="Нажмите для сортировки">Услуга</td>
													<td title="Нажмите для сортировки">Код услуги</td>
													<td title="Нажмите для сортировки">Тип торгов</td>
													<td title="Нажмите для сортировки">Дата снятия рекламы</td>
													<td title="Нажмите для сортировки">Наз-вание рекламы</td>
													<td >Действия</td>
												</tr>
											</thead>
											<tbody>
												@foreach($blurbs_arr as $blurb)
													<tr >
														<td style="font-size: 90%;">
															<a href="<?php if($blurb->getServiceID()) echo route('service.show', $blurb->getServiceID()) ?>">{{ $blurb->getServiceTitle() }}</a>
														</td>
														<td style="font-size: 90%; text-align: center;">
															<?php echo (substr($blurb->getServiceCode(), 0, 6) . '-' . substr($blurb->getServiceCode(), 6, 4)) ?>
														</td>
														<td style="font-size: 90%; text-align: center;" title="<?php  echo $blurb->biddingTypeTitle()	?>">
															<?php
																switch ($blurb->getServiceBT()) {
																  case '2':
																    echo '<i class="fa fa-shopping-cart" aria-hidden="true">';
																    break;
																  case '3':
																    echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
																    break;
																  case '4':
																    echo '<i class="fa fa-gavel" aria-hidden="true"></i>';
																    break;
																  case '5':
																    echo '<i class="fa fa-bar-chart-o" aria-hidden="true"></i>';
																    break;
																  case '6':
																    echo '<i class="fa fa-gavel" aria-hidden="true"></i> &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true">';
																    break;
																  case '7':
																    echo '<i class="fa fa-bar-chart-o" aria-hidden="true"></i> &nbsp; <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>';
																    break;
																  default:
																    break;
																}
															?>
														</td>
														<td style="font-size: 90%; text-align: center;" title="Реклама запущена: {{ $blurb->getDateAttributeYmd($blurb->date_on_blurb, $date_offset) }}">
															{{ $blurb->getDateAttributeYmd($blurb->date_off_blurb, $date_offset) }}
														</td>
														<td style="font-size: 90%; text-align: center;" title="Стоимость пакета: {{ $blurb->getBlurbPrice() }} грн">
															<?php 
										              			if(null != $blurb->id){echo $blurb->getBlurbTitle();}
										              		?>
														</td>
														
														<td style="text-align: center; margin: 10px">
										                   <a href="{{ route('blurbs.show', $blurb->id) }}" class="fa fa-eye" title="Подробнее Рекламная опция №{{ $blurb->id }}"></a>
										                   <p>&nbsp;</p>
										                   <form method="POST" action="{{ route('blurbs.destroy', $blurb->id) }}">
																@csrf
																<input type="hidden" name="_method" value="DELETE">
																<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
																	<i class="fa fa-times"></i>
																</button>
										                   </form>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
							        </div> <!--/"box-body"-->
							    </div>  <!-- /.box -->
							</div> <!--/archive-->
						</div>  <!--/"tab-content"-->
					</div><!--/category-tab-->
							            
							            
						

		            @else
		            	<div class="table-responsive cart_info">
							У Вас нет ни одной рекламируемой услуги
						</div>
		            @endif
	                <p>&nbsp; </p>
	                <p>&nbsp; </p>


		</div>
	</section>

@endsection


@push('scripts')

<script>
	$(document).ready( function () {
	    $('#myTable').DataTable({
   		"order": [[ 3, 'desc' ]]
		});
		$('#myTable_a').DataTable({
   		"order": [[ 3, 'desc' ]]
		});
	});
</script>


<!--Форматирование таблиц-->
<script src="/js/table/jquery.dataTables.min.js"></script>


@endpush