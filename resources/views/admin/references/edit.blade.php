@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить раздел справки
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем раздел справки</h3>
          @include('admin.errors')
        </div>
        
        <form method="POST" action="{{ route('references.update', $reference->id) }}">
		  	@csrf
		  	<input type="hidden" name="_method" value="PUT">
		  	
	        <div class="box-body">
	          <!-- Название раздела справки -->
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название раздела справки</label>
	              <input type="text" class="form-control" id="title" name="title" placeholder="" value="{{$reference->title}}">
	            </div>
	          </div>
	          <!-- Раздел справки -->
	          <div class="col-md-1">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Раздел справки</label>
		          <input type="text" class="form-control" id="section_ref" name="section_ref" value="{{$reference->section_ref}}">
		        </div>
		      </div> 
	        </div>  <!-- /"box-body" -->
	        <!-- Текст справки -->
	        <div class="box-body">
		        <div class="col-md-10">
		            <div class="form-group">
		              <label for="exampleInputEmail1">Текст справки</label>
		              <textarea name="content" id="content" cols="30" rows="50" class="form-control" required >{{ $reference->content }}</textarea>
			        </div>
			      </div>
			</div> <!-- /"box-body" -->
			
			
	        
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


@push('scripts')
<!-- Подключение текстового редактора -->
<script>
    $(document).ready(function(){
        var editor_sc = CKEDITOR.replaceAll();
        CKFinder.setupCKEditor( editor_sc );
    })
</script>
@endpush