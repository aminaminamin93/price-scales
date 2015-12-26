<div class="product-widget-area" ng-controller="productWidgetController">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Top Viewed</h2>
                    <a href="" class="wid-view-more">View More</a>
                    <div class="single-wid-product" ng-repeat="topViewed in topVieweds">
                        <a href="#"><img ng-src="@{{ topViewed.picture_link }}" alt="" class="product-thumb"></a>
                        <h2><a href="#">@{{ topViewed.product_name }}</a></h2>
                        <div class="product-wid-condition">
                            <ins>@{{ topViewed.condition }}</ins>
                        </div>
                        <div class="product-wid-price">
                            <ins>@{{ topViewed.product_price | currency:"RM ":2}}</ins> <del>@{{ topViewed.product_price_temp | deleteprice:topViewed.product_price | currency:"RM ":2 }}</del>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Recently Viewed</h2>
                    <a href="#" class="wid-view-more">View More</a>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="/bootstrap/img/product-thumb-4.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Sony playstation microsoft</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>$400.00</ins> <del>$425.00</del>
                        </div>
                    </div>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="/bootstrap/img/product-thumb-1.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Sony Smart Air Condtion</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>$400.00</ins> <del>$425.00</del>
                        </div>
                    </div>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="/bootstrap/img/product-thumb-2.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Samsung gallaxy note 4</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>$400.00</ins> <del>$425.00</del>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">New Added</h2>
                    <a href="#" class="wid-view-more">View More</a>
                    <div class="single-wid-product" ng-repeat="newAdded in newAddeds">
                        <a href="#"><img ng-src="@{{ newAdded.picture_link }}" alt="" class="product-thumb"></a>
                        <h2><a href="#">@{{ newAdded.product_name }}</a></h2>
                        <div class="product-wid-condition">
                            <ins>@{{ newAdded.condition }}</ins>
                        </div>
                        <div class="product-wid-price">
                            <ins>@{{ newAdded.product_price | currency:"RM ":2 }}</ins> <del>@{{ newAdded.product_price_temp | deleteprice:newAdded.product_price | currency:"RM ":2}}</del>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> <!-- End product widget area -->
