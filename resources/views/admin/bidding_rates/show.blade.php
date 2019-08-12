@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Платные опции торгов        
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
              <h3 class="box-title">Просмотр платных опций торгов - 
              	@if($id<13)
              		Продаж
              	@else
              		Покупки
              	@endif
              </h3>
            </div> <!-- /.box-header -->

            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Тип торгов</th>
                  <th>Начальная цена диапазона</th>
                  <th>Конечная цена диапазона</th>
                  <th>Тариф выставления услуги</th>
                </tr>
                </thead>
                <tbody>
                @if($id<13)
	                @foreach($bidding_rates as $bidding_rate)
						@if($bidding_rate->bidding_type == 2 || $bidding_rate->bidding_type == 4 || $bidding_rate->bidding_type == 6)
							<tr>
			                  <td>{{$bidding_rate->biddingTypeTitle()}}</td>
			                  <td>{{$bidding_rate->price_start}}</td>
			                  <td>{{$bidding_rate->price_end}}</td>
			                  <td>{{$bidding_rate->rate_bidding}}</td>
			                </tr>
		                @endif
	                @endforeach
				@else
					@foreach($bidding_rates as $bidding_rate)
						@if($bidding_rate->bidding_type == 3 || $bidding_rate->bidding_type == 5 || $bidding_rate->bidding_type == 7)
							<tr>
			                  <td>{{$bidding_rate->biddingTypeTitle()}}</td>
			                  <td>{{$bidding_rate->price_start}}</td>
			                  <td>{{$bidding_rate->price_end}}</td>
			                  <td>{{$bidding_rate->rate_bidding}}</td>
			                </tr>
		                @endif
	                @endforeach
				@endif      
                
                
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