@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Справочные материалы        
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
              <h3 class="box-title">Просмотр справочных материалов</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('references.edit', $reference->id)}}" class="btn btn-success">Изменить</a>
              </div>
            </div>
            
            
            <div class="box-body">
	          <div class="col-md-8">
	            <div class="form-group">
	              <?php
		              	echo $reference->title;
		          ?>    	
	            </div>
	          </div>
	          <!-- Раздел справки -->
	          <div class="col-md-2">  
		        <div class="form-group">
		          <label for="exampleInputEmail1">Раздел справки  
		          	<?php
		              	echo $reference->section_ref;
		            ?>
		          </label>
		        </div>
		      </div> 
	        </div>  <!-- /"box-body" -->
	        <!-- Текст справки -->
	        <div class="box-body">
		        <div class="col-md-10">
		            <div class="form-group">
		              <?php
		              	echo $reference->content;
		              ?>
			        </div>
			      </div>
			</div> <!-- /"box-body" -->
            
            
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection