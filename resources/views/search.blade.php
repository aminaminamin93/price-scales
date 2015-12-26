<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="csrf-token" content="{!! csrf_token() !!}">
</head>
<body>
{!! Form::open(array('url'=>'/codeTester', 'method'=>'post')) !!}
	<input type="text" name="search"/>
	<button type="submit" >Search</button>
{!! Form::close() !!}

</body>
</html>
