@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blank page
        <small>it all starts here</small>
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
              <h3 class="box-title">Листинг сущности</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('services.create')}}" class="btn btn-success">Добавить</a>
              </div>
              
<!--              $services_title: {{$services_title}}
              <p></p>
              $product_code_id: {{$product_code_id}}-->

              <img src="" alt="" width="100">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Создано</th>
                  <th>Название</th>
                  <th>Дата начала публикации</th>
                  <th>Дата завершения публикации </th>
                  <th>Вид услуги</th>
                  <th>Картинка</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>

	            @if($in_content)
	                @foreach($services as $service)
	                <tr>
	                  <td>{{$service->service_id}}</td>
	                  <td>{{$service->created_at}}</td>
	                  <td>{{$service->getServiceTitle()}}</td>
	                  <td>{{$service->getDateAttribute($service->getServiceDateOn(), $date_offset)}}</td>
	                  <td>{{$service->getDateAttribute($service->getServiceDateOff(), $date_offset)}}</td>
	                  <td>{{$service->getKindTitle()}}</td>
	                  <td>
	                    <img src="{{$service->getImage()}}" alt="" width="100">
	                    
	                  </td>
	                  <td>
		                  <a href="{{route('services.edit', $service->service_id)}}" class="fa fa-pencil"></a> 
						  
						  <form method="POST" action="{{ route('services.destroy', $service->service_id) }}">
				  			@csrf
				  			<input type="hidden" name="_method" value="DELETE">
			                  <button onclick="return confirm('Точно удалить?')" type="submit" class="delete">
			            		<i class="fa fa-remove"></i>
			                  </button>
			              </form>
	                  </td>
	                </tr>
	                @endforeach
	            @else
	                @foreach($services as $service)
	                <tr>
	                  <td>{{$service->id}}</td>
	                  <td>{{$service->created_at}}</td>
	                  <td>{{$service->title}}</td>
	                  <td>{{$service->getDateAttribute($service->date_on, $date_offset)}}</td>
	                  <td>{{$service->getDateAttribute($service->date_off, $date_offset)}}</td>
	                  <td>{{$service->getKindTitle()}}</td>
	                  <td>
	                    <img src="{{$service->getImage()}}" alt="" width="100">
	                    
	                  </td>
	                  <td>
		                  <a href="{{route('services.edit', $service->id)}}" class="fa fa-pencil"></a> 
						  
						  <form method="POST" action="{{ route('services.destroy', $service->id) }}">
				  			@csrf
				  			<input type="hidden" name="_method" value="DELETE">
			                  <button onclick="return confirm('Точно удалить?')" type="submit" class="delete">
			            		<i class="fa fa-remove"></i>
			                  </button>
			              </form>
	                  </td>
	                </tr>
	                @endforeach
	            @endif    
	                

                
                </tfoot>
              </table>
              
			<div class="box-body">
				<div class="col-md-8" style="display: inline-block">
					<form method="POST" action="{{ route('services.request_offset_return') }}">
					  	@csrf
		 				
		 				<input type="hidden" name="start_id" value="{{$start_id}}">
		 				<input type="hidden" name="end_id" value="{{$end_id}}">
		 				<input type="hidden" name="request_type" value="1">
		 				<input type="hidden" name="date_offset" value="{{$date_offset}}">
		 				<input type="hidden" name="min_id" value="{{$min_id}}">
		 				<input type="hidden" name="max_id" value="{{$max_id}}">
		 				<input type="hidden" name="services_title" value="{{$services_title}}">
		 				<input type="hidden" name="product_code_id" value="{{$product_code_id}}">
		 				<input type="hidden" name="kind_id" value="{{$kind_id}}">
		 				<input type="hidden" name="category_id" value="{{$category_id}}">
		 				<input type="hidden" name="section_id" value="{{$section_id}}">
		 				<input type="hidden" name="date_on_start" value="{{$date_on_start}}">
		 				<input type="hidden" name="date_on_end" value="{{$date_on_end}}">
		 				<input type="hidden" name="date_off_start" value="{{$date_off_start}}">
		 				<input type="hidden" name="date_off_end" value="{{$date_off_end}}">
		 				<input type="hidden" name="bidding_type" value="{{$bidding_type}}">
		 				<input type="hidden" name="price_f_min" value="{{$price_f_min}}">
		 				<input type="hidden" name="price_f_max" value="{{$price_f_max}}">
		 				<input type="hidden" name="price_s_min" value="{{$price_s_min}}">
		 				<input type="hidden" name="price_s_max" value="{{$price_s_max}}">
		 				<input type="hidden" name="in_content" value="{{$in_content}}">
		 				<input type="hidden" name="city_id" value="{{$city_id}}">
						<button class="btn btn-success " style="display: inline-block">
				            << Предыдущие 50 объявлений
				        </button>
					</form>
					
					<form method="POST" action="{{ route('services.request_offset') }}">
					  	@csrf
		 				
		 				<input type="hidden" name="start_id" value="{{$start_id}}">
		 				<input type="hidden" name="end_id" value="{{$end_id}}">
		 				<input type="hidden" name="request_type" value="1">
		 				<input type="hidden" name="date_offset" value="{{$date_offset}}">
		 				<input type="hidden" name="min_id" value="{{$min_id}}">
		 				<input type="hidden" name="max_id" value="{{$max_id}}">
		 				<input type="hidden" name="services_title" value="{{$services_title}}">
		 				<input type="hidden" name="product_code_id" value="{{$product_code_id}}">
		 				<input type="hidden" name="kind_id" value="{{$kind_id}}">
		 				<input type="hidden" name="category_id" value="{{$category_id}}">
		 				<input type="hidden" name="section_id" value="{{$section_id}}">
		 				<input type="hidden" name="date_on_start" value="{{$date_on_start}}">
		 				<input type="hidden" name="date_on_end" value="{{$date_on_end}}">
		 				<input type="hidden" name="date_off_start" value="{{$date_off_start}}">
		 				<input type="hidden" name="date_off_end" value="{{$date_off_end}}">
		 				<input type="hidden" name="bidding_type" value="{{$bidding_type}}">
		 				<input type="hidden" name="price_f_min" value="{{$price_f_min}}">
		 				<input type="hidden" name="price_f_max" value="{{$price_f_max}}">
		 				<input type="hidden" name="price_s_min" value="{{$price_s_min}}">
		 				<input type="hidden" name="price_s_max" value="{{$price_s_max}}">
		 				<input type="hidden" name="in_content" value="{{$in_content}}">
		 				<input type="hidden" name="city_id" value="{{$city_id}}">
						<button class="btn btn-success" style="display: inline-block">
				            Вывести еще 50 объявлений >>
				        </button>
					</form>
	            </div>
            </div>
            
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@push('scripts')

<script>
	$(document).ready( function () {
	    $('#example3').DataTable({
   		"order": [[ 1, 'desc' ]]
		});
	});
</script>

@endpush
