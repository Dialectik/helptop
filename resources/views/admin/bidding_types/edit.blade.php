@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить тип торгов
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем тип торгов</h3>
          @include('admin.errors')
        </div>
        
        <form method="POST" action="{{ route('bidding_type.update', $bidding_type->id) }}">
		  	@csrf
		  	<input type="hidden" name="_method" value="PUT">
		  	
		  	
	        <div class="box-body">
	          <div class="col-md-6">
	            <div class="form-group">
	              <label for="exampleInputEmail1">Название типа торгов</label>
	              <input type="text" class="form-control" id="title" name="title" placeholder="" value="{{$bidding_type->title}}">
	            </div>
	          </div>
	          <div class="col-md-1">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Код</label>
		          <input type="text" class="form-control" id="code" placeholder="XX" name="code" maxlength="2" minlength="2" value="{{$bidding_type->code}}">
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

@push('scripts')
<!-- Ограничение поля ввода кода раздела ЦИФРАМИ -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		$.fn.forceNumbericOnly = function() {
			return this.each(function()
			{
			    $(this).keydown(function(e)
			    {
			        var key = e.charCode || e.keyCode || 0;
			        return ( key == 8 || key == 9 || key == 46 ||(key >= 37 && key <= 40) ||(key >= 48 && key <= 57) ||(key >= 96 && key <= 105) || key == 107 || key == 109 || key == 173|| key == 61  ); 
			        });
				});
			};
		$('#code').forceNumbericOnly();
	});
</script>
@endpush