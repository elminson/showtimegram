<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ShowtimeGram</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" type="text/javascript"></script>

<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

      <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>

<body>
  <!-- JJ -->
<div id="contentBoxApp" >
  <div id="GridCtrl" >  
    <div class="toolbar">
      <div class="container">
      <nav class="navbar  justify-content-between" style="color:#212529;">
  <a href="/newdesign" class="btn" style="color: white;" class="navbar-brand"><i class="fa fa-picture-o"></i>&nbsp; ShowtimeGram</a>
  <form class="form-inline">
   <a class="btn btn-primary" href="newdesign/post">Post Image</a>
  </form>
</nav>
      </div><!-- /.container -->
    </div><!-- /.toolbar -->
    <div class="container grid-size">
    <center>
        @yield('content')
    </center>
    </div><!-- /.dynamic-grid -->
  </div><!-- /#GridCtrl -->
</div><!-- /#contentBoxApp -->
<!-- SDG -->
</body>
</html>
