<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! $title !!}</title>


    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    {!! Html::script('/bootstrap/js/jquery-ui.js') !!}

    {!! Html::style('/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('/bootstrap/css/bootstrap.css') !!}
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/loader.css">

     {!! Html::style('/bootstrap/css/font-awesome.min.css') !!}
     {!! Html::style('/bootstrap/css/owl.carousel.css') !!}
     {!! Html::style('/bootstrap/css/style.css') !!}
     {!! Html::style('/bootstrap/css/responsive.css') !!}
     {!! Html::style('/bootstrap/css/login-theme.css') !!}
     {!! Html::style('/bootstrap/price-slider/css/jslider.css') !!}
     {!! Html::style('/bootstrap/price-slider/css/jslider.blue.css') !!}
     {!! Html::style('/bootstrap/price-slider/css/jslider.plastic.css') !!}
<body>

<div class="cssload-wrap" style="position:absolue;">
	<div class="cssload-container">
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
		<span class="cssload-dots"></span>
	</div>
</div>
<div class="users"></div>
<input type="text" name="name" />
</body>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="/bootstrap/price-slider/js/jquery.slider.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

{!! Html::script('/bootstrap/js/owl.carousel.min.js') !!}
{!! Html::script('/bootstrap/js/jquery.sticky.js') !!}
{!! Html::script('/bootstrap/js/bxslider.min.js') !!}
{!! Html::script('/bootstrap/js/script.slider.js') !!}
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/jquery_1_8_3.js') !!}
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/ui/jquery.ui.effect.js') !!}
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/ui/jquery.ui.effect-bounce.js') !!}
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/ui/jquery.ui.effect-blind.js') !!}

<!-- {!! Html::script('/bootstrap/js/jquery-ui.js') !!} -->
<!-- {!! Html::script('/bootstrap/js/jquery.easing_1_3.min.js') !!} -->
<!-- {!! Html::script('/bootstrap/js/bounce.js') !!} -->
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/jquery-ui.js') !!}
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/jquery_1_8_3.js') !!}
{!! Html::script('/bootstrap/Jquery-ui-1.9.2/ui/jquery.ui.effect.js') !!}

<script>

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
$(document).ready(function(){

});

(function(){
  var func = function(){
    $.ajax({
      url: '/loader',
      type: 'GET',
    }).done(function(data){
       $('.users').text(data[0].user_firstname);
    }).fail(function(){

    }).always(function(){
       func();
    });
}
func();


})();
</script>
</head>
