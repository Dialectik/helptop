@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Стоимость рекламных опций        
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
              <h3 class="box-title">Листинг рекламных опций</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('blurb_types.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название вида рекламы</th>
                  <th>Рекламный пакет</th>
                  <th>Период предоставления рекламы</th>
                  <th>Код вида рекламы</th>
                  <th>Стоимость вида рекламы</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blurb_types as $blurb_type)
					<tr>
	                  <td>{{$blurb_type->id}}</td>
	                  <td>{{$blurb_type->title}}</td>
	                  <td>{{$blurb_type->type_blurb}}</td>
	                  <td>{{$blurb_type->period_blurb}}</td>
	                  <td>{{$blurb_type->code}}</td>
	                  <td>{{$blurb_type->blurb_price}}</td>
	                  <td><a href="{{route('blurb_types.edit', $blurb_type->id)}}" class="fa fa-pencil"></a>
					  
					  <form method="POST" action="{{ route('blurb_types.destroy', $blurb_type->id) }}">
		  				@csrf
		  				<input type="hidden" name="_method" value="DELETE">
	                  
		                  <button onclick="return confirm('are you sure?')" type="submit" class="delete">
		                   <i class="fa fa-remove"></i>
		                  </button>

	                   </form>
	                   
	                   <a href="{{route('blurb_types.show', $blurb_type->id)}}" class="fa fa-eye"></a>

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