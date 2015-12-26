<div class="row">
    <div class="col-md-6">
        <div class="brand-wrapper">
            <div class="brand-list">
                <img src="/bootstrap/img/brand1.png" alt="">
                <img src="/bootstrap/img/brand2.png" alt="">
                <img src="/bootstrap/img/brand3.png" alt="">
                <img src="/bootstrap/img/brand4.png" alt="">
                <img src="/bootstrap/img/brand5.png" alt="">
                <img src="/bootstrap/img/brand6.png" alt="">
                <img src="/bootstrap/img/brand1.png" alt="">
                <img src="/bootstrap/img/brand2.png" alt="">
                 <img src="/bootstrap/img/brand1.png" alt="">
                <img src="/bootstrap/img/brand2.png" alt="">
                 <img src="/bootstrap/img/brand1.png" alt="">
                <img src="/bootstrap/img/brand2.png" alt="">
            </div>
        </div>
    </div>
</div>


<!-- slider -->

<div class="slider-area">

    <div class="block-slider block-slider4">
        <ul class="" id="bxslider-home4">
            <li>
                <img src="/bootstrap/img/h4-slide.png" alt="Slide">
                <div class="caption-group">
                    <h2 class="caption title">
                        iPhone <span class="primary">6 <strong>Plus</strong></span>
                    </h2>
                    <h4 class="caption subtitle">Dual SIM</h4>
                    <a class="caption button-radius" href="/product/compare"><span class="icon"></span>Compared Now</a>
                </div>
            </li>
            <li><img src="/bootstrap/img/h4-slide2.png" alt="Slide">
                <div class="caption-group">
                    <h2 class="caption title">
                        by one, get one <span class="primary">50% <strong>off</strong></span>
                    </h2>
                    <h4 class="caption subtitle">school supplies & backpacks.*</h4>
                    <a class="caption button-radius" href="/product/compare"><span class="icon"></span>Compared Now</a>
                </div>
            </li>
            <li><img src="/bootstrap/img/h4-slide3.png" alt="Slide">
                <div class="caption-group">
                    <h2 class="caption title">
                        Apple <span class="primary">Store <strong>Ipod</strong></span>
                    </h2>
                    <h4 class="caption subtitle">Select Item</h4>
                    <a class="caption button-radius" href="/product/compare"><span class="icon"></span>Compared Now</a>
                </div>
            </li>
            <li><img src="/bootstrap/img/h4-slide4.png" alt="Slide">
                <div class="caption-group">
                    <h2 class="caption title">
                        Apple <span class="primary">Store <strong>Ipod</strong></span>
                    </h2>
                    <h4 class="caption subtitle">& Phone</h4>
                    <a class="caption button-radius" href="/product/compare"><span class="icon"></span>Compared Now</a>
                </div>
            </li>
        </ul>
    </div>
    <!-- ./Slider -->
</div> <!-- End slider area -->


<!-- products crousel -->
<div class="product-carousel">
    @foreach($products as $product)
    <div class="single-product">
        <div class="product-f-image">
            <img <?php if($product->picture_link == null){ ?> src="/images/products/default_product2.jpg" <?php }else{ ?> src="{!! $product->picture_link !!}" <?php } ?> class="img-product" alt="">

            <div class="product-hover">
                <a href="/product/compare/{!! $product->id !!}" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>Compare</a>
                <a href="{!! $product->shopper_link !!}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
            </div>
        </div>

        <h2><a href="single-product.html">{!! $product->product_name !!}</a></h2>

        <div class="product-carousel-price">
            <ins>RM {!! $product->product_price !!}</ins> <del>RM {!! $product->product_price !!}</del>
            <br/>

        </div>
        <div class="product-wid-rating">

            <?php
            $star_number = $product->product_rating;

            if(strpos($star_number ,'.')){
                $float = 1;
            }else{
                $float = 0;
            }

            $floor_number = floor($star_number);
            ?>

            @for($i=0; $i<$floor_number; $i++)
                    <i class="fa fa-star"></i>
            @endfor


            @if($float == 1)
                    <i class="fa fa-star-half-o"></i>
                @for($i=0; $i<(4-$floor_number); $i++)
                        <i class="fa fa-star-o"></i>
                @endfor
            @else
                @for($i=0; $i<(5-$floor_number); $i++)
                        <i class="fa fa-star-o"></i>
                @endfor
            @endif

        </div>
        <div>
            <p style="color:red"><small>{!! $product->product_reviews !!}</small><span><small>&nbsp;reviews</small></span></p>
        </div>

    </div>
    @endforeach
</div>

<div class="promo-area">
    <!-- <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo1">
                    <i class="fa fa-refresh"></i>
                    <p>30 Days return</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo2">
                    <i class="fa fa-truck"></i>
                    <p>Free shipping</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo3">
                    <i class="fa fa-lock"></i>
                    <p>Secure payments</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-promo promo4">
                    <i class="fa fa-gift"></i>
                    <p>New products</p>
                </div>
            </div>
        </div>
    </div> -->
</div> <!-- End promo area -->
