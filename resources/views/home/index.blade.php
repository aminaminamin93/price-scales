@extends('layouts.default')

@section('content')
<div class="department" ng-controller="departmentController" >
  <div class="row" style="margin-top:30px;">
    <div class="col-md-3">
      <div class="header_bottom_left">
  				<div class="categories">
  				  <ul>
  				  	<a href="" ng-click="departmentCategory(0,'All Category')"><h3>Categories</h3></a>
  				      <li ng-repeat="category in categories" >
                  <a href="" ng-click="departmentCategory(category.id,category.category_title)">@{{ category.category_title }}</a>
                </li>

  				  </ul>

  				</div>
  	  </div>
    </div>
  <div class="col-md-9" id="brands">
      <a href="" ng-click="departmentBrand(0,'All Brand')"><h3>Brands</h3></a>
      <div class="col-xs-2" ng-repeat="brand in brands" ng-show="!maxbrands || $index < maxbrands" ng-click="departmentBrand(brand.id,brand.brand_title)">
          <a href=""  >@{{ brand.brand_title }}  </a>
      </div>
      <div class="col-xs-2" ng-show="maxbrands" ng-click="maxbrands=0">
          <a>SHOW ALL</a>
      </div>
  </div>
  </div>

  <div class="department-content-area" id="department-area" ng-show="departments">
    <hr class="hr-deparment-area" ng-hide="hideThis">
    <div class="container"  >
      <div class="row">
        <div class="col-xs-4" ng-hide="hideThis">
          <h3>@{{ title }} Products </h3>
        </div>
        <div class="col-xs-4" ng-hide="hideThis">
          <label for="search">Search:</label>
          <input ng-model="search" id="search" class="form-control" placeholder="Filter Product|Price|Condition">
        </div>
        <div class="col-xs-4"  ng-hide="hideThis">
          <label for="search">items per page:</label>
          <input type="number" min="1" max="100" class="form-control" ng-model="pageSize" ng-show="departments">
        </div>
      </div>
      <hr>
      <div class="row product-department" ng-hide="hideThis">
          <div class="row product-department-area" dir-paginate="department in departments|itemsPerPage: pageSize | filter:search" style="">
            <div class="col-md-5 inline-block-custom">@{{ department.product_name }}</div>
            <div class="col-md-2 inline-block-custom">@{{ department.condition_title }}</div>
            <div class="col-md-2 inline-block-custom">@{{ department.product_price }}</div>
            <div class="col-md-2 inline-block-custom">
              <a href="" ng-click="select(department.picture_link)">view image</a>

            </div>
            <div class="col-md-1 inline-block-custom"><a href="@{{ department.shopper_link }}" class="btn btn-xs btn-warning btn-block" taget="_blank">Visit Store</a></div>
            <div ng-show="isSelected(department.picture_link)" class="product-image-thumbnail">
              <img ng-src="@{{ department.picture_link }}" alt="" ng-click="select()" title="click this image to close"/>
            </div>
          </div>
      </div>
      <div class="" ng-show="!departments">
        No Products
      </div>
      <div ng-controller="PaginateDepartmentController" class="paginate-controller" ng-hide="hideThis">
          <div class="text-center">
          <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/bootstrap/js/dirPagination.tpl.html"></dir-pagination-controls>
          </div>
      </div>
    </div>
    <hr class="hr-deparment-area" ng-hide="hideThis">
  </div>
</div>


<div class="maincontent-area" ng-controller="productsController">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Latest Products</h2>
                    <div class="row-md-12" ng-repeat="rows in products">
                        <div class="col-md-3" ng-repeat="product in rows">
                          <div class="single-product"  ng-show="products">
                              <div ></div>
                              <div class="product-f-image" style="text-align:center;margin:10px;">
                                <img ng-src="@{{ product.picture_link }}" class="img-product-thumbs" alt="" />
                                <div class="product-hover"></div>
                              </div>
                              <div class="" style="margin-left:10px;">
                                <a href="/product/compare/@{{ product.id }}">@{{ product.product_name}}</a>
                              </div>
                              <div class="product-carousel-price"  style="margin-left:10px;">
                                  <ins>@{{ product.product_price | currency:"RM":2}}</ins> <del>@{{ product.product_price_temp | currency:"RM":2}} </del>
                                  <br/>
                              </div>
                              <div class="row" style="margin-left:10px;margin-top:10px;bottom: 0;">
                                    <i class="">Favorite:</i><span>@{{ product.product_favorite }}</span> <i class="fa fa-view">View:</i><span>@{{ product.product_reviews }}</span>
                              </div>
                              <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                                  <a href="@{{ product.shopper_link }}" class="btn btn-primary btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                                  <a href="/product/details/@{{ product.id }}" class="btn btn-primary btn-xs" style="width:45%;"><i class="fa fa-link"></i> See details</a>
                              </div>

                          </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> <!-- End main content area -->

@include('layouts.brands-area')
@include('layouts.product-widget-area')
@endsection
