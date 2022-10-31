@extends('layouts.master')
@section('content')
    @if ($message = Session::get('erorr'))
        <div class="p-4 mb-3 bg-green-400 rounded">
            <p class="text-green-800">{{ $message }}</p>
        </div>
    @endif

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">All Categories</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Headphones</a></li>
                        <li class="active">Product name goes here</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        @foreach ($product->color_product as $colors)
                            <div class="product-preview">
                                <img src="{{ asset('storage/' . $colors->logo) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product thumb imgs -->
                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                        @foreach ($product->color_product as $colors)
                            <div class="product-preview">
                                <div class="product-preview">
                                    <img src="{{ asset('storage/' . $colors->logo) }}" alt="">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /Product thumb imgs -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{ $product->title }}</h2>
                        <div>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <a class="review-link" href="#">10 Review(s) | Add your review</a>
                        </div>
                        <div>
                            <h3 class="product-price">${{ $product->offer_price }}
                                <del class="product-old-price">${{ $product->price }}</del>
                            </h3>
                            <span class="product-available">In Stock</span>
                        </div>
                        <p>{{ $product->description }}</p>

                        <form action="{{ route('add.to.cart', $product->id) }}" method="post">
                            @csrf
                            <div class="product-options">
                                <label>
                                    Size
                                    <select class="input-select" name="size">
                                        @foreach ($product->size as $id => $size)
                                            <option name="size" value="{{ $size->id }}"
                                                {{ old('size') == $size ? 'selected' : '' }}>{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <label>
                                    Color
                                    <select class="input-select" name="color" style="width: 160px;">
                                        <?php $sum = 0; ?>
                                        @foreach ($product->color_product as $key => $colors)
                                            <option value="{{ $colors->color->id }}" name="color">
                                                {{ $colors->color->name . ' - ' . $colors->quantity . ' in stock' }}
                                            </option>
                                            <?php $sum += $colors->quantity; ?>
                                        @endforeach
                                    </select>

                                </label>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if ($sum == 0)
                                <p style="color: red">Out of stock</p>
                            @else
                                <div class="add-to-cart">
                                    <div class="qty-label">
                                        Qty
                                        <div class="input-number">
                                            <input type="number" name="quantity">
                                            <span class="qty-up">+</span>
                                            <span class="qty-down">-</span>
                                        </div>
                                    </div>
                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
                            @endif
                        </form>
                        <br>

                        <ul class="product-btns">
                            <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <li><button><i class="fa fa-heart-o"></i> add to wishlist</button></li>
                            </form>
                        </ul>

                        <ul class="product-links">
                            <li>Category:</li>
                            @foreach ($product->category as $cats)
                                <li><a>{{ $cats->name }}</a></li>
                            @endforeach

                        </ul>

                        <ul class="product-links">
                            <li>Share:</li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                        </ul>

                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- tab1  -->
                            <div id="tab1" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $product->description }}.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab1  -->






                        </div>
                    </div>
                    <!-- /tab3  -->
                </div>
                <!-- /product tab content  -->
            </div>
        </div>
        <!-- /product tab -->
    </div>
    <!-- /row -->
    </div>
    <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3 class="title">Related Products</h3>
                    </div>
                </div>

                <!-- product -->
                @forelse($products as $product)
                    <div class="col-md-3 col-xs-6">
                        <div class="product">
                            <div class="product-img">
                                <img src="{{ asset('storage/' . $product['cover']) }}" alt="">
                                <div class="product-label">
                                    <span class="new">NEW</span>
                                </div>
                            </div>
                            <div class="product-body">
                                <p class="product-category">
                                    @foreach ($product->category as $cats)
                                        {{ $cats->name }}
                                    @endforeach
                                </p>
                                <h3 class="product-name"><a
                                        href="{{ route('products.show', $product->id) }}">{{ $product['title'] }}</a>
                                </h3>
                                <h4 class="product-price">${{ $product['offer_price'] }}
                                    <del class="product-old-price">${{ $product['price'] }}</del>
                                    @if (DB::table('markable_favorites')->where('markable_id', $product->id)->where('user_id', $user->id)->exists())
                                        <div class="product-btns">
                                            <button class="add-to-wishlist" disabled>
                                                <i class="fa fa-heart"></i>
                                                <span class="tooltipp">Addedd to wishlist</span>
                                            </button>
                                        </div>
                                    @else
                                        <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="product-btns">
                                                <button class="product-price">
                                                    <i class="fa fa-heart-o"></i>
                                                    <span class="tooltipp">add to wishlist</span>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <!-- /product -->
                @empty
                    No Products Found!
                @endforelse
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Section -->
    <!-- /NEWSLETTER -->
@endsection
