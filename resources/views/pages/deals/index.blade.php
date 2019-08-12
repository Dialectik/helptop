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
				  <li class="active">Сделки</li>
				</ol>
			</div>
			
			<div class="heading">
				<div class="col-sm-12">
	                <p>&nbsp; </p>
					
					@if($deals_is == 1)
							<div class="cart_info">
								<table id="myTable" >
									<thead>
										<tr class="cart_menu" style="text-align: center;">
											<td title="Нажмите для сортировки">Номер сделки</td>
											<td class="image" ></td>
											<td title="Нажмите для сортировки">Услуга</td>
											<td title="Нажмите для сортировки">@lang('layouts.bidding_types')</td>
											<td title="Нажмите для сортировки">Статус сделки</td>
											<td title="Нажмите для сортировки">В этой услуге <b>Вы</b></td>
											<td title="Нажмите для сортировки">Автор услуги</td>
											<td class="total" title="Нажмите для сортировки">Стоимость сделки</td>
											<td title="Нажмите для сортировки">Закрытие сделки</td>
											<td >Действия</td>
										</tr>
									</thead>
									<tbody>
										@foreach($deals as $deal)
											<tr>
												<td style="font-size: 90%;">
													<?php
														if($deal->id){
															if($deal->id < 10){
																echo '0' . '0' . '0' . '0' . '0' . '0' . '0' . $deal->id;
															}elseif($deal->id < 100){
																echo '0' . '0' . '0' . '0' . '0' . '0' . $deal->id;
															}elseif($deal->id < 1000){
																echo '0' . '0' . '0' . '0' . '0' . $deal->id;
															}elseif($deal->id < 10000){
																echo '0' . '0' . '0' . '0' . $deal->id;
															}elseif($deal->id < 100000){
																echo '0' . '0' . '0' . $deal->id;
															}elseif($deal->id < 1000000){
																echo '0' . '0' . $deal->id;
															}elseif($deal->id < 10000000){
																echo '0' . $deal->id;
															}else{
																echo $deal->id;
															}
														}
													?>
												</td>
													
												<td >
													<a href="{{ route('service.show', $deal->service_id) }}" >
													<img src="{{ $deal->getImage() }}" alt="" style="width: 120px" />
													</a>
												</td>
												<td style="font-size: 90%;">
													<a href="{{ route('service.show', $deal->service_id) }}" >
													{{ isset($deal->service->title) ? $deal->service->title : '' }}
													</a>
												</td>
												<td style="font-size: 80%;">
													<?php
								              			switch ($deal->bidding_type) {
														  case '2':
														    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
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
														    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i> <i class="fa fa-gavel" aria-hidden="true"></i>';
														    break;
														  case '7':
														    echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <i class="fa fa-bar-chart-o" aria-hidden="true"></i>';
														    break;
														  default:
														    break;
														}
								              		?>
													{{ $deal->biddingTypeTitle() }}
												</td>
												<td style="font-size: 80%;">
													<?php
								              			switch ($deal->status_deal) {
														  case '1':
														    echo 'В процессе';
														    break;
														  case '2':
														    echo 'Успешно завершена';
														    break;
														  case '3':
														    echo 'Заверена продавцом';
														    break;
														  case '4':
														    echo 'Заверена покупателем';
														    break;
														  case '5':
														    echo 'Аннулирована';
														    break;
														  default:
														    break;
														}
								              		?>
												</td>												
												<td style="text-align: center; font-size: 90%;">
													<b>
													@if(Auth::user()->id == $deal->user_seller_id)
														Поставщик
													@else
														Заказчик
													@endif
													</b>
												</td>
												<td style="text-align: center; font-size: 80%;">
													@if(Auth::user()->id == $deal->author)
														<b>Вы</b>
														@if(Auth::user()->id == $deal->user_seller_id)
															(Продавец)
														@else
															(Покупатель)
														@endif
													@else	
														<a href="" title="{{ isset($deal->authorUser->firm) ? $deal->authorUser->firm : '' }}">
															<b>{{ $deal->authorUser->name }}</b>
														</a>
														@if($deal->author == $deal->user_seller_id)
															(Продавец)
														@else
															(Покупатель)
														@endif
													@endif
													
													
												</td>												
												<td style="text-align: center;">{{ $deal->total_cost }} грн</td>												
												<td style="text-align: center; font-size: 90%;">{{ $deal->getDateWH($deal->date_deadline, $date_offset) }}</td>
												<td style="text-align: center; margin: 10px">
													@if($deal->status_deal != 5)
														<a href="{{route('deals.edit', $deal->id)}}" class="fa fa-pencil" style="margin: 10px" title="Действия по сделке"></a>
													@endif
													@if($deal->status_deal == 5 && Auth::user()->id == $deal->author)
														<form method="POST" action="{{ route('deals.destroy', $deal->id) }}">
															@csrf
															<input type="hidden" name="_method" value="DELETE">
									                  
															<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
																<i class="fa fa-times"></i>
															</button>
									                   </form>
									                @endif
								                   <a href="{{route('deals.show', $deal->id)}}" class="fa fa-eye" title="Подробнее"></a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							
							
							
							
							</div>
							
		            @elseif($deals_is == 2)
		            	Перед использованием сервиса необходимо 
		            	<a class="nav-link" href="/login">войти</a>
		            	 или 
		            	 <a class="nav-link" href="/register">зарегистрироваться</a>
		            @else
		            	<div class="table-responsive cart_info">
							Нет текущих сделок
						</div>
		            @endif
	                <p>&nbsp; </p>
	                <p>&nbsp; </p>
				</div>
			</div>
		</div>
	</section>

@endsection


@push('scripts')

<script>
	$(document).ready( function () {
	    $('#myTable').DataTable();
	} );
</script>


<!--Форматирование таблиц-->
<script src="/js/table/jquery.dataTables.min.js"></script>





@endpush