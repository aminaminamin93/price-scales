<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


  </head>
  <body>
    <div class="container">

      <div class="row">
        <div class="col-md-3" style="max-width:200px">
          <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
          <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
          <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>


          {!! Html::style('https://0d39587693a783b6887af5457452c38d3011383e.googledrive.com/host/0B92KN4X4-IyoLVozbDJrenlJUlk/bootstrap.min.css') !!}
          {!! Html::style('https://0d39587693a783b6887af5457452c38d3011383e.googledrive.com/host/0B92KN4X4-IyoLVozbDJrenlJUlk/bootstrap.css') !!}


          {!! Html::style('https://0d39587693a783b6887af5457452c38d3011383e.googledrive.com/host/0B92KN4X4-IyoLVozbDJrenlJUlk/style.css') !!}
          {!! Html::image('https://0d39587693a783b6887af5457452c38d3011383e.googledrive.com/host/0B92KN4X4-IyoLVozbDJrenlJUlk/pscales-logo.png','logo', ['style'=>'max-width:150px;']) !!}
        </div>

      </div>
      <hr>
      <div class="layout-email-content">
      @yield('content')
      </div>
      <div class="layout-email-footer">

      </div>
    </div>
  </body>
</html>
