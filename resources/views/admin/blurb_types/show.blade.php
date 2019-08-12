@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Рекламные опции       
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
              <h3 class="box-title">Просмотр рекламных опций</h3>
            </div> <!-- /.box-header -->

            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Рекламный пакет</th>
                  <th>3 дня</th>
                  <th>7 дней</th>
                  <th>14 дней</th>
                  <th>21 день</th>
                  <th>28 дней</th>
                </tr>
                </thead>
                <tbody>
	                @foreach($blurb_types as $blurb_type)
						@if($blurb_type->id == 1 || $blurb_type->id == 6 || $blurb_type->id == 11)
							<tr>
			                	<td>{{$blurb_type->type_blurb}}</td>
		                @endif
		                	<td>{{$blurb_type->blurb_price}}</td>
						@if($blurb_type->id == 5 || $blurb_type->id == 10 || $blurb_type->id == 15)
		               		</tr>
		                @endif
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