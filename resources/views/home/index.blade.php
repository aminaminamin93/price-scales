@extends('layouts.default')

@section('content')
<!-- department area -->
<div class="department" ng-controller="departmentController" >
  <div class="row" style="margin-top:30px;" id="department-menu-area">
    <div class="col-md-3" id="department-category-area">
      <div class="header_bottom_left">
  				<div class="categories">
  				  <ul>
  				  	<a href="" ng-click="departmentCategoryAll()"><h3>Categories</h3></a>
  				      <li ng-repeat="category in categories" >
                  <a href="" ng-click="departmentCategory(this)">@{{ category.category_title }}</a>
                </li>

  				  </ul>

  				</div>
  	  </div>
    </div>
    <div class="col-md-9" id="department-brand-area">
        <a href="" ng-click="departmentBrandAll()"><h3>Brands</h3></a>
        <div class="col-xs-3" ng-repeat="brand in brands" ng-show="!maxbrands || $index < maxbrands" ng-click="departmentBrand(this)">
            <a href=""  >@{{ brand.brand_title | uppercase }}  </a>
        </div>
        <div class="col-xs-3" ng-show="maxbrands" ng-click="maxbrands=0">
            <a>SHOW ALL</a>
        </div>
    </div>
  </div>
  <div class="department-content-area" id="department-area" ng-show="departments">
    <hr class="hr-deparment-area" ng-hide="hideThis">
    <div class="container"  >
      <div class="row" style="">
        <div class="col-xs-4" ng-hide="hideThis">
          <h3>@{{ title }} Products </h3>
        </div>
        <div class="col-xs-3" ng-hide="hideThis" style="display:inline-block">
          <div class="inline-block-custom"><label for="search">Filter: </label></div>
          <div class="inline-block-custom"><input ng-model="search" id="search" class="form-control input-block" placeholder="Product|Price|Condition"></div>
        </div>
        <div class="col-xs-3"  ng-hide="hideThis">
          <div class="inline-block-custom">
            <label for="search">Items per page:</label>
          </div>
          <div class="inline-block-custom">
              <input type="number" min="1" max="100" class="form-control" ng-model="pageSize" ng-show="departments">
          </div>
        </div>
        <div class="col-xs-2"  ng-hide="hideThis">
              <h2><span ng-click="changeToGrid()"  class="glyphicon glyphicon-th" title="show By Grid"></span>&nbsp;&nbsp;<span ng-click="changeToList()"  class="glyphicon glyphicon-th-list" title="show By List"></span></h2>
        </div>
      </div>
      <hr>
      <div class="row" style="padding-left:20px; padding-right:20px">
        <h4>@{{ resulttitle }}</h4>
      </div>
      <div class="row product-department" ng-hide="hideThis">

        <!--by list paternt -->
        <div class="row product-department-list" style="border:1px solid #ceecf6; margin-top:10px;" dir-paginate="department in departments|itemsPerPage: pageSize | filter:search" ng-show="showByList">
          <div class="inline-block-custom" style="width:15%;">
            <div class="product-f-image" style="text-align:center;margin:10px;">
              <img ng-src="@{{ department.picture_link }}" class="img-product-thumbs-list" alt="" />
              <div class="product-hover"></div>
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:40%;max-width:40%;vertical-align:top;margin-top:20px;">
            <div class="inline-block-custom product-list-name" style="word-wrap: break-word;">
               <h4><a href="/product/details/@{{ department.id }}">@{{ department.product_name }}</a></h4>
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
            <div class="inline-block-custom product-list-price">
              <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ department.product_favorite }}</span>
              &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ department.product_reviews }}</span>
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
            <div class="inline-block-custom product-list-price">
               @{{ department.product_price | currency:"RM ":2}}
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:20%;vertical-align:top;margin-top:20px;">
            <div style="margin-top:5px;">
                <a href="/product/compare/@{{ department.id }}" class="btn btn-success btn-xs btn-block"  ng-show="department.comparetable"><span class="glyphicon glyphicon-scale"></span> Compare</a>
            </div>
            <div style="margin-top:5px;">
                <a href="@{{ department.shopper_link }}" ng-if="department.shopper_link !=='' " class="btn btn-warning btn-xs btn-block" ng-show="!department.comparetable" ><i class="fa fa-shopping-cart"></i> Visit Store</a>
                <a href="@{{ department.shopper_link  }}" ng-if="department.shopper_link ==='' " class="btn btn-warning btn-xs btn-block" ng-show="!department.comparetable" disabled><i class="fa fa-shopping-cart" title=""></i> no online shop</a>

            </div>
            <div style="margin-top:5px;">
              <a href="/product/details/@{{ department.id }}" class="btn btn-primary btn-xs btn-block" ><span class="glyphicon glyphicon-eye-open"></span> See details</a>
            </div>

          </div>
        </div>
        <!--by grid pattern-->
        <div class="col-md-3" dir-paginate="department in departments|itemsPerPage: pageSize | filter:search" ng-show="showByGrid">
          <div class="single-product"  ng-show="departments">
              <div class="product-f-image" style="text-align:center;margin:10px;">
                <img ng-src="@{{ department.picture_link }}" class="img-product-thumbs" alt="" />
                <div class="product-hover"></div>
              </div>
              <div class="" style="margin-left:10px;word-wrap: break-word;">
                <a href="/product/details/@{{ department.id }}"><p>@{{ department.product_name}}</p></a>
              </div>
              <div class="product-carousel-price"  style="margin-left:10px;">
                  <ins>@{{ department.product_price | currency:"RM":2}}</ins> <del>@{{ department.product_price_temp | currency:"RM":2}} </del>
                  <br/>
              </div>
              <div class="row" style="margin-left:10px;margin-top:10px;bottom: 0;">
                <div class="col-xs-6">
                  <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ department.product_favorite }}</span>
                  &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ department.product_reviews }}</span>
                </div>
                <div class="col-xs-6">
                  <a href="/product/compare/@{{ department.id }}" class="btn btn-success btn-xs"  ng-show="department.comparetable"><span class="glyphicon glyphicon-scale"></span> Compare</a>
                </div>

              </div>
              <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                  <a href="@{{ department.shopper_link }}" ng-if="department.shopper_link !=='' " class="btn btn-warning btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                  <a href="@{{ department.shopper_link }}" ng-if="department.shopper_link ==='' " class="btn btn-warning btn-xs" style="width:45%;" disabled><i class="fa fa-shopping-cart"></i> no online shop</a>
                  <a href="/product/details/@{{ department.id }}" class="btn btn-primary btn-xs" style="width:45%;"><span class="glyphicon glyphicon-eye-open"></span> See details</a>
              </div>
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
<!-- department area -->

<div class="maincontent-area" ng-controller="productsController" ng-show="latestproduct">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Latest Products <div style="float:right"><span ng-click="changeToGrid()"  class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;<span ng-click="changeToList()"  class="glyphicon glyphicon-th-list"></span></div> </h2>

                    <div class="row-md-12" ng-repeat="rows in products" ng-show="default">
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
                                <div class="col-xs-6">
                                  <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ product.product_favorite }}</span>
                                  &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ product.product_reviews }}</span>
                                </div>
                                <div class="col-xs-6">
                                  <a href="/product/compare/@{{ product.id }}" class="btn btn-success btn-xs"  ng-show="product.comparetable"><span class="glyphicon glyphicon-scale"></span> Compare</a>
                                </div>

                              </div>
                              <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                                  <a href="@{{ product.shopper_link }}" ng-if="product.shopper_link ==='' " class="btn btn-warning btn-xs" style="width:45%;" disabled><i class="fa fa-shopping-cart"></i> no online shop</a>
                                  <a href="@{{ product.shopper_link }}" ng-if="product.shopper_link !=='' " class="btn btn-warning btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                                  <a href="/product/details/@{{ product.id }}" class="btn btn-primary btn-xs" style="width:45%;"><span class="glyphicon glyphicon-eye-open"></span> See details</a>
                              </div>
                              <!-- <div style="margin-left:10px;margin-top:10px;bottom: 0;">


                              </div> -->
                          </div>

                        </div>
                    </div>

                    <div class="row-md-12" ng-show="list" style="padding-left:30px;padding-right:30px;">
                      <div class="row" style="border:1px solid #ceecf6; margin-top:10px;" ng-repeat="productByList in productByLists">
                        <div class="inline-block-custom" style="width:15%;">
                          <div class="product-f-image" style="text-align:center;margin:10px;">
                            <img ng-src="@{{ productByList.picture_link }}" class="img-product-thumbs-list" alt="" />
                            <div class="product-hover"></div>
                          </div>
                        </div>
                        <div class="inline-block-custom" style="min-width:40%;vertical-align:top;margin-top:20px;">
                          <div class="inline-block-custom product-list-name">
                             <h4><a href="/">@{{ productByList.product_name }}</a></h4>
                          </div>
                        </div>
                        <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
                          <div class="inline-block-custom product-list-price">
                            <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ productByList.product_favorite }}</span>
                            &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ productByList.product_reviews }}</span>
                          </div>
                        </div>
                        <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
                          <div class="inline-block-custom product-list-price">
                             @{{ productByList.product_price | currency:"RM":2}}
                          </div>
                        </div>
                        <div class="inline-block-custom" style="min-width:20%;vertical-align:top;margin-top:20px;">
                          <div style="margin-top:5px;">
                              <a href="/product/compare/@{{ productByList.id }}" class="btn btn-success btn-xs btn-block"  ng-show="productByList.comparetable"><span class="glyphicon glyphicon-scale"></span> Compare</a>
                          </div>
                          <div style="margin-top:5px;">
                              <a href="@{{ productByList.shopper_link }}" ng-if="productByList.shopper_link ==='' " class="btn btn-warning btn-xs btn-block" ng-show="!productByList.comparetable" disabled><i class="fa fa-shopping-cart"></i> Visit Store</a>
                              <a href="@{{ productByList.shopper_link }}" ng-if="productByList.shopper_link !=='' " class="btn btn-warning btn-xs btn-block" ng-show="!productByList.comparetable" ><i class="fa fa-shopping-cart"></i> no online shop</a>
                          </div>
                          <div style="margin-top:5px;">
                            <a href="/product/details/@{{ productByList.id }}" class="btn btn-primary btn-xs btn-block" ><span class="glyphicon glyphicon-eye-open"></span> See details</a>
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
