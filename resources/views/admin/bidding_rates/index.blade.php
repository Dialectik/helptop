@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Выставление услуг на торги        
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
              <h3 class="box-title">Листинг платных опций торгов</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('bidding_rates.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Тип торгов</th>
                  <th>Начальная цена диапазона</th>
                  <th>Конечная цена диапазона</th>
                  <th>Тариф выставления услуги</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bidding_rates as $bidding_rate)
					<tr>
	                  <td>{{$bidding_rate->id}}</td>
	                  <td>{{$bidding_rate->biddingTypeTitle()}}</td>
	                  <td>{{$bidding_rate->price_start}}</td>
	                  <td>{{$bidding_rate->price_end}}</td>
	                  <td>{{$bidding_rate->rate_bidding}}</td>
	                  <td><a href="{{route('bidding_rates.edit', $bidding_rate->id)}}" class="fa fa-pencil"></a>
					  
					  <form method="POST" action="{{ route('bidding_rates.destroy', $bidding_rate->id) }}">
		  				@csrf
		  				<input type="hidden" name="_method" value="DELETE">
	                  
		                  <button onclick="return confirm('are you sure?')" type="submit" class="delete">
		                   <i class="fa fa-remove"></i>
		                  </button>

	                   </form>
	                   
	                   <a href="{{route('bidding_rates.show', $bidding_rate->id)}}" class="fa fa-eye"></a>

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