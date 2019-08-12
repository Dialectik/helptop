@extends('admin.layout')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить статусы пользователя
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
		<!-- Указание в форме возможности загрузки файлов:  enctype="multipart/form-data"-->
		<form method="POST" action="{{ route('users.updatestatus') }}">
			@csrf
			<input type="hidden" name="_method" value="POST">
			<input type="hidden" name="user_id" value="{{ $user->id }}">
	
	      <!-- Default box -->
	      <div class="box">
	        <div class="box-header with-border">
	          <h3 class="box-title">Статусы пользователя {{ $user->name }} ({{ $user->email }})</h3>
	          @include('admin.errors')
	        </div>
	        <!-- Регистрационные данные -->
	        
	      
	    <!-- Дополнительные данные -->  
        <div class="box-body">
          <div class="col-md-9">	      
			<!--Админ-->
          		<p>
	          		<?php 
	                	$checked1 = null;
	                	if($user->is_admin == 1) $checked1 = 'checked';
	                	echo "<input type='checkbox' class='minimal' name='is_admin' id='is_admin' value='1' $checked1/>"; 
	                ?>
	                &nbsp;<i class="fa fa-key" title=""></i>&nbsp;&nbsp;Админ
	            </p>
          	<!--Модератор-->
          		<p>
	          		<?php 
	                	$checked2 = null;
	                	if($user->is_moder == 1) $checked2 = 'checked';
	                	echo "<input type='checkbox' class='minimal' name='is_moder' id='is_moder' value='1' $checked2/>"; 
	                ?>
          			&nbsp;<i class="fa fa-camera" title=""></i>&nbsp;&nbsp;Модератор
          		</p>
           	<!--Агент-->
           		<p>
	          		<?php 
	                	$checked3 = null;
	                	if($user->is_agent == 1) $checked3 = 'checked';
	                	echo "<input type='checkbox' class='minimal' name='is_agent' id='is_agent' value='1' $checked3/>"; 
	                ?>
          			&nbsp;<i class="fa fa-user" title=""></i>&nbsp;&nbsp;Агент
          		</p>
          	<!--Забанен-->
          		<p>
	          		<?php 
	                	$checked4 = null;
	                	if($user->status_ban == 1) $checked4 = 'checked';
	                	echo "<input type='checkbox' class='minimal' name='status_ban' id='status_ban' value='1' $checked4/>"; 
	                ?>
          			&nbsp;<i class="fa fa-ban" title=""></i>&nbsp;&nbsp;Забанен
          		</p>
          	<!--Активирован-->
          		<p>
	          		<?php 
	                	$checked5 = null;
	                	if($user->activated == 1) $checked5 = 'checked';
	                	echo "<input type='checkbox' class='minimal' name='activated' id='activated' value='1' $checked5/>"; 
	                ?>
          			&nbsp;<i class="fa fa-flag-o" title=""></i>&nbsp;&nbsp;Активирован
          		</p>
	      
          </div>  <!-- end "col-md-9" -->
        </div>  <!-- end "box-body" -->
        


	      
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

