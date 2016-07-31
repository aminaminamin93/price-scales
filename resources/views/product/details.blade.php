@extends('layouts.default')

@section('content')
    <div class="container" style="margin-top:50px;margin-bottom:100px;" ng-controller="singleProductController">
      <input type="hidden" id="_product_id" name="_product_id" value="{!! $products->id !!}" ng-model="products.id">
      <div class="single-product-details">
        <div class="row">
          <div class="col-md-9" style="	border: 1px solid #D8D8D8;border-radius:5px; padding:20px">
            <div class="row">
              <div class="" style="margin-left:20px"><h2>{!! $products->product_name !!}</h2></div>
            </div>
            <div class="col-md-6" style="	border: 1px solid #D8D8D8;border-radius:5px; padding:20px; margin-left:10px">
              <fieldset>
                <legend><h3>Product Details</h3></legend>
                <div class="product-details-price">
                  <div class="" style="display: inline-block;"><p>Price</p></div>
                  <div class="" style="display: inline-block;">:</div>
                  <div class="" style="display: inline-block;"><p>RM {!! $products->product_price !!}</p></div>
                </div>
                <div class="product-details-brand">
                  <div class="" style="display: inline-block;"><p>Manufacturer</p></div>
                  <div class="" style="display: inline-block;"><p>:</p></div>
                  <div class="" style="display: inline-block;"><p>{!! $products->brand_title !!}</p></div>
                </div>
                <div class="product-details-condition">
                  <div class="inline-block" style="display: inline-block;"><p>Condition</p></div>
                  <div class="" style="display: inline-block;"><p>:</p></div>
                  <div class="" style="display: inline-block;"><p>{!! $products->condition_title !!}</p></div>
                </div>
                <div class="product-action">

                  <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                      @if($products->shopper_link !== '')
                        <a href="{!! $products->shopper_link !!}" class="btn btn-warning btn-xs" style="width:30%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                      @else
                        <a href="{!! $products->shopper_link !!}" class="btn btn-warning btn-xs" style="width:30%;" disabled><i class="fa fa-shopping-cart" title=""></i> no online shop</a>
                      @endif

                      <a href="/product/compare/{!! $products->id !!}" class="btn btn-success btn-xs" style="width:30%;"><span class="glyphicon glyphicon-scale"></span> Compare</a>
                      <a href="/favorite/add/{!! $products->id !!}" class="btn btn-primary btn-xs" style="width:30%;"><span class="glyphicon glyphicon-heart"></span> Favorite</a>
                  </div>
                </div>
              </fieldset>

            </div>
            <div class="col-md-5" style="	border: 1px solid #D8D8D8;border-radius:5px; padding:20px; margin-left:10px;">
              <fieldset>
                <legend><h3>Images</h3></legend>
                <div class="img-product">
                  <img src="{!! $products->picture_link !!}" alt="" class="img-product-full"/>
                </div>
                <fieldset>
            </div>
          </div>
          <div class="col-md-3 ">
            <div class="top-products-area">
                <h3>Top Products</h3>
                <div class="row top-single-area" ng-repeat="top in tops">
                  <div class="col-md-3 inline-block-custom" style="overflow:hidden; padding:0">
                    <div class="" >
                      <img ng-src="@{{ top.picture_link }}" alt="" class="img-product-top-thumbs"/>
                    </div>
                  </div>
                  <div class="col-md-9 inline-block-custom" style="">
                    <div class=""><a href="/product/details/@{{ top.id }}"> @{{ top.product_name }}</a></div>
                    <div class=""> RM @{{ top.product_price }}</div>
                  </div>
                </div>
            </div>

          </div>
        </div>
      </div>
      <div class="related-product-area">
        <div class="row">
          <div class="product-related">
              <h3>Related Products</h3>
              <div class="row-md-12">
                <div class="col-md-3 inline-related-custom" ng-repeat="related in relateds" style="">
                  <div class="" style="width:200px; height:200px; overflow:hidden">
                    <img ng-src="@{{ related.picture_link }}" alt="" class="img-product-related-thumbs"/>
                  </div>
                  <div class=""><a href="/product/details/@{{ related.id }}"> @{{ related.product_name }}</a></div>
                  <div class=""> RM @{{ related.product_price }}</div>
                  <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                      <a href="@{{ related.shopper_link }}" class="btn btn-warning btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                      <a href="/product/compare/@{{ related.id }}" class="btn btn-success btn-xs" style="width:45%;"><span class="glyphicon glyphicon-scale"></span>Compare</a>
                  </div>
                </div>

              </div>

          </div>
        </div>
      </div>
    </div>
@endsection
