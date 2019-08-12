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

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Листинг сущности</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('users.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Имя</th>
                  <th>E-mail</th>
                  <th>Статусы</th>
                  <th>Аватар</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
	                <tr>
	                  <td>{{$user->id}}</td>
	                  <td><a href="{{ route('users.editstatus', $user->id) }}">{{$user->name}}</a></td>
	                  <td>{{$user->email}}</td>
	                  <td>
	                  	<!--Админ-->
	                  	@if($user->is_admin == 1)
	                  		<a class="fa fa-key" title="Админ" href="{{ route('users.editstatus', $user->id) }}"></a>
	                  	@endif
	                  	<!--Модератор-->
	                  	@if($user->is_moder == 1)
	                  		<a class="fa fa-camera" title="Модератор" href="{{ route('users.editstatus', $user->id) }}"></a>
	                  	@endif
	                  	<!--Агент-->
	                  	@if($user->is_agent == 1)
	                  		<a class="fa fa-user" title="Агент" href="{{ route('users.editstatus', $user->id) }}"></a>
	                  	@endif
	                  	<!--Забанен-->
	                  	@if($user->status_ban == 1)
	                  		<a class="fa fa-ban" title="Забанен" href="{{ route('users.editstatus', $user->id) }}"></a>
	                  	@endif
	                  	<!--Активирован-->
	                  	@if($user->activated == 1)
	                  		<a class="fa fa-flag-o" title="Активирован" href="{{ route('users.editstatus', $user->id) }}"></a>
	                  	@endif
	                  </td>
	                  <td>
	                    <img src="{{$user->getImage()}}" alt="" class="img-responsive" width="150">
	                  </td>
	                  <td>
	                  	  <a href="{{route('users.edit', $user->id)}}" class="fa fa-pencil" title="Изменить профиль"></a>
		                  <form method="POST" action="{{ route('users.destroy', $user->id) }}">
			  				@csrf
			                  <input type="hidden" name="_method" value="DELETE">
			                  <button title="Удалить профиль" onclick="return confirm('Are you sure? Точно видалити?')" type="submit" class="delete">
			                   	<i class="fa fa-remove"></i>
			                  </button>
		                  </form>
		                  <a href="{{route('ratingusers.edit', $user->id)}}" class="fa fa-heart" title="Рейтинг пользователя"></a>
		                  <a href="{{route('scoreusers.show', $user->id)}}" class="fa fa-credit-card" title="Счет пользователя"></a>
		                  
		                  
	                  </td>
	                </tr>
                @endforeach

                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection