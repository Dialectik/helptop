@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blank page
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
	  @if(isset($score->id))
      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Счет пользователя {{ $score->user->name }}</h3>
            </div>
            @if(session('status'))
                <div class="alert alert-info">
                    <?php echo session('status') ?>
                </div>
            @endif
            
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <form method="POST" action="{{ route('scoreusers.create') }}" > 
			  		@csrf
					<input type="hidden" name="_method" value="POST" >
					<input type="hidden" name="user_id" value="{{ $user_id }}" >
					<button class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Создать новый счет</button>
                </form>
              </div>
				<table id="example3" class="table table-bordered table-striped" >
					<thead>
						<tr class="cart_menu" style="text-align: center;">
							<td title="Нажмите для сортировки">Номер транзакции</td>
							<td title="Нажмите для сортировки">Дата</td>
							<td title="Нажмите для сортировки">Поступило средств, грн</td>
							<td title="Нажмите для сортировки">Снято средств, грн</td>
							<td title="Нажмите для сортировки">Вид транзакции</td>
							<td title="Нажмите для сортировки">Баланс, грн</td>
							<td >Действия</td>
						</tr>
					</thead>
					<tbody>
						@foreach($scores as $score)
							<tr>
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
										  case null:
											echo 'Сбой! Ошибка!';
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
				                   <a href="{{ route('scoreusers.showone', $score->id) }}" class="fa fa-eye" title="Подробнее"></a>
				                   <a href="{{ route('scoreusers.edit', $score->id) }}" class="fa fa-pencil" title="Изменить"></a>
				                   @if($score->cause == null)
									  <form method="POST" action="{{ route('scoreusers.destroy', $score->id) }}">
						  				@csrf
						                  <input type="hidden" name="_method" value="DELETE">
						                  <button onclick="return confirm('Are you sure? Точно видалити?')" type="submit" class="delete">
						                   	<i class="fa fa-remove"></i>
						                  </button>
					                  </form>
				                   @endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    @else
    	<p>&nbsp;</p>
    	<p>&nbsp;</p>
    	Нет транзакций по данному счету
    @endif
    
    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@push('scripts')

<script>
	$(document).ready( function () {
	    $('#example3').DataTable({
   		"order": [[ 1, 'desc' ]]
		});
	});
</script>

@endpush