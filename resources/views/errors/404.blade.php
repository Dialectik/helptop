<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin HelpTop</title>
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
          <h3><i class="fa fa-warning text-yellow"></i> Ой! Такой страницы не существует.</h3>

          <p>
            Мы не смогли найти страницу, которую вы искали.
            Между тем, вы можете <a href="{{ route('welcome') }}">вернуться на главную</a>.
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