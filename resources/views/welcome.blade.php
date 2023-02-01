@extends('layouts.master')
@section('content')

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('assets/welcome/women.webp') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>{{ __('welcome.Women’s_Apparel') }}<br>{{ __('welcome.Collection') }}</h3>
                            <a href="{{route('product.view')}}" class="cta-btn">{{ __('welcome.Shop_now') }} <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('assets/welcome/gifts.jpg') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>{{ __('welcome.Gifts') }}<br>{{ __('welcome.Collection') }}</h3>
                            <a href="{{route('product.view')}}" class="cta-btn">{{ __('welcome.Shop_now') }} <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('assets/welcome/jewelry.jpg') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>{{ __('welcome.Jewerlly_&_Accessories') }}<br>{{ __('welcome.Collection') }}</h3>
                            <a  href="{{route('product.view')}}" class="cta-btn">{{ __('welcome.Shop_now') }}<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title"> {{ __('welcome.New_Products') }}</h3>

                    </div>
                </div>
                <!-- /section title -->

                <!-- Products tab & slick -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    <!-- product -->
                                    @forelse ($products as $product)
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="{{ asset('images/cover/' . $product['cover']) }}" alt="">
                                                <div class="product-label">
                                                    <span class="new">{{ __('welcome.NEW') }}</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">
                                                    @foreach ($product->category as $cats)
                                                        {{ $cats->name }}
                                                    @endforeach
                                                </p>
                                                <h3 class="product-name"><a
                                                        href="{{ route('product.show', $product->id) }}">{{ $product['title'] }}</a>
                                                </h3>
                                                <h4 class="product-price">${{ $product['offer_price'] }}<del
                                                        class="product-old-price">${{ $product['price'] }}</del>

                                                    @if (Auth::guest())
                                                        <form action="{{ route('favorite.add', $product->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="product-btns">
                                                                <button class="add-to-wishlist">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    <span class="tooltipp">{{ __('welcome.add_to_wishlist') }}</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        @if (DB::table('markable_favorites')->where('markable_id', $product->id)->where('user_id', $user->id)->exists())
                                                            <div class="product-btns">
                                                                <button class="add-to-wishlist" disabled>
                                                                    <i class="fa fa-heart"></i>
                                                                    <span class="tooltipp">{{ __('welcome.Addedd_to_wishlist') }}</span>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <form action="{{ route('favorite.add', $product->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="product-btns">
                                                                    <button class="add-to-wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                        <span class="tooltipp">{{ __('welcome.add_to_wishlist') }}</span>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    @endif
                                            </div>

                                        </div>
                                        <!-- /product -->
                                    @empty
                                    {{ __('welcome.No_Products_Found') }}
                                    @endforelse
                                </div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

    <!-- /SECTION -->



    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="col-md-12">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" >
                    <div class="carousel-inner">
                        @foreach ($banners as $banner)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="10000">
                            <img src="{{ asset('images/cover/' . $banner->image) }}" class="d-block w-100" alt="...">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">{{ __('welcome.Previous') }}</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">{{ __('welcome.Next') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- HOT DEAL SECTION -->
    <div id="hot-deal" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="hot-deal">
                        <ul class="hot-deal-countdown">
                            <li>
                                <div>
                                    <h3>02</h3>
                                    <span>{{ __('welcome.Days') }}</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>10</h3>
                                    <span>{{ __('welcome.Hours') }}</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>34</h3>
                                    <span>{{ __('welcome.Mins') }}</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>60</h3>
                                    <span>{{ __('welcome.Secs') }}</span>
                                </div>
                            </li>
                        </ul>
                        <h2 class="text-uppercase">{{ __('welcome.hot_deal_this_week') }}</h2>
                        <p>{{ __('welcome.Collection_Up_to_50%_OFF') }}</p>
                        <a class="primary-btn cta-btn" href="{{ route('product.view') }}">{{ __('welcome.Shop_now') }}</a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
@endsection
