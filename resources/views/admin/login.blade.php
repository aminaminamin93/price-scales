<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/admin-bootstrap/css/AdminLTE.min.css">
	<!-- Bootstrap -->

	{!! Html::style('/bootstrap/css/bootstrap.min.css') !!}
	{!! Html::style('/bootstrap/css/bootstrap.css') !!}
	{!! Html::style('/bootstrap/css/bootstrap.theme.css') !!}

			<!-- Font Awesome -->
	{!! Html::style('/bootstrap/css/font-awesome.min.css') !!}

			<!-- Custom CSS -->
			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


<style>
	body{
		background-color:grey;
	}
	.login{
		background:white;
		border-radius:5px;

	}
	.form-login{
		width:500px;
		padding:30px 30px 30px 30px;
	}
	.admin-icon{
		width:20px;
		padding:10px 10px 10px 10px;
		margin-left:30%;
		margin-right:30%;
	}
</style>
</head>
<body>
<div class="login-form" style="  position:absolute; margin-left:30%; margin-top:150px;">
	<div class="login">
		{!! Form::open(array('url'=>'/admin/get_login', 'method'=>'post')) !!}
			<div class="admin-icon"><img src="/bootstrap/img/admin-icon-2.png" alt="" width="150"></div>

			<div class="form-login" style="">
				@if ($alert = Session::get('alert-success'))
					<div class="alert alert-danger">
						{{ $alert }}
					</div>
				@endif
				{!! Form::text('email', null, ['class' => 'form-control input-sm', 'placeholder' => 'Email']) !!}
				@if($errors->has('email'))<div class="alert alert-danger"><span class="">{!! $errors->first('email') !!}</span></div>@endif
				<br/>
				{!! Form::password('password',  ['class' => 'form-control input-sm', 'placeholder' => 'Password']) !!}
				@if($errors->has('password'))<div class="alert alert-danger"><span class="">{!! $errors->first('password') !!}</span></div>@endif
				<br/>
				{!! Form::submit('Login', ['class'=>'btn btn-primary btn-block']) !!}
				<hr>
				<div  style="float:right;"><a href="admin_password" style="text-decoration:none;">forget password</a></div>
			</div>
		{!! Form::close() !!}

	</div>
</div>
</body>