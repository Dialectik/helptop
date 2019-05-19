@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Типы торгов
        
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
              <h3 class="box-title">Листинг типов торгов</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('bidding_type.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название типа торгов</th>
                  <th>Код</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bidding_types as $bidding_type)
					<tr>
	                  <td>{{$bidding_type->id}}</td>
	                  <td>{{$bidding_type->title}}</td>
	                  <td>{{$bidding_type->code}}</td>
	                  <td><a href="{{route('bidding_type.edit', $bidding_type->id)}}" class="fa fa-pencil"></a>
					  
					  <form method="POST" action="{{ route('bidding_type.destroy', $bidding_type->id) }}">
		  				@csrf
		  				<input type="hidden" name="_method" value="DELETE">

		                  <button onclick="return confirm('are you sure?')" type="submit" class="delete">
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

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection