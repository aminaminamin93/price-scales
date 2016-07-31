@extends('layouts.default')

@section('content')
<div class="container" style="margin-top:50px;margin-bottom:100px;" ng-controller="compareProductController">
  <input type="hidden" id="_product_id" name="_product_id" value="{!! $products->id !!}" ng-model="products.id">
  <div class="single-product-details">
    <div class="row">
      <div class="col-md-7" style="	border: 1px solid #D8D8D8;border-radius:5px; padding:20px">

        <div class="col-md-6" style="	border: 1px solid #D8D8D8;border-radius:5px; padding:20px; margin-left:10px">
          <div class="row">
            <div class="" style="margin-left:20px"><h2>{!! $products->product_name !!}</h2></div>
          </div>
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
                    <a href="{!! $products->shopper_link !!}" class="btn btn-warning btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                  @else
                    <a href="{!! $products->shopper_link !!}" class="btn btn-warning btn-xs" style="width:45%;" disabled><i class="fa fa-shopping-cart" title=""></i> no online shop</a>
                  @endif
                    <a href="/product/favorite/{!! $products->id !!}" class="btn btn-primary btn-xs" style="width:40%;"><span class="glyphicon glyphicon-heart"></span> Favorite</a>
                </div>

            </div>
          </fieldset>

        </div>
        <div class="col-md-5" style="	border: 1px solid #D8D8D8;border-radius:5px; padding:20px; margin-left:10px;">
          <fieldset>
            <legend><h3>Images</h3></legend>
            <div class="img-compare-product">
              <img src="{!! $products->picture_link !!}" alt="" class="img-product-full"/>
            </div>
            <fieldset>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="price-compare-area">
        <fieldset>
          <legend><h3>Compare Prices</h3></legend>
          <div class="table table-responsive">
            <table class="table table-striped">

              @foreach($compareProducts as $compareProduct)
                <tr>
                    <td><a href="http://{!! $compareProduct->retailer_site !!}" target="_blank"><img src="{!! $compareProduct->picturelink !!}" alt="" /></a></td>
                    <td>{!! $compareProduct->product_name !!}</td><td>{!! $compareProduct->condition_title !!}</td><td>RM {!! $compareProduct->product_price !!}</td>
                    <td>
                      @if($compareProduct->shopper_link !== '')
                        <a href="{!! $compareProduct->shopper_link !!}" class="btn btn-warning btn-xs"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                      @else
                        <a href="{!! $compareProduct->shopper_link !!}" class="btn btn-warning btn-xs" disabled><i class="fa fa-shopping-cart" title=""></i> no online shop</a>
                      @endif
                    </td>

                </tr>

              @endforeach
            </table>
          </div>
        </fieldset>
      </div>
    </div>
    <div class="row">
      <div class="related-compare-area">
        <fieldset>
          <legend><h3>@{{ relateds.length }} Products related to  {!! $products->product_name !!}</h3></legend>
          <div class="table table-responsive">
            <table class="table table-striped">
              <tr>
                <td colspan="4"><input type="text" ng-model="search" class="form-control" placeholder="Filter Here:Price|Name|Condition"/></td>
                <td>
                  <a href="" ng-click="sortType = 'product_price'; sortReverse = !sortReverse">SortBy Price  <i class="fa fa-sort"></i></a>
                </td>
              </tr>
              <tr>
                <th><b>No</b></th><th><b>Product Name</b></th><th><b>Condition</b></th><th><b>Price</b></th><th></th>
              </tr>
              <tr ng-repeat="related in relateds |orderBy:sortType:sortReverse| filter:search" ng-show="relateds">
                <td>@{{$index+1}}</td><td><a href="/product/details/@{{related.id}}" />@{{ related.product_name }}</td><td>@{{ related.condition_title }}</td><td>RM @{{ related.product_price }}</td>
                <td>

                  <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                      <a href="@{{ related.shopper_link }}" class="btn btn-warning btn-xs"><i class="fa fa-shopping-cart"></i> Visit Store</a>

                      <a href="/product/compare/@{{ related.id }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-heart"></span> Compare</a>
                  </div>
                </td>
                <!-- <td>{!! Html::link('@{{ related.product_name }}' , 'Visit Store', array('class'=>'btn btn-xs btn-warning btn-block', 'target'=>'_blank')) !!}</td> -->
              </tr>
              <tr>
                <td colspan="6" ng-show="!relateds">No Products Result</td>
              </tr>
            </table>
          </div>
        </fieldset>
      </div>
    </div>
  </div>

</div>
@endsection
<!-- +"product_name": "Sony Ericsson Neo V"
    +"product_price": 160.0
    +"product_price_temp": 0.0
    +"product_rating": 0.0
    +"product_reviews": 257
    +"picture_link": ""
    +"shopper_link": "http://www.mudah.my/Sony+Ericsson+Neo+V-42569695.htm"
    +"product_location": "Kedah"
    +"product_shipping": ""
    +"condition_id": 2
    +"brand_id": 8
    +"category_id": 1
    +"created_at": "2015-12-01 17:48:27"
    +"updated_at": "2015-12-01 17:48:27"
    +"retailer_name": "MudahDotMY"
    +"retailer_site": "www.mudah.my"
    +"category_title": "Mobile Phones"
    +"brand_title": "Sony"
    +"condition_title": "Used (Second hands)" -->
