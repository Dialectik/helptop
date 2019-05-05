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
                <a href="{{route('services.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название</th>
                  <th>Дата начала публикации</th>
                  <th>Дата завершения публикации </th>
                  <th>Вид услуги</th>
                  <th>Картинка</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                <tr>
                  <td>{{$service->id}}</td>
                  <td>{{$service->title}}</td>
                  <td>{{$service->getDateAttribute($service->date_on, $date_offset)}}</td>
                  <td>{{$service->getDateAttribute($service->date_off, $date_offset)}}</td>
                  <td>{{$service->getKindTitle()}}</td>
                  <td>
                    <img src="{{$service->getImage()}}" alt="" width="100">
                  </td>
                  <td>
	                  <a href="{{route('services.edit', $service->id)}}" class="fa fa-pencil"></a> 
					  
					  <form method="POST" action="{{ route('services.destroy', $service->id) }}">
			  			@csrf
			  			<input type="hidden" name="_method" value="DELETE">
		                  <button onclick="return confirm('are you sure?')" type="submit" class="delete">
		            		<i class="fa fa-remove"></i>
		                  </button>
		              </form>
                  </td>
                </tr>
                @endforeach
                </tfoot>
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