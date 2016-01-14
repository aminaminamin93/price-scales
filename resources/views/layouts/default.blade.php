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

    {!! Html::style('/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('/bootstrap/css/bootstrap.css') !!}
    {!! Html::style('/bootstrap/css/bootstrap-social.css') !!}
    {!! Html::style('/bootstrap/css/loader.css') !!}
    {!! Html::style('/bootstrap/css/jquery-ui.css') !!}
    {!! Html::style('/bootstrap/css/font-awesome.min.css') !!}
    {!! Html::style('/bootstrap/css/owl.carousel.css') !!}
    {!! Html::style('/bootstrap/css/style.css') !!}
    {!! Html::style('/bootstrap/css/responsive.css') !!}
    {!! Html::style('/bootstrap/css/login-theme.css') !!}
    {!! Html::style('/bootstrap/price-slider/css/jslider.css') !!}
    {!! Html::style('/bootstrap/price-slider/css/jslider.blue.css') !!}
    {!! Html::style('/bootstrap/price-slider/css/jslider.plastic.css') !!}



    <style>
        .layout { padding: 50px; font-family: Georgia, serif; }
        .layout-slider {margin-left:5px; margin-bottom: 10px;  width: 100%; }
    </style>
</head>
@extends('layouts.alert')
<body  ng-controller="appController">
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
      <div class="middle-header" id="middle-header" ng-controller="mainMenuController">
        @include('layouts.mainmenu-area')
        <div class="search-result">

          <div class="search-result-area" id="search-result-area" ng-show="searchResults">
            <hr class="hr-searchresult-area" ng-hide="hideThisSearch">
            <div class="container"  >
              <div class="row">
                <div class="col-xs-4" ng-hide="hideThisSearch">
                  <h3>@{{ searchProducts | filter:uppercase }}</h3>
                </div>
                <div class="col-xs-4" ng-hide="hideThisSearch">
                  <label for="search">Search:</label>
                  <input ng-model="search" id="search" class="form-control" placeholder="Filter Product|Price|Condition">
                </div>
                <div class="col-xs-4"  ng-hide="hideThisSearch">
                  <label for="search">items per page:</label>
                  <input type="number" min="1" max="100" class="form-control" ng-model="pageSize2" ng-show="searchResults">
                </div>
              </div>
              <hr>
              <div class="row product-search" ng-hide="hideThisSearch">
                  <div class="row product-search-area" dir-paginate="result in searchResults|itemsPerPage: pageSize2 | filter:search" style="">
                    <div class="col-md-5 inline-block-custom">@{{ result.product_name }}</div>
                    <div class="col-md-3 inline-block-custom">@{{ result.condition_title }}</div>
                    <div class="col-md-2 inline-block-custom">@{{ result.product_price }}</div>
                    <div class="col-md-1 inline-block-custom">@{{ result.id }}
                      <a href="" ng-click="viewimage">view image</a>
                      <div class="" ng-show="viewimage">
                        hello
                      </div>
                    </div>
                    <div class="col-md-1 inline-block-custom"><a href="@{{ result.shopper_link }}" class="btn btn-xs btn-warning btn-block" taget="_blank">Visit Store</a></div>
                  </div>
              </div>
              <div class="" ng-show="!searchResults">
                No Products
              </div>
              <div ng-controller="PaginateSearchController" class="paginate-controller" ng-hide="hideThisSearch">
                  <div class="text-center">
                  <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler2(newPageNumber)" template-url="/bootstrap/js/dirPagination.tpl.html"></dir-pagination-controls>
                  </div>
              </div>
            </div>
            <hr class="hr-deparment-area" ng-hide="hideThisSearch">
          </div>
        </div>
      </div>
      <div class="search-container" ng-controller="searchformController">
        @include('layouts.search-form')
        <div class="row search-form-result" ng-show="searchFormResults">
          <h3>Search Result:</h3>
        </div>
      </div>
      <div class="content">
          @yield('content')
      </div>

   </div>
</div> <!--end of container-->
<div id="footer-area">
@extends('layouts.footer')
</div>


</body>




{!! Html::script('/bootstrap/js/owl.carousel.min.js') !!}
{!! Html::script('/bootstrap/js/jquery.sticky.js') !!}
{!! Html::script('/bootstrap/Jquery-ui/jquery_1_8_3.js') !!}
{!! Html::script('/bootstrap/js/jquery/jquery-ui.js') !!}
{!! Html::script('/bootstrap/Jquery-ui/ui/jquery.ui.effect.js') !!}



</html>
