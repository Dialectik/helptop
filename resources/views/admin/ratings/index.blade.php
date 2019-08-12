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
		<p>&nbsp;</p>
        <p>&nbsp;</p>
      @if(null != $ratings )  <!-- Проверка иммеется ли рейтинг у пользователя -->
      
      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Рейтинг пользователя {{ null != $user_name ? $user_name : '' }}</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
<!--              <div class="form-group">
                <a href="{{route('users.create')}}" class="btn btn-success">Добавить</a>
              </div>-->
              
              
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID отзыва</th>
                  <th>Текущий рейтинг</th>
                  <th>Сделка</th>
                  <th>Услуга</th>
                  <th>ID услуги</th>
                  <th>Аудитор</th>
                  <th>Текст отзыва</th>
                  <th>Ответ</th>
                  <th>Статус</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ratings as $rating)
	                <tr>
	                  <td>{{$rating->id}}</td>
	                  <td>{{$rating->rating_star}} %</td>
	                  <td>{{$deal_code}}</td>
	                  <td><a href="{{ route('service.show', $rating->service_id) }}">{{$rating->service->title}}</a></td>
	                  <td>{{$rating->service_id}}</td>
	                  <td>{{ $rating->auditorUser->name }}</td>
	                  <td>{{ $rating->review }}</td>
	                  <td>{{ $rating->message }}</td>
	                  <td><?php
	                  	switch ($rating->status) {
						  case '1':
						    echo 'Действующий';
						    break;
						  case '2':
						    echo 'Аннулирован';
						    break;
						  default:
						    break;
						}
	                  ?></td>
	                  <td>
		                  <form method="POST" action="{{ route('ratingusers.destroy', $rating->id) }}">
			  				@csrf
			                  <input type="hidden" name="_method" value="DELETE">
			                  
			                  <button onclick="return confirm('Are you sure? Точно видалити?')" type="submit" class="delete">
			                   	<i class="fa fa-remove"></i>
			                  </button>
		                  </form>
		                  
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
		Пользователь не имеет рейтинга
	  @endif

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection