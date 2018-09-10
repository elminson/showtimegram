@extends('layouts.app')
@section('content')
    <div class="container">
      	<form method="post" enctype="multipart/form-data">
      	@csrf
  		<div class="form-group">
    		<input type="text" class="form-control" name="username" id="username" placeholder="Username" required="required">
		</div>
		<div class="form-group">
    		<input type="text" class="form-control" name="caption" id="caption" placeholder="Caption" required="required">
		</div>
		  <div class="form-group">
    		<input type="file" class="form-control-file" name="image" id="image" required="required">
    	</div>
    	  <button type="submit" class="btn btn-primary">Submit</button>
	
    	</form>
		
	</div>
@endsection
