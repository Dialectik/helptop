@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Категории
        
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
              <h3 class="box-title">Листинг категорий</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('categories.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название категории</th>
                  <th>Код</th>
                  <th>Раздел</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
					<tr>
	                  <td>{{$category->id}}</td>
	                  <td>{{$category->title}}</td>
	                  <td>{{$category->code}}</td>
	                  <td>{{$category->getSectionTitle()}}</td>
	                  <td><a href="{{route('categories.edit', $category->id)}}" class="fa fa-pencil"></a>
					  
					  <form method="POST" action="{{ route('categories.destroy') }}">
		  				@csrf
		  				<input type="hidden" name="id" value ="{{$category->id}}">
	                  
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