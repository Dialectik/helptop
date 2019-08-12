<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>404</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/css/admin.css">
  
  
  <style>
      table.table form
      {
        display: inline-block;
      }
      button.delete
      {
        background: transparent;
        border: none;
        color: #337ab7;
        padding: 0px;
      }
    </style>
     
 
	<script src="/js/admin.js"></script>
  	
  	
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
 
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        404 Error Page
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> @lang('errors.404_1')</h3>

          <p>
            @lang('errors.404_2')<br>
            @lang('errors.404_3')<a href="{{ route('welcome') }}">@lang('errors.404_4')</a>
          </p>
          <p></p>
          <p>
          	Oh! This page does not exist.<br/>
          	We could not find the page you were looking for.<br/>
          	Meanwhile, you can <a href="{{ route('welcome') }}">return home</a>
          </p>

          
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>



</body>
</html>