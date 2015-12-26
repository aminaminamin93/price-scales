<div class="footer-top-area" ng-controller="footerController">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-about-us">
                    <h1><a href="/"><img src="/bootstrap/img/pscales-logo-footer.png"></a></h1>
                    <!-- <div limit-string>
                    </div> -->
                    <p read-more string="companydesc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?</p>
                    <div class="footer-social">
                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">User Navigation </h2>
                    <ul>
                        <li><a href="#">My account</a></li>
                        <li><a href="#">My Favorite</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Categories</h2>
                    <ul>
                        <li ng-repeat="category in footercategories" ng-show="!maxFootCategories || $index < maxFootCategories"><a href="#">@{{ category.category_title }}</a></li>
                        <li ng-show="maxFootCategories" ng-click="maxFootCategories=0"><a>SHOW ALL</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-newsletter" ng-controller="newsletterController">
                    <h2 class="footer-wid-title">Newsletter</h2>
                    <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                    <div class="newsletter-form">
                      <div ng-show="newsletter">
                        @{{ newsletter.message }}
                        {!! Html::link('auth/@{{newsletter.action }}/@{{newsletter.email}}','@{{ newsletter.action | capitalize }}')!!}
                      </div>
                      {!! Form::open(array('url'=>'newsletter/subscribe', 'ng-submit'=>'subscribe($event)')) !!}

                      <div class="">
                        {!! Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'email', 'ng-model'=>'newsletter.email') ) !!}
                      </div>


                        <br/>
                      <div class="">
                        {!! Form::button('subscribe', array('class'=>'btn btn-primary btn-small btn-block', 'ng-click'=>'subscribe($event)')) !!}
                      </div>
                      {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End footer top area -->

<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <p>&copy; 2015 uCommerce. All Rights Reserved. <a href="http://www.freshdesignweb.com" target="_blank">freshDesignweb.com</a></p>
                </div>
            </div>

            <!-- <div class="col-md-4">
                <div class="footer-card-icon">
                    <i class="fa fa-cc-discover"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-paypal"></i>
                    <i class="fa fa-cc-visa"></i>
                </div>
            </div> -->
        </div>
    </div>
</div> <!-- End footer bottom area -->
