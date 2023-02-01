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
                        <li><a href="#">{{ __('products.Home') }}</a></li>
                        <li><a href="#">{{ __('products.All_Products') }}</a></li>
                        <li class="active">{{ $product->title }}</li>
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
                                <img src="{{ asset('images/color_images/' . $colors->logo) }}" alt="">
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
                                    <img src="{{ asset('images/color_images/' . $colors->logo) }}" alt="">
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
                            <h3 class="product-price">${{ $product->offer_price }}
                                <del class="product-old-price">${{ $product->price }}</del>
                            </h3>
                        </div>
                        <p>{{ $product->description }}</p>

                        <form action="{{ route('add.to.cart', $product->id) }}" method="post">
                            @csrf
                            <div class="product-options">
                                <label>
                                    {{ __('products.Size') }}
                                    <select class="input-select" name="size" style="width: 150px;">
                                        @foreach ($product->size as $id => $size)
                                            <option name="size" value="{{ $size->id }}"
                                                {{ old('size') == $size ? 'selected' : '' }}>{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </label>

                                <label>
                                    {{ __('products.Color') }}
                                    <select class="input-select" name="color" style="width: 190px;">
                                        <?php $sum = 0; ?>
                                        @foreach ($product->color_product as $key => $colors)
                                        @if ($colors->quantity != 0)
                                        <option value="{{ $colors->color->id }}" name="color">
                                            {{ $colors->color->name . ' - ' . $colors->quantity . ' in stock' }}
                                        </option>
                                        @endif
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
                                <p style="color: red">{{ __('products.Out_of_stock') }}</p>
                            @else
                                <div class="add-to-cart">
                                    <div class="qty-label">
                                        {{ __('products.Qty') }}
                                        <div class="input-number">
                                            <input type="number" name="quantity">
                                            <span class="qty-up">+</span>
                                            <span class="qty-down">-</span>
                                        </div>
                                    </div>
                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> {{ __('products.add_to_cart') }}</button>
                                </div>
                                <p style="color: red">{{ __('products.In_Stock') }} ({{$sum}})</p>

                            @endif
                        </form>
                        <br>
                        <ul class="product-btns">
                            <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <li><button><i class="fa fa-heart-o"></i> {{ __('products.Addedd_to_wishlist') }}</button></li>
                            </form>
                        </ul>
                        <ul class="product-links">
                            <li>{{ __('products.Category') }}:</li>
                            @foreach ($product->category as $cats)
                                <li><a>{{ $cats->name }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">{{ __('products.Description') }}</a></li>
                        </ul>
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
                        <h3 class="title">{{ __('products.Related_Products') }}</h3>
                    </div>
                </div>

                <!-- product -->
                @forelse($products as $product)
                    <div class="col-md-3 col-xs-6">
                        <div class="product">
                            <div class="product-img">
                                <img src="{{ asset('images/cover/' . $product['cover']) }}" alt="">
                                <div class="product-label">
                                    <span class="new">{{ __('products.NEW') }}</span>
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
                                    @if (Auth::guest())
                                    <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="product-btns">
                                            <button class="product-price">
                                                <i class="fa fa-heart-o"></i>
                                                <span class="tooltipp">{{ __('products.add_to_wishlist') }}</span>
                                            </button>
                                        </div>
                                    </form>
                                    @else

                                    @if (DB::table('markable_favorites')->where('markable_id', $product->id)->where('user_id', $user->id)->exists())
                                        <div class="product-btns">
                                            <button class="add-to-wishlist" disabled>
                                                <i class="fa fa-heart"></i>
                                                <span class="tooltipp">{{ __('products.Addedd_to_wishlist') }}</span>
                                            </button>
                                        </div>
                                    @else
                                        <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="product-btns">
                                                <button class="product-price">
                                                    <i class="fa fa-heart-o"></i>
                                                    <span class="tooltipp">{{ __('products.add_to_wishlist') }}</span>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                    @endif
                            </div>
                        </div>
                    </div>
                    <!-- /product -->
                @empty
                    {{ __('products.No_Products_Found') }}
                @endforelse
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Section -->
    <!-- /NEWSLETTER -->
@endsection
