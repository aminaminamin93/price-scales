@extends('admin.layouts.default')
@section('content')
	<div class="container">
		<div class="list-products" style="margin-left:100px; margin-top:100px;margin-right:10%;">
			<div class="row">
				<h3>Products Information</h3>
				<div class="table-responsive">

					<table class="table">
						@foreach($products as $product)
						<tr>
							<td style="width:250px">
								<div>
									{!! Html::image('/images/products/'.strtolower($product->product_brand).'/'.$product->picture_link ,'alt', array( 'width'=>'200') ) !!}
								</div>

							</td>
							<td>
								<table style="float:left; ">
									<tr>
										<th>{!!$product->product_name !!}</th>

									</tr>
									<tr><td>RM {!!number_format($product->product_price, 2) !!}</td></tr>
									<tr>
										<td></td>
									</tr>
									<tr>
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
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td>
											Manufacturer&nbsp;&nbsp;:&nbsp;&nbsp;{!! $product->product_brand !!}
										</td>
									</tr>
									<tr>
										<td>
											{!! Html::image('/images/products/'.strtolower($product->product_brand).'/'.$product->retailer_picture ,'alt', array( 'width'=>'200') ) !!}
										</td>
									</tr>
									<tr>


									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td></td>
							<td valign="bottom">

								{!! Html::link('product/edit/'.$product->id , 'Edit', ['class'=>'btn btn-warning btn-xs']) !!}
								{!! Html::link('product/delete/'.$product->id , 'Delete', ['class'=>'btn btn-danger btn-xs']) !!}
							</td>
						</tr>
						{{--<tr>--}}



							{{--<td>{!! $product->category->category_title !!}</td>--}}
							{{--<td></td>--}}
							{{--<td>--}}
								{{--{!! Html::link('product/edit/'.$product->id , 'Edit', ['class'=>'btn btn-warning btn-xs']) !!}--}}
								{{--{!! Html::link('product/delete/'.$product->id , 'Delete', ['class'=>'btn btn-danger btn-xs']) !!}--}}
								{{--{!! Html::link('product/view/'.$product->id , 'View', ['class'=>'btn btn-info btn-xs']) !!}--}}
							{{--</td>--}}
						{{--</tr>--}}
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection