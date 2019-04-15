@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить услугу
        <small>продажа</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
	<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
	<form method="PUT" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
		  	@csrf
	
	  <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Обновляем статью</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$service->title}}" name="title">
            </div>
            
            <div class="form-group">
              <img src="{{$service->getImage()}}" alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Лицевая картинка</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
            
            <div class="form-group">
              <label>Категория</label>
              	  <select class="form-control select2" name="category_id" style="width: 100%;">
		              	<option selected="selected" value="{{$categorySer->id}}">{{$categorySer->title}}</option>
		              	@foreach($categories as $category)
	                		<option value="{{$category->id}}">{{$category->title}}</option>
	              		@endforeach
	              </select>
            </div>
            
            <!-- Date -->
            <div class="form-group">
              <label>Дата:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" value="{{$service->date}}" name="date">
              </div>
              <!-- /.input group -->
            </div>

            <!-- checkbox -->
            <div class="form-group">
              <label>
              	<input type="checkbox" class="minimal" name="is_featured" value="1" {{ $service->is_featured == 1 ? 'checked="checked"' : '' }}>
              </label>
              <label>
                Рекомендовать
              </label>
            </div>
            
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Описание</label>
              <textarea name="description" id="" cols="30" rows="10" class="form-control" >{{$service->description}}</textarea>
          </div>
        </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полный текст</label>
              <textarea name="content" id="" cols="30" rows="10" class="form-control">{{$service->content}}</textarea>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
	</form>
	
	
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection