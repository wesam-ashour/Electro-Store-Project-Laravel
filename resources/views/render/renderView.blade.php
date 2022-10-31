@forelse($products as $product)
        <!-- product -->
        <div class="col-md-4 col-xs-6" >
            <div class="product">
                <div class="product-img">
                    <img src="{{asset('storage/'.$product['cover'])}}" alt="">
                    <div class="product-label">
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
                    
                    <div class="product-btns">
                        <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="product-btns">
                                <button class="add-to-wishlist">
                                    <i class="fa fa-heart-o"></i>
                                    <span class="tooltipp">add to wishlist</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- /product -->
@empty
    No Products Found!
@endforelse


