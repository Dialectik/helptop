@push('styles')

<!--Форматирование таблиц-->
	<link href="/css/table/jquery.dataTables.min.css" rel="stylesheet">

<!--Мигание текста выбранного элемента-->
<style>
	#testElement {
	-webkit-animation:name 2s infinite;
	animation:name 2s infinite;   
	}

	@-webkit-keyframes name
	{
	0% {background-color:#ffffff;}
	100% {background-color:#4fb328;}
	0% {color:#737b7a;}
	100% {color:#ffffff;}
	}
	    @keyframes name {
	        0% {background-color:#ffffff;}
	        100% {background-color:#4fb328;}
	        0% {color:#737b7a;}
			100% {color:#ffffff;}
	    }
</style>
	
@endpush


@extends('layouts.app_a')

@section('content')
	<section id="cart_items">
		<div class="container">
			<!-- Путь -->
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('welcome') }}">@lang('layouts.home')</a></li>
				  <li class="active"> Сообщения</li>
				</ol>
			</div>
					<?php if(isset($messages)){foreach($messages as $mes){if($id = $mes->id){	}	};} ?>
			
			@if(isset($user_id) && $user_id == Auth::user()->id && isset($id))
			<!-- Основная информация -->
			<div class="category-tab shop-details-tab"><!--category-tab-->
				<div class="col-sm-12">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#public" data-toggle="tab">
						  	<i class="fa fa-reply"></i>&nbsp;&nbsp;
							Полученные
						</a></li>
						<li ><a href="#archive" data-toggle="tab">
						  	<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;
							Отправленные
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
					                  <th title="Нажмите для сортировки">Пользователь</th>
					                  <th title="Нажмите для сортировки">Объявление услуги</th>
					                  <th title="Нажмите для сортировки">Дата сообщения </th>
					                  <th>Действия</th>
					                </tr>
					                </thead>
					                <tbody>

									<?php 
										$message_arr = array();
									?>
					                @foreach($answer_messages as $a_message)
					                @if(!in_array($a_message->service_id, $message_arr))
						                <tr>
						                  <td>{{$a_message->user->name}}</td>
						                  <td>
						                  	<b>
						                  		<?php
						                  			echo $a_message->getServiceTitle();
						                  		?>
						                  	</b><br/>
						                  		<?php
						                  			echo $a_message->getMessage($a_message->id);
						                  		?>
						                  </td>
						                  <td>{{$a_message->getDateAttributeYmd($a_message->getDate($a_message->id), $date_offset)}}</td>
						                  <td style="text-align: center; margin: 10px">
									  		<div style="display: inline-block;" <?php if(isset($service_mark) && null != $service_mark && $service_mark == $a_message->service_id) echo $message_mark ?>>
									  			<a href="{{route('messages.show', $a_message->id)}}" class="fa fa-eye" title="Подробнее"  ></a>
									  		</div>&nbsp;&nbsp;&nbsp;&nbsp;
									  		<div style="display: inline-block;">
										  		<form method="POST" action="{{ route('messages.destroy', $a_message->id) }}">
													@csrf
													<input type="hidden" name="_method" value="DELETE">
													<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
														<i class="fa fa-times"></i>
													</button>
							                   </form>
						                   </div>
						                  </td>
						                </tr>
					                @endif
					                <?php 
					                	array_push($message_arr, $a_message->service_id); 
					                ?>
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
					                  <th title="Нажмите для сортировки">Пользователь</th>
					                  <th title="Нажмите для сортировки">Объявление услуги</th>
					                  <th title="Нажмите для сортировки">Дата сообщения </th>
					                  <th>Действия</th>
					                </tr>
					                </thead>
					                <tbody>


					                <?php 
										$message_arr1 = array();
									?>
					                @foreach($messages as $message)
					                @if(!in_array($message->service_id, $message_arr1))
						                <tr>
						                  <td>{{$message->user->name}}</td>
						                  <td>
						                  	<b>
						                  		<?php
						                  			echo $message->getServiceTitle();
						                  		?>
						                  	</b><br/>
						                  		<?php
						                  			echo $message->getMessage($message->id);
						                  		?>
						                  </td>
						                  <td>{{$message->getDateAttributeYmd($message->getDate($message->id), $date_offset)}}</td>
						                  <td style="text-align: center; margin: 10px">
									  		<div style="display: inline-block;">
									  			<a href="{{route('messages.show', $message->id)}}" class="fa fa-eye" title="Подробнее"></a>
									  		</div>&nbsp;&nbsp;&nbsp;&nbsp;
									  		<div style="display: inline-block;">
										  		<form method="POST" action="{{ route('messages.destroy', $message->id) }}">
													@csrf
													<input type="hidden" name="_method" value="DELETE">
													<button onclick="return confirm('Are you sure?')" type="submit" class="delete fa fa-remove" title="Удалить">
														<i class="fa fa-times"></i>
													</button>
							                   </form>
						                   </div>
						                  </td>
						                </tr>
					                @endif
					                <?php 
					                	array_push($message_arr1, $message->service_id); 
					                ?>
					                @endforeach

					                </tbody>
					              </table>
					            </div> <!--/"box-body"-->
					            <!-- /.box-body -->
					          </div>
					      <!-- /.box -->
					</div> <!--/archive-->
				</div>
			</div><!--/category-tab-->
			<!-- /Основная информация  -->
			

            @elseif(isset($user_id) && $user_id == Auth::user()->id && !isset($id))
            	<div class="table-responsive cart_info">
					У Вас нет сообщений
				</div>
            @else
            	Перед использованием сервиса необходимо 
            	<a class="nav-link" href="/login">войти</a>
            	 или 
            	 <a class="nav-link" href="/register">зарегистрироваться</a>
            @endif
			
		</div>  <!-- /"container" -->
	</section>

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