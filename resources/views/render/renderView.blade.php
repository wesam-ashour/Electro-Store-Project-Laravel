@forelse($products as $product)
        <!-- product -->
        <div class="col-md-4 col-xs-6" >
            <div class="product">
                <div class="product-img">
                    <img src="{{asset('storage/'.$product['cover'])}}" alt="">
                    <div class="product-label">
                        <span class="sale">-30%</span>
                        <span class="new">NEW</span>
                    </div>
                </div>
                <div class="product-body">
                    <p class="product-category">
                        @foreach($product->category as $cats)
                            {{$cats->name}}
                        @endforeach
                    </p>
                    <h3 class="product-name"><a href="{{route('product.show',$product->id)}}">{{$product['title']}}</a></h3>
                    <h4 class="product-price">${{$product['offer_price']}} <del class="product-old-price">${{$product['price']}}</del></h4>
                    <div class="product-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="product-btns">
                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                    </div>
                </div>
                <div class="add-to-cart">
                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                </div>
            </div>
        </div>
        <!-- /product -->
@empty
    No Products Found!
@endforelse


