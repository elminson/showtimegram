<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Multi-Height Grid Layout</title>
  <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <!-- JJ -->
<div id="contentBoxApp" ng-app="contentBoxApp">
  <div id="GridCtrl" ng-controller="GridCtrl">  
    <div class="toolbar">
      <div class="container">
        <div class="toolbar-section">
          <span class="logo toolbar-item"><i class="fa fa-picture-o"></i>ContentGrid</span>
        </div><!-- /.toolbar-section -->
        <div class="toolbar-section">
          <div class="toolbar-item form-field">
            <input type="text" name="filter" placeholder="phrase to filter" ng-model="search"/>
          </div>
        </div><!-- /.toolbar-section -->
      </div><!-- /.container -->
    </div><!-- /.toolbar -->
    