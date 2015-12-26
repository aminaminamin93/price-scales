@extends('admin.layouts.default')

@section('content')
	<div class="container">
	<div class="list-products" style="margin-left:100px; margin-top:100px;margin-right:10%;">
		<div class="row">
			<h3>Products Information</h3>
			<div class="table-responsive">

				<table class="table">
					<tr>
						<th colspan="7">
							{!! Form::open( array('url'=>'productsController@search', 'method'=>'POST')) !!}
							<input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
							{!! Form::text('search' , null, array('class'=>'form-control', 'placeholder'=>'Search here', 'id'=>'search-product')) !!}
							{!! Form::close() !!}
						</th>
					</tr>
					<tr id="display-product" style="display:none">
						<td colspan="7">
							<div id="display-here">
								.....
							</div>

						</td>
					</tr>
					{{--<tr><th>Product Name</th><th>Retailer Contact</th><th>Retailer Site</th><th>Manage</th></tr>--}}
					@foreach($products as $product)
						<tr>
							<td>{!!$product->product_name !!}</td><td>RM {!!number_format($product->product_price, 2) !!}</td>
							<td>{!!$product->product_brand !!}</td>
							<td>
								<?php
								$star_number = $product->product_rating;

								if(strpos($star_number ,'.')){
									$float = 1;
								}else{
									$float = 0;
								}

								$floor_number = floor($star_number);
								?>

								@for($i=0; $i<$floor_number; $i++)

									<img src="/images/star/star.png" alt="" width="10">
								@endfor


								@if($float == 1)

									<img src="/images/star/half-star.png" alt="" width="10">


									@for($i=0; $i<(4-$floor_number); $i++)

										<img src="/images/star/blank-star.png" alt="" width="10">
									@endfor
								@else
										@for($i=0; $i<(5-$floor_number); $i++)

											<img src="/images/star/blank-star.png" alt="" width="10">
										@endfor
								@endif
								<span>&nbsp;</span>
								<small>{!! $product->product_reviews !!} Reviews</small>
							</td>
							<td>{!! $product->category->category_title !!}</td>
							<td>
								{!! Html::link('product/edit/'.$product->id , 'Edit', ['class'=>'btn btn-warning btn-xs']) !!}
								{!! Html::link('product/delete/'.$product->id , 'Delete', ['class'=>'btn btn-danger btn-xs']) !!}
								{!! Html::link('product/view/'.$product->id , 'View', ['class'=>'btn btn-info btn-xs']) !!}
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	</div>
@endsection