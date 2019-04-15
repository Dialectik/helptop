@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить раздел
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем раздел</h3>
          @include('admin.errors')
        </div>
        
        <form method="POST" action="{{ route('sections.update') }}">
		  	@csrf
		  	<input type="hidden" name="id" value ="{{$section->id}}">
		  	
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название раздела</label>
	              <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="" value="{{$section->title}}">
	            </div>
	          </div>
	        </div>
	        <!-- /.box-body -->
	        <div class="box-footer">
	           <button class="btn btn-warning pull-right">Изменить</button>
	        </div>
	        <!-- /.box-footer-->
        </form>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection