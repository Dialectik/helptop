@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить категорию
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем категорию</h3>
          @include('admin.errors')
        </div>
        
        <form method="POST" action="{{ route('categories.update') }}">
		  	@csrf
		  	<input type="hidden" name="id" value ="{{$category->id}}">
		  	
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название</label>
	              <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="" value="{{$category->title}}">
	            </div>
	          </div>
	        </div>
	        
	        	<!-- Раздел -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Измените раздел, в который входит категория</label>
		              <select class="form-control select2" name="section_id" style="width: 100%;">
			              	<option selected="selected" value="{{$category->getSectionID()}}">{{$category->getSectionTitle()}}</option>
			              	@foreach($sections as $section)
		                		<option value="{{$section->id}}">{{$section->title}}</option>
		              		@endforeach
		              </select>
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