
@foreach(array_chunk($products->all(), 4) as $row)	
	<input type="hidden" name="data-search" value="{!! $search_data !!}"/>
	<div class="row" align="center" style="margin-top:50px;">
	@foreach($row as $product)
		<div class="col-md-3">
			<!-- <img src=""> -->
			<!-- <a href="/view/products/{!! $product->id !!}" >{!! $product->product_name !!}</a> -->
			<div class="single-product">
                <div class="product-f-image">
                    <img <?php if($product->picture_link == null){ ?> src="/images/products/default_product2.jpg" <?php }else{ ?> src="{!! $product->picture_link !!}" <?php } ?> class="img-product" alt="">
                    <div class="product-hover">
                        <a href="{!! $product->shopper_link !!}" class="add-to-cart-link"><i class="fa fa-shopping-cart" target="_blank"></i>Visit</a>
                        <a href="{!! $product->shopper_link !!}" class="view-details-link"><i class="fa fa-link" target="_blank"></i> See details</a>
                    </div>
                    </div>

                    <h2><a href="single-product.html">{!! $product->product_name !!}</a></h2>
					<div class="product-carousel-price">
                    <ins>RM {!! $product->product_price !!}</ins> <del>RM {!! $product->product_price !!}</del>
                    <br/>
                </div>
            </div>

		</div>
	@endforeach
	</div>
@endforeach

<div align="center">{!! $products->render() !!}</div>

