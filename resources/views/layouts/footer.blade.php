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
                        <li><a href="/" ng-click="contactUs($event)">Contact Us</a></li>
                        <li><a href="/">Home</a></li>
                        <li><a href="auth/login">Login</a></li>
                        <li><a href="auth/register">Register</a></li>
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
        <div id="contact-form"></div>
        <div class="row" style="margin-top:30px;" ng-show="contactus">
          <br>
          <br>
          <h3>Please Contact Us</h3>
          <div class="alert @{{ message.alert_type }}" ng-show="message.alert_message" id="alert">
            <p>
              @{{ message.alert_message }}
              <span ng-show="message.action === 'register'">Please <a href="/auth/@{{ message.action }}">register</a> to talk with Us, Thank You.</span>
              <span ng-show="message.action === 'login'">You can <a href="/auth/@{{ message.action }}">login</a> to continue, Thank You.</span>
            </p>
          </div>
          <div class="contact-form" style="width:60%;" >
            {!! Form::open(array('url'=>'/', 'method'=>'POST' ,'ng-submit'=>'sentMessage($event)')) !!}
            <div class="contact-email" style="width:60%;">
              {!! Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Your Email', 'ng-model'=>'message.email')) !!}
            </div>
            <br/>
            <div class="contact-subject">
              {!! Form::text('subject', null, array('class'=>'form-control', 'placeholder'=>'Subject', 'ng-model'=>'message.subject')) !!}
            </div>
            <br/>
            <div class="contact-content">
              {!! Form::textarea('context', null, array('class'=>'form-control', "placeholder"=>"what's your message",'ng-model'=>'message.content')) !!}
            </div>
            <br/>
            <div class="contact-action">
              <div class="inline-block-custom">
                  {!! Form::submit('Send', array('class'=>'btn btn-sm btn-success') ) !!}
              </div>
              <div class="inline-block-custom">
                  {!! Form::reset('Reset', array('class'=>'btn btn-sm btn-warning') ) !!}
              </div>

            </div>
            {!! Form::close() !!}
          </div>
        </div>
    </div>
</div> <!-- End footer top area -->
<div class="footer-bottom-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="copyright">
                    <p>&copy; 2015 PScales. All Rights Reserved. <a href="http://www.freshdesignweb.com" target="_blank"></a></p>
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
