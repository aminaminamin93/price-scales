@extends('layouts.default')

@section('content')
	<div class="container" ng-controller="favoriteController">
	<div class="row favorite-container">
		<h3>Your favorites products</h3>
		<div class="row-md-12" ng-repeat="rows in favorites">
				<div class="col-md-3" ng-repeat="favorite in rows">
					<div class="single-product"  ng-show="favorites">
							<div ></div>
							<div class="product-f-image" style="text-align:center;margin:10px;">
								<img ng-src="@{{ favorite.picture_link }}" class="img-product-thumbs" alt="" />
								<div class="product-hover"></div>
							</div>
							<div class="" style="margin-left:10px;">
								<a href="/product/compare/@{{ favorite.id }}">@{{ favorite.product_name}}</a>
							</div>
							<div class="product-carousel-price"  style="margin-left:10px;">
									<ins>@{{ favorite.product_price | currency:"RM":2}}</ins> <del>@{{ favorite.product_price_temp | currency:"RM":2}} </del>
									<br/>
							</div>
							<div style="margin-left:10px;margin-top:10px;bottom: 0;">
									<a href="@{{ favorite.shopper_link }}" class="btn btn-primary btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
									<a href="/product/details/@{{ favorite.id }}" class="btn btn-primary btn-xs" style="width:45%;"><i class="fa fa-link"></i> See details</a>
							</div>
					</div>

				</div>
		</div>
		<div class="favorite-result" ng-show="!favorites">
			<h4>No Products</h4>
		</div>
	</div>
	</div>



@endsection
