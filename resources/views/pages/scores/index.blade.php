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
				  <li class="active">Счет</li>
				</ol>
			</div>
			
			<div class="heading">
				<div class="col-sm-12">
	               <div class="cart_info">
	               	<div class="col-sm-4">
	               		<h2 title="Знак минус означает задолженность">Баланс</h2>
	               	</div>
	               	<div class="col-sm-4">
	               		<h2 style="color: #FE980F; font-weight: bold; " title="Знак минус означает задолженность"><?php if(null != $score){echo $score->balance;}else{echo '0';} ?> грн</h2>
	               	</div>
	               	<div class="col-sm-4">
	               		<form method="POST" action="{{ route('scores.refill') }}" > 
							@csrf
							<input type="hidden" name="_method" value="POST">
							<input type="hidden" name="user_id" value="{{ $user_id }}">
	               			<h2><button type="submit" class="btn1" onclick="return confirm('Are you sure?')">Пополнить</button></h2>
	               		</form>
	               	</div>
	               </div>
					
					<p>&nbsp; </p>
					
					@if(null != $score)
							<div class="cart_info">
								<table id="myTable" >
									<thead>
										<tr class="cart_menu" style="text-align: center;">
											<td title="Нажмите для сортировки">Номер транзакции</td>
											<td title="Нажмите для сортировки">Дата / Время</td>
											<td title="Нажмите для сортировки">Поступило средств, грн</td>
											<td title="Нажмите для сортировки">Снято средств, грн</td>
											<td title="Нажмите для сортировки">Вид транзакции</td>
											<td title="Нажмите для сортировки">Баланс, грн</td>
											<td >Действия</td>
										</tr>
									</thead>
									<tbody>
										@foreach($scores as $score)
											<tr style="text-align: center;">
												<td style="font-size: 90%;">
													{{ isset($score->id) ? $score->id : '' }}
												</td>
												<td >
													{{ $score->getDateAttributeYmd($score->date_trans, $date_offset) }}
												</td>
												<td style="font-size: 90%;">
													{{ isset($score->refill) ? $score->refill : '-' }}
												</td>
												<td style="font-size: 90%;">
													{{ isset($score->expense) ? $score->expense : '-' }}
												</td>
												<td style="font-size: 90%;">
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
												</td>												
												<td style="text-align: center; font-size: 90%;">
													{{ isset($score->balance) ? $score->balance : '-' }}
												</td>
												<td style="text-align: center; margin: 10px">
								                   <a href="{{ route('scores.show', $score->id) }}" class="fa fa-eye" title="Подробнее"></a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							
							</div>

		            @else
		            	<div class="table-responsive cart_info">
							Нет транзакций по данному счету
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
	    $('#myTable').DataTable({
   		"order": [[ 1, 'desc' ]]
		});
	});
</script>


<!--Форматирование таблиц-->
<script src="/js/table/jquery.dataTables.min.js"></script>





@endpush