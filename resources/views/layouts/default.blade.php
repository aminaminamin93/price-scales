<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! $title !!}</title>

    <script>
      document.write('<base href="' + document.location + '" />');
    </script>
    <!-- <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'> -->


    <script data-require="angular.js@1.3.x" src= "/bootstrap/js/angular/angular.min.js" data-semver="1.3.7"></script>
    {!! Html::script('/bootstrap/js/jquery/jquery.min.js') !!}
    <!-- <script data-require="jquery" data-semver="2.1.1" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
    <script src="/bootstrap/js/jquery/jquery-migrate.min.js"></script>
    {!! Html::script('/bootstrap/js/jquery/bootstrap.min.js') !!}

    <script src="/bootstrap/js/angular/rzslider.js"></script>
    <script src="/bootstrap/js/angular/ui-bootstrap-tpls.min.js"></script>
    {!! Html::script('/bootstrap/js/dirPagination.js') !!}
    {!! Html::script('/bootstrap/js/angular-scroll/angular-scroll.js') !!}
    {!! Html::script('/bootstrap/js/main.js') !!}
    <script src="/bootstrap/js/angular.js"></script>

    {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('bootstrap/css/bootstrap.css') !!}
    {!! Html::style('bootstrap/css/bootstrap-social.css') !!}
    {!! Html::style('bootstrap/css/loader.css') !!}
    {!! Html::style('bootstrap/css/jquery-ui.css') !!}
    {!! Html::style('bootstrap/css/font-awesome.min.css') !!}
    {!! Html::style('bootstrap/css/owl.carousel.css') !!}
    {!! Html::style('bootstrap/css/style.css') !!}
    {!! Html::style('bootstrap/css/responsive.css') !!}
    {!! Html::style('bootstrap/css/login-theme.css') !!}
    {!! Html::style('bootstrap/price-slider/css/jslider.css') !!}
    {!! Html::style('bootstrap/price-slider/css/jslider.blue.css') !!}
    {!! Html::style('bootstrap/price-slider/css/jslider.plastic.css') !!}



    <style>
        .layout { padding: 50px; font-family: Georgia, serif; }
        .layout-slider {margin-left:5px; margin-bottom: 10px;  width: 100%; }
    </style>
</head>
@extends('layouts.alert')
<body  ng-controller="appController" id="body">
  <button type="button" name="button" class="btn btn-sm btn-success" id="goToTop" ng-click="goToTop()"><h3><span class="glyphicon glyphicon-chevron-up"></span></h3> </button>

  <div class="progress-container" ng-show="loading">
    <div class="progress">
      <div class="progress-bar">
        <div class="progress-shadow"></div>
      </div>
    </div>
  </div>
@include('layouts.header-navbar')
<div class="container">

   <div class="row">
      @include('layouts.branding-area')
      <div class="middle-header" id="middle-header" ng-controller="mainMenuController" >
        @include('layouts.mainmenu-area')

        <div style="margin-top:50px; padding-left: 20px;padding-right: 20px;"> <!-- start of search result-->
          <div class="row" style="" ng-hide="hideQuery">
            <div class="col-xs-3" >
              <h3>@{{ resulttitle }}</h3>
            </div>
            <div class="col-xs-3" ng-hide="hideQuery" style="display:inline-block">
              <div class="inline-block-custom"><label for="search">Filter: </label></div>
              <div class="inline-block-custom"><input ng-model="searchfilter" id="search" class="form-control input-block" placeholder="Product|Price|Condition"></div>
            </div>
            <div class="col-xs-3"  ng-hide="hideQuery">
              <div class="inline-block-custom">
                <label for="search">Items per page:</label>
              </div>
              <div class="inline-block-custom">
                  <input type="number" min="1" max="100" class="form-control" ng-model="pageSize3">
              </div>
            </div>
            <div class="col-xs-3"  ng-hide="hideQuery">
                  <h3 class="inline-block-custom"><span><a href="" ng-click="sortType = 'product_price'; sortReverse = !sortReverse">Price  <i class="fa fa-sort"></i></a></span>&nbsp;&nbsp;</h3>
                  <h2 class="inline-block-custom"><span ng-click="changeToGrid()"  class="glyphicon glyphicon-th" title="View Gridding"></span>&nbsp;&nbsp;<span ng-click="changeToList()"  class="glyphicon glyphicon-th-list" title="View Listing"></span></h2>
            </div>
          </div>
          <!-- start show by lis-->
          <div class="row product-department-list" style="border:1px solid #ceecf6; margin-top:10px;" dir-paginate="searchResult in searchResults|itemsPerPage: pageSize3| orderBy:sortType:sortReverse | filter:searchfilter" ng-show="showByList">
            <div class="inline-block-custom" style="width:15%;">
              <div class="product-f-image" style="text-align:center;margin:10px;">
                <img ng-src="@{{ searchResult.picture_link }}" class="img-product-thumbs-list" alt="" />
                <div class="product-hover"></div>
              </div>
            </div>
            <div class="inline-block-custom" style="min-width:40%;vertical-align:top;margin-top:20px;">
              <div class="inline-block-custom product-list-name">
                 <h4><a href="/product/details/@{{ searchResult.id }}">@{{ searchResult.product_name }}</a></h4>
              </div>
            </div>
            <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
              <div class="inline-block-custom product-list-price">
                <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ searchResult.product_favorite }}</span>
                &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ searchResult.product_reviews }}</span>
              </div>
            </div>
            <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
              <div class="inline-block-custom product-list-price">
                 @{{ searchResult.product_price | currency:"RM ":2}}
              </div>
            </div>
            <div class="inline-block-custom" style="min-width:20%;vertical-align:top;margin-top:20px;">
              <div style="margin-top:5px;">
                  <a href="/product/compare/@{{ searchResult.id }}" class="btn btn-success btn-xs btn-block"  ng-show="searchResult.comparetable"><span class="fa fa-link"></span> Compare</a>
              </div>
              <div style="margin-top:5px;">
                  <a href="@{{ searchResult.shopper_link }}" class="btn btn-warning btn-xs btn-block" ng-show="!searchResult.comparetable"><i class="fa fa-shopping-cart"></i> Visit Store</a>
              </div>
              <div style="margin-top:5px;">
                <a href="/product/details/@{{ searchResult.id }}" class="btn btn-primary btn-xs btn-block" ><span class="glyphicon glyphicon-eye-open"></span> See details</a>
              </div>

            </div>
          </div>
          <!-- end of show by list-->
          <!--start of show by grid-->
          <div class="row" ng-show="showByGrid">
            <div class="col-md-3" dir-paginate="searchResult in searchResults|itemsPerPage: pageSize3 | filter:searchfilter" >
              <div class="single-product"  ng-show="searchResult">
                  <div class="product-f-image" style="text-align:center;margin:10px;">
                    <img ng-src="@{{ searchResult.picture_link }}" class="img-product-thumbs" alt="" />
                    <div class="product-hover"></div>
                  </div>
                  <div class="" style="margin-left:10px;">
                    <a href="/product/details/@{{ searchResult.id }}">@{{ searchResult.product_name}}</a>
                  </div>
                  <div class="product-carousel-price"  style="margin-left:10px;">
                      <ins>@{{ searchResult.product_price | currency:"RM":2}}</ins> <del>@{{ searchResult.product_price_temp | currency:"RM":2}} </del>
                      <br/>
                  </div>
                  <div class="row" style="margin-left:10px;margin-top:10px;bottom: 0;">
                    <div class="col-xs-6">
                      <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ searchResult.product_favorite }}</span>
                      &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ searchResult.product_reviews }}</span>
                    </div>
                    <div class="col-xs-6">
                      <a href="/product/compare/@{{ searchResult.id }}" class="btn btn-success btn-xs"  ng-show="searchResult.comparetable"><span class="glyphicon glyphicon-scale"></span> Compare</a>
                    </div>

                  </div>
                  <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                      <a href="@{{ searchResult.shopper_link }}" class="btn btn-warning btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                      <a href="/product/details/@{{ searchResult.id }}" class="btn btn-primary btn-xs" style="width:45%;"><span class="glyphicon glyphicon-eye-open"></span> See details</a>
                  </div>
              </div>
              </div>
        </div>
        <!-- end of show by grid-->
        <hr ng-hide="hideQuery">
        <div ng-controller="PaginateSearchQueryController" class="paginate-controller" ng-show="searchResults" ng-hide="hideQuery">
            <div class="text-center">
            <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler3(newPageNumber)" template-url="/bootstrap/js/dirPaginationSearchquery.tpl.html"></dir-pagination-controls>
            </div>
        </div>

      </div><!-- end of search result-->

    </div>


    <div class="search-container" ng-controller="searchformController">
        @include('layouts.search-form')
        <div class="row" style="padding-left:50px; padding-right:50px">
        <hr ng-hide="hideThis">

        <div class="row" style="">
          <div class="col-xs-3" ng-hide="hideThis">

          </div>
          <div class="col-xs-3" ng-hide="hideThis" style="display:inline-block">
            <div class="inline-block-custom"><label for="search">Filter: </label></div>
            <div class="inline-block-custom"><input ng-model="searchfilter" id="search" class="form-control input-block" placeholder="Product|Price|Condition"></div>
          </div>
          <div class="col-xs-3"  ng-hide="hideThis">
            <div class="inline-block-custom">
              <label for="search">Items per page:</label>
            </div>
            <div class="inline-block-custom">
                <input type="number" min="1" max="100" class="form-control" ng-model="pageSize2">
            </div>
          </div>
          <div class="col-xs-3"  ng-hide="hideThis">
                <h3 class="inline-block-custom"><span><a href="" ng-click="sortType = 'product_price'; sortReverse = !sortReverse">Price  <i class="fa fa-sort"></i></a></span>&nbsp;&nbsp;</h3>
                <h2 class="inline-block-custom"><span ng-click="changeToGrid()"  class="glyphicon glyphicon-th" title="View Gridding"></span>&nbsp;&nbsp;<span ng-click="changeToList()"  class="glyphicon glyphicon-th-list" title="View Listing"></span></h2>
          </div>
        </div>
        <hr ng-hide="hideThis">
        <div class="row" ng-hide="hideThis" style="padding-left:10px;">
          <h3>@{{ resulttitle }}</h3>
        </div>
        <!--by list paternt -->
        <div class="row product-department-list" style="border:1px solid #ceecf6; margin-top:10px;" dir-paginate="searchFormResult in searchFormResults|itemsPerPage: pageSize2| orderBy:sortType:sortReverse | filter:searchfilter" ng-show="showByList">
          <div class="inline-block-custom" style="width:15%;">
            <div class="product-f-image" style="text-align:center;margin:10px;">
              <img ng-src="@{{ searchFormResult.picture_link }}" class="img-product-thumbs-list" alt="" />
              <div class="product-hover"></div>
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:40%; max-width:40%;vertical-align:top;margin-top:20px;">
            <div class="inline-block-custom product-list-name">
               <h4><a href="/product/details/@{{ searchFormResult.id }}">@{{ searchFormResult.product_name }}</a></h4>
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:10%;vertical-align:top;margin-top:20px;">
            <div class="inline-block-custom product-list-price">
              <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ searchFormResult.product_favorite }}</span>
              &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ searchFormResult.product_reviews }}</span>
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:10%; vertical-align:top;margin-top:20px;">
            <div class="inline-block-custom product-list-price">
               @{{ searchFormResult.product_price | currency:"RM ":2}}
            </div>
          </div>
          <div class="inline-block-custom" style="min-width:20%;vertical-align:top;margin-top:20px;">
            <div style="margin-top:5px;">
                <a href="/product/compare/@{{ searchFormResult.id }}" class="btn btn-success btn-xs btn-block"  ng-show="searchFormResult.comparetable"><span class="fa fa-link"></span> Compare</a>
            </div>
            <div style="margin-top:5px;">
                <a href="@{{ searchFormResult.shopper_link }}" class="btn btn-warning btn-xs btn-block" ng-show="!searchFormResult.comparetable"><i class="fa fa-shopping-cart"></i> Visit Store</a>
            </div>
            <div style="margin-top:5px;">
              <a href="/product/details/@{{ searchFormResult.id }}" class="btn btn-primary btn-xs btn-block" ><span class="glyphicon glyphicon-eye-open"></span> See details</a>
            </div>

          </div>
        </div>
        <!--by grid pattern-->
        <div class="row" ng-show="showByGrid">
          <div class="col-md-3" dir-paginate="searchFormResult in searchFormResults|itemsPerPage: pageSize2 | filter:searchfilter" >
            <div class="single-product"  ng-show="searchFormResults">
                <div class="product-f-image" style="text-align:center;margin:10px;">
                  <img ng-src="@{{ searchFormResult.picture_link }}" class="img-product-thumbs" alt="" />
                  <div class="product-hover"></div>
                </div>
                <div class="" style="margin-left:10px;">
                  <a href="/product/details/@{{ searchFormResult.id }}">@{{ searchFormResult.product_name}}</a>
                </div>
                <div class="product-carousel-price"  style="margin-left:10px;">
                    <ins>@{{ searchFormResult.product_price | currency:"RM":2}}</ins> <del>@{{ searchFormResult.product_price_temp | currency:"RM":2}} </del>
                    <br/>
                </div>
                <div class="row" style="margin-left:10px;margin-top:10px;bottom: 0;">
                  <div class="col-xs-6">
                    <span class="glyphicon glyphicon-heart"></span>&nbsp;&nbsp;<span>@{{ searchFormResult.product_favorite }}</span>
                    &nbsp;<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;<span>@{{ searchFormResult.product_reviews }}</span>
                  </div>
                  <div class="col-xs-6">
                    <a href="/product/compare/@{{ searchFormResult.id }}" class="btn btn-success btn-xs"  ng-show="searchFormResult.comparetable"><span class="glyphicon glyphicon-scale"></span> Compare</a>
                  </div>

                </div>
                <div style="margin-left:10px;margin-top:10px;bottom: 0;">
                    <a href="@{{ searchFormResult.shopper_link }}" class="btn btn-warning btn-xs" style="width:45%;"><i class="fa fa-shopping-cart"></i> Visit Store</a>
                    <a href="/product/details/@{{ searchFormResult.id }}" class="btn btn-primary btn-xs" style="width:45%;"><span class="glyphicon glyphicon-eye-open"></span> See details</a>
                </div>
            </div>

          </div>
        </div>
        <hr ng-hide="hideThis">
        <div ng-controller="PaginateSearchFormController" class="paginate-controller" ng-show="searchFormResults" ng-hide="hideThis">
            <div class="text-center">
            <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler2(newPageNumber)" template-url="/bootstrap/js/dirPaginationSearchform.tpl.html"></dir-pagination-controls>
            </div>
        </div>
      </div>
      </div>
      <div class="content">
          @yield('content')
      </div>

   </div><!-- end of row-->
</div> <!--end of container-->
<div id="footer-area">
@extends('layouts.footer')
</div>


</body>




{!! Html::script('bootstrap/js/owl.carousel.min.js') !!}
{!! Html::script('bootstrap/js/jquery.sticky.js') !!}
{!! Html::script('bootstrap/Jquery-ui/jquery_1_8_3.js') !!}
{!! Html::script('bootstrap/js/jquery/jquery-ui.js') !!}
{!! Html::script('bootstrap/Jquery-ui/ui/jquery.ui.effect.js') !!}



</html>
