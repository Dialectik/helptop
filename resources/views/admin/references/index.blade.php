@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Справочные материалы        
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
              <h3 class="box-title">Листинг справочных материалов</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('references.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название справочных материалов</th>
                  <th>Раздел справки</th>
                  <th>Обновлено</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($references as $reference)
					<tr>
	                  <td>{{$reference->id}}</td>
	                  <td>{{$reference->title}}</td>
	                  <td>{{$reference->section_ref}}</td>
	                  <td>{{$reference->updated_at}}</td>
	                  <td><a href="{{route('references.edit', $reference->id)}}" class="fa fa-pencil"></a>
					  
					  <form method="POST" action="{{ route('references.destroy', $reference->id) }}">
		  				@csrf
		  				<input type="hidden" name="_method" value="DELETE">
	                  
		                  <button onclick="return confirm('are you sure?')" type="submit" class="delete">
		                   <i class="fa fa-remove"></i>
		                  </button>

	                   </form>
	                   
	                   <a href="{{route('references.show', $reference->id)}}" class="fa fa-eye"></a>

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