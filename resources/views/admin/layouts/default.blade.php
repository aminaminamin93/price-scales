
<!DOCTYPE>
<html ng-app="myApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{!! csrf_token() !!}">
	<title>{!! $title !!}</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	{!! Html::style('/admin-bootstrap/css/bootstrap.min.css') !!}
	<!-- Font Awesome -->
	{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">--}}
	<!-- Ionicons -->
	{{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
	<!-- Theme style -->
	<link rel="stylesheet" href="/admin-bootstrap/css/AdminLTE.min.css">

	<link rel="stylesheet" href="/admin-bootstrap/css/skins/skin-purple.min.css">
	<link rel="stylesheet" type="text/css" href="/admin-bootstrap/css/loader.css">
	<link href="/admin-bootstrap/css/calendar/responsive-calendar.css" rel="stylesheet">


	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script src="/admin-bootstrap/js/admin-angular.js"></script>
	<script src="/admin-bootstrap/js/pagination-angular/dirPagination.js"></script>
	<script src="/admin-bootstrap/js/angular/angular-http-loader.min.js"></script>

	{!! Html::style('/admin-bootstrap/css/bootstrap.css') !!}
	{!! Html::style('/admin-bootstrap/css/bootstrap.theme.css') !!}
		{!! Html::style('/admin-bootstrap/css/style.css') !!}

			<!-- Font Awesome -->
	{!! Html::style('/admin-bootstrap/css/font-awesome.min.css') !!}

			<!-- Custom CSS -->
	{{--{!! Html::style('/bootstrap/css/owl.carousel.css') !!}--}}
	{{--{!! Html::style('/bootstrap/css/style.css') !!}--}}
	{{--{!! Html::style('/bootstrap/css/responsive.css') !!}--}}
	{{--{!! Html::style('/bootstrap/css/login-theme.css') !!}--}}

</head>

<body class="hold-transition skin-purple sidebar-mini" ng-controller="appController" >
<div class="progress-container" ng-show="loading">
  <div class="progress">
    <div class="progress-bar">
      <div class="progress-shadow"></div>
    </div>
  </div>
</div>
<div class="wrapper">
	<!-- Main Header layouts -->
	@include('admin.layouts.header')

	<div class="content-wrapper">
		<!-- alert layouts -->
		@include('admin.layouts.alert')
		<!-- Left/main sidebar layouts -->
		@include('admin.layouts.main-sidebar')
		@yield('content')
	</div>


</div><!-- ./wrapper -->
<!-- footer layouts -->
	@include('admin.layouts.footer')
<!-- Right sidebar layouts -->
	@include('admin.layouts.rightsidebar')
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="/admin-bootstrap/js/admin.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="/admin-bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin-bootstrap/js/app.min.js"></script>
<script src="/admin-bootstrap/plugin/fastclick/fastclick.min.js"></script>
<script src="/admin-bootstrap/plugin/slimScroll/jquery.slimscrolling.min.js"></script>

<script src="/admin-bootstrap/js/calendar/bootstrap.min.js"></script>
<script src="/admin-bootstrap/js/calendar/responsive-calendar.js"></script>

</body>
<script>

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	 $(document).ajaxStart(function(){
        $(".cssload-wrap").show();
	});
	    $(document).ajaxComplete(function(){
	        $(".cssload-wrap").css("display", "none");
	});
	$(document).ready(function(){


		 $('#loader').click(function(){
	        $.ajax({
	            url: '/loader',
	            type: 'GET',
	            data: {
	              search : 'helloworld'
	            },

	          }).done(function(data){
	             console.log(data);
	          });

	    });


		if ($('#fail-action-message').is(':visible')) {
			$("#fail-action-message").slideToggle(2000);
		}


		$('#search-product').keyup(function(){
			$('#display-product').show();

			var search = $('input[name=search]').val();
			$.ajax({
				url: '/product/search',
				type: 'POST',
				data: { search : search },
				success: function(response)
				{
					$('#display-here').html(response);
				}
			});



			if($('input[name=search]').val() == ""){
				$('#display-product').hide();
			}
		});

		$.ajax({
			url: '/crawler/list',
			type: 'GET',
			success: function(response)
			{
				$('.crawler-list').html(response);
			}
		});


	});

</script>
</html>
