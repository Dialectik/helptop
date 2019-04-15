@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить категорию
        
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
      
    	<form method="POST" action="{{ route('categories.store') }}">
		  	@csrf
		  
		    <div class="box-header with-border">
		      <h3 class="box-title">Категория входит в один из РАЗДЕЛОВ</h3>
		      @include('admin.errors')
		    </div>
		    <div class="box-body">
		      <div class="col-md-6">
		        <div class="form-group">
		          <label for="exampleInputEmail1">Название КАТЕГОРИИ</label>
		          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title">
		        </div>
		      </div>
		    </div>
		    
		    	<!-- Раздел -->
	        <div class="col-md-4">
	            <div class="form-group">
	              <label>Раздел</label>
	              <p><small>Определите в какой раздел входит категория</small></p>
		              <select class="form-control select2" name="section_id" style="width: 100%;">
			              	@foreach($sections as $section)
		                		<option value="{{$section->id}}">{{$section->title}}</option>
		              		@endforeach
		              </select>
	            </div>
	         </div>
		    
		    <!-- /.box-body -->
		    <div class="box-footer">
		       <button class="btn btn-success">Добавить</button>
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