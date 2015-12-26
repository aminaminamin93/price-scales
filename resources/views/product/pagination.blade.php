<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	{!! Html::style('/bootstrap/css/bootstrap.css') !!}
	{!! Html::script('//code.jquery.com/jquery-1.11.3.min.js') !!}
	{!! Html::script('/bootstrap/js/bootstrap.js') !!}
</head>
<body>
<div class="container">
	<div class="content">
		@foreach($products as $product)

			<h3>{!! $product->product_name !!}</h3>
		@endforeach

			{!! $products->render() !!}

	</div>
</div>
</body>
</html>