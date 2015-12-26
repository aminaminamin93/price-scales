<div class="search-form">
  {!! Form::open(array('url'=>'product/search/all', 'method'=>'GET','ng-submit'=>'searchProducts($event)')) !!}
  <!-- <form action="/products/search/all" method="POST" > -->
  <div class="row" style="margin-left:10px;">
    <div class="col-xs-4">
      {!! Form::text('search', null, ['class'=>'form-control', 'placeholder'=>'Products', 'ng-model'=>'search.searchText']) !!}

    </div>
    <div class="col-xs-2">
        <select name="brand" id="brand" class="form-control" ng-model="search.brand">
          <option value="0" ng-selected="true">All Brand</option>
          <option value="@{{ brand.id }}" ng-repeat="brand in brands">@{{ brand.brand_title }}</option>
        </select>
      </div>
      <div class="col-xs-2">
        <select name="category" id="category" class="form-control" id="sel1" ng-model="search.category">
            <option value="0" ng-selected="true">All Category</option>
            <option value="@{{ category.id }}" ng-repeat="category in categories">@{{ category.category_title }}</option>
        </select>
      </div>
  </div>
  <div class="row" style="margin-left:10px;padding-top:20px">
    <div class="col-xs-4">
      <div striderslider config="sliderConfig" low="search.priceLow" high="search.priceHigh" ></div>
      <div class="inline-block-custom">Min:@{{ search.priceLow }}</div><div class="inline-block-custom" style="float:right;">Max:@{{ search.priceHigh }}</div>
    </div>
    <div class="col-xs-2">
        <select name="condition" id="condition" class="form-control" ng-model="search.condition">
            <option value="0" ng-selected="true">All Condition</option>
            <option value="@{{ condition.id }}" ng-repeat="condition in conditions">@{{ condition.condition_title }}</option>
        </select>
    </div>
    <div class="col-xs-2">
      {!! Form::submit('Search',  ['class'=>'btn btn-xs-block btn-primary btn-block']) !!}
    </div>
  </div>

  {!! Form::close() !!}


</div>
