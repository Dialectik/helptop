@push('styles')

	<!--Форматирование таблиц-->
	<link href="/css/table/jquery.dataTables.min.css" rel="stylesheet">
	

@endpush

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
						  <li><a href="{{ route('myprofile.index') }}">@lang('layouts.pers_data')</a></li>
						  
						  <li class="active">
						  	@if($sell_buy == 1)
						  		<i class="fa fa-gavel"></i>&nbsp;&nbsp; Мои продажи (
						  	@elseif($sell_buy == 2)
						  		<i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp; Мои заявки на покупку (
						    @endif
						  	
						  	@if(null != $user->id && $user->id == Auth::user()->id)
								<b>{{ $user->name }}</b>
			            	@endif
			            	)
						  </li>
						  
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	
	
	<!-- Content Wrapper. Contains page content -->
	<section >
		<div class="container">

			@if(session('status'))
                <div class="alert alert-info">
                    <?php echo session('status') ?>
                </div>
            @endif
				

			    	<div class="form-group">
						@if($sell_buy == 1)					  		
					  		<a href="{{route('service.mysell.create')}}" class="btn1"><i class="fa fa-gavel"></i>&nbsp;&nbsp; Создать новую услугу Продажи</a>
					  	@elseif($sell_buy == 2)
					  		<a href="{{route('service.mybuy.create')}}" class="btn1"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp; Создать новую заявку на Покупку услуги</a>
					    @endif
						
						
					</div>
				<!--Показывать страницу только если найден пользователь-->
				@if(null != $user->id && $user->id == Auth::user()->id)
				<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#public" data-toggle="tab">
								  	<i class="fa fa-rss"></i>&nbsp;&nbsp;
									Опубликованные
								</a></li>
								<li><a href="#archive" data-toggle="tab">
								  	<i class="fa fa-ban"></i>&nbsp;&nbsp;
									Архивные
								</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="public" > <!--public-->
								<!-- Default box -->
							      <div class="box">
							            <!-- /.box-header -->
							            <div class="box-body">
							              <table id="myTable" style="font-size: 95%">
							                <thead>
							                <tr>
							                  <th title="Нажмите для сортировки">ID</th>
							                  <th title="Нажмите для сортировки">Название</th>
							                  <th title="Нажмите для сортировки">Дата завер-шения пуб-ликации </th>
							                  <th title="Нажмите для сортировки">Вид услуги</th>
							                  <th title="Нажмите для сортировки">Кол-во единиц</th>
							                  <th title="Нажмите для сортировки">Теку-щая цена (Аук-цион/ Тендер), грн</th>
							                  <th title="Нажмите для сортировки">Фикс. цена, грн</th>
							                  <th title="Нажмите для сортировки">Публи-кация</th>
							                  <th title="Нажмите для сортировки">Рек-лама</th>
							                  <th>Дейс-твия</th>
							                </tr>
							                </thead>
							                <tbody>


							                @foreach($services as $service)
							                <tr>
							                  <td>{{$service->id}}</td>
							                  <td>
							                  	<a href="{{route('service.show', $service->id)}}" title="Товарный код услуги: {{substr($service->product_code_id, 0, 6) . '-' . substr($service->product_code_id, 6, 4)}}">{{$service->title}}</a>
							                  </td>
							                  <td title="Дата начала публикации: {{$service->getDateAttributeYmd($service->date_on, $date_offset)}}">{{$service->getDateAttributeYmd($service->date_off, $date_offset)}}</td>
							                  <td title="Раздел: {{$service->getSectionTitle()}}">{{$service->getKindTitle()}}</td>
							                  <td>{{ $service->number_total }}</td>
							                  <td title="Тип торгов: {{ $service->biddingTypeTitle() }}">{{ $service->price_current }}</td>
							                  <td title="Тип торгов: {{ $service->biddingTypeTitle() }}">
							                  	@if($service->bidding_type == 2 || $service->bidding_type == 6)
													{{ $service->price_buy_now }}
												@endif
												@if($service->bidding_type == 3 || $service->bidding_type == 7)
													{{ $service->price_sell_now }}
												@endif								
							                  </td >
							                  <td>
							                  	<?php 
									              	if(null != $service->rate_bidding_id){echo $service->getRateBiddingTitle();}
									            ?>
							                  </td>
							                  <td>
							                  	<a href="<?php if($service->getBlurbID()) {echo route('blurbs.show', $service->getBlurbID());} ?>"><?php 
									              	if(null != $service->blurb_type_id){echo $service->getBlurbTitle();}
									            ?></a>
							                  </td>
							                  <td style="text-align: center; margin: 10px">
								                @if($service->status != 1 && Auth::user()->id == $service->user_id)
													@if($sell_buy == 1)					  		
												  		<a href="{{route('service.mysell.edit', $service->id)}}" class="fa fa-pencil" style="margin: 10px" title="Редактировать услугу"></a>
												  		<form method="POST" action="{{ route('service.destroymysell', $service->id) }}">
															@csrf
															<input type="hidden" name="_method" value="DELETE">
															<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
																<i class="fa fa-times"></i>
															</button>
									                   </form>
												  	@elseif($sell_buy == 2)
												  		<a href="{{route('service.mybuy.edit', $service->id)}}" class="fa fa-pencil" style="margin: 10px" title="Редактировать услугу"></a>
												  		<form method="POST" action="{{ route('service.destroymybuy', $service->id) }}">
															@csrf
															<input type="hidden" name="_method" value="DELETE">
															<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
																<i class="fa fa-times"></i>
															</button>
									                   </form>
												    @endif
								                @endif
							                    <a href="{{route('service.show', $service->id)}}" class="fa fa-eye" title="Подробнее"></a>
							                    @if($service->status == 1 && Auth::user()->id == $service->user_id && $service->blurb_type_id == null)
													&nbsp;<a href="/service/{{$service->id}}#window5" title="Рекламировать"><i class="fa fa-magnet" aria-hidden="true"></i></a>
												@endif
							                  </td>
							                </tr>
							                @endforeach

							                </tbody>
							              </table>
							              
										
							            
							            </div> <!--/"box-body"-->
							            <!-- /.box-body -->
							          </div>
							      <!-- /.box -->
							</div> <!--/public-->
							
							<div class="tab-pane fade" id="archive" > <!--archive-->
								<!-- Default box -->
							      <div class="box">
							            <!-- /.box-header -->
							            <div class="box-body">

							              <table id="myTable_a" style="font-size: 95%">
							                <thead>
							                <tr>
							                  <th title="Нажмите для сортировки">ID</th>
							                  <th title="Нажмите для сортировки">Название</th>
							                  <th title="Нажмите для сортировки">Дата завер-шения пуб-ликации </th>
							                  <th title="Нажмите для сортировки">Вид услуги</th>
							                  <th title="Нажмите для сортировки">Кол-во единиц</th>
							                  <th title="Нажмите для сортировки">Теку-щая цена (Аук-цион/ Тендер), грн</th>
							                  <th title="Нажмите для сортировки">Фикс. цена, грн</th>
							                  <th title="Нажмите для сортировки">Публи-кация</th>
							                  <th title="Нажмите для сортировки">Рек-лама</th>
							                  <th>Дейс-твия</th>
							                </tr>
							                </thead>
							                <tbody>


							                @foreach($services_a as $service)
							                <tr>
							                  <td>{{$service->id}}</td>
							                  <td>
							                  	<a href="{{route('service.show', $service->id)}}" title="Товарный код услуги: {{substr($service->product_code_id, 0, 6) . '-' . substr($service->product_code_id, 6, 4)}}">{{$service->title}}</a>
							                  </td>
							                  <td title="Дата начала публикации: {{$service->getDateAttributeYmd($service->date_on, $date_offset)}}">{{$service->getDateAttributeYmd($service->date_off, $date_offset)}}</td>
							                  <td title="Раздел: {{$service->getSectionTitle()}}">{{$service->getKindTitle()}}</td>
							                  <td>{{ $service->number_total }}</td>
							                  <td title="Тип торгов: {{ $service->biddingTypeTitle() }}">{{ $service->price_current }}</td>
							                  <td title="Тип торгов: {{ $service->biddingTypeTitle() }}">
							                  	@if($service->bidding_type == 2 || $service->bidding_type == 6)
													{{ $service->price_buy_now }}
												@endif
												@if($service->bidding_type == 3 || $service->bidding_type == 7)
													{{ $service->price_sell_now }}
												@endif								
							                  </td>
							                  <td>
							                  	<?php 
									              	if(null != $service->rate_bidding_id){echo $service->getRateBiddingTitle();}
									            ?>
							                  </td>
							                  <td>
							                  	<?php 
									              	if(null != $service->blurb_id){echo $service->getBlurbTitle();}
									            ?>
							                  </td>
							                  <td style="text-align: center; margin: 10px">
								                @if($service->status != 1 && Auth::user()->id == $service->user_id)
													@if($sell_buy == 1)					  		
												  		<a href="{{route('service.mysell.edit', $service->id)}}" class="fa fa-pencil" style="margin: 10px" title="Редактировать услугу"></a>
												  		<form method="POST" action="{{ route('service.destroymysell', $service->id) }}">
															@csrf
															<input type="hidden" name="_method" value="DELETE">
															<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
																<i class="fa fa-times"></i>
															</button>
									                   </form>
												  	@elseif($sell_buy == 2)
												  		<a href="{{route('service.mybuy.edit', $service->id)}}" class="fa fa-pencil" style="margin: 10px" title="Редактировать услугу"></a>
												  		<form method="POST" action="{{ route('service.destroymybuy', $service->id) }}">
															@csrf
															<input type="hidden" name="_method" value="DELETE">
															<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
																<i class="fa fa-times"></i>
															</button>
									                   </form>
												    @endif
								                @endif
							                    <a href="{{route('service.show', $service->id)}}" class="fa fa-eye" title="Подробнее"></a>
							                    @if($service->status == 1 && Auth::user()->id == $service->user_id && $service->blurb_type_id == null)
													&nbsp;<a href="/service/{{$service->id}}#window5" title="Рекламировать"><i class="fa fa-magnet" aria-hidden="true"></i></a>
												@endif
							                  </td>
							                </tr>
							                @endforeach

							                </tbody>
							              </table>
							              
										
							            
							            </div> <!--/"box-body"-->
							            <!-- /.box-body -->
							          </div>
							      <!-- /.box -->
							</div> <!--/archive-->

						</div>  <!--/"tab-content"-->
					</div><!--/category-tab-->

				@else
					<div class="order-message">
						<p>&nbsp;</p>
						<label style="font-weight:bold;">Страница пользователя не найдена...</label>
					</div>
				@endif	

		</div> <!--/"container"-->
		<p>&nbsp;</p>
		<p>&nbsp;</p>		
	</section>
	<!-- /.content-wrapper -->
@endsection


@push('scripts')

<script>
	$(document).ready( function () {
	    $('#myTable').DataTable({
   		"order": [[ 2, 'desc' ]]
		});
		$('#myTable_a').DataTable({
   		"order": [[ 2, 'desc' ]]
		});
	});
</script>


<!--Форматирование таблиц-->
<script src="/js/table/jquery.dataTables.min.js"></script>

@endpush