@extends('layouts.app')
@section('content')

    <div class="container">
    @if(session()->has('message.level'))
    <div class="alert alert-{{ session('message.level') }} message load" id="message_id"> 
    {!! session('message.content') !!}
    </div>
    @endif
  @foreach ($data as $item)
      <article class="grid-item content-box" >
        <div class="inner">
        <img class="content-box-thumb" src="{{ $item->image_name }}" alt="tech image" />
      
        <h2 class=" left">
          {{ $item->caption }}
        </h2>
        
        <div class="row ">
      <div class="col-md-6 text-left">  
          By: {{ $item->username }}<br>
           Date: {{ $item->updated_at }}
         </div>
      <div class="col-md-6 text-right"><a class="btn btn-outline-primary right" href="image/destroy/{{ $item->id }}">Delete</a></div>
    </div>
          
        </div>
    
      </article><!-- /.content-box -->
  @endforeach

   @if($data->previousPageUrl()) 
  <a class="btn btn-outline-primary" href="{{ $data->previousPageUrl() }}">Previus</a>
  @endif

  @if($data->nextPageUrl()) 
  <a class="btn btn-outline-primary" href="{{ $data->nextPageUrl() }}">Next</a>
  @endif
  <hr>

    </div><!-- /.dynamic-grid -->
  </div><!-- /#GridCtrl -->
</div><!-- /#contentBoxApp -->
<!-- SDG -->
@if(session()->has('message.level'))
        <script>
          document.addEventListener("DOMContentLoaded", function(event) {          
        setTimeout(function(){
        var element = document.getElementById("message_id"); 
            element.remove();
        }, 6000);
      });
        </script>
@endif

  <style type="text/css">
  .message {
    opacity: 0;
    font-size: 21px;
    margin-top: 25px;
    text-align: center;
    font-size: 14px;
    display: block;

    -webkit-transition: opacity 5s ease-in;
       -moz-transition: opacity 5s ease-in;
        -ms-transition: opacity 5s ease-in;
         -o-transition: opacity 5s ease-in;
            transition: opacity 5s ease-in;
}

.message .load {
    opacity: 1;
}
        
  </style>
@endsection
