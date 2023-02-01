@extends('layouts.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="#">{{ __('products.Home') }}</a></li>
                        <li class="active">{{ __('products.All_Products') }}</li>
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
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">{{ __('products.Categories') }}</h3>
                        <div class="checkbox-filter">

                            <select name="category" id="category" class="form-control  nice-select  custom-select">
                                <option value="0">{{ __('products.select') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /aside Widget -->





                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">{{ __('products.Top_selling') }}</h3>
                        @forelse ($topSellings as $topSelling)
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="{{ asset('images/cover/' . $topSelling['cover']) }}" alt="">
                                </div>
                                <div class="product-body">
                                    {{-- <p class="product-category">Category</p> --}}
                                    <h3 class="product-name"><a
                                            href="{{ route('product.show', $topSelling->id) }}">{{ $topSelling->title }}</a>
                                    </h3>
                                    <h4 class="product-price">${{ $topSelling->offer_price }}
                                        <del class="product-old-price">${{ $topSelling->price }}</del>
                                    </h4>
                                </div>
                            </div>
                        @empty
                        {{ __('products.No') }}

                        @endforelse
                    </div>
                    <!-- /aside Widget -->
                </div>
                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-md-9">

                    <!-- store products -->
                    <div class="row" id="tbody">
                        <div class="viewRender">
                            @forelse($products as $product)
                                <!-- product -->
                                <div class="col-md-4 col-xs-6">
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
                                                    href="{{ route('product.show', $product->id) }}">{{ $product['title'] }}</a>
                                            </h3>
                                            <h4 class="product-price">${{ $product['offer_price'] }}
                                                <del class="product-old-price">${{ $product['price'] }}</del>
                                                @if (Auth::guest())
                                                    <form action="{{ route('favorite.add', $product->id) }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="product-btns">
                                                            <button class="add-to-wishlist">
                                                                <i class="fa fa-heart-o"></i>
                                                                <span
                                                                    class="tooltipp">{{ __('products.add_to_wishlist') }}</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                @else
                                                    @if (DB::table('markable_favorites')->where('markable_id', $product->id)->where('user_id', $user->id)->exists())
                                                        <div class="product-btns">
                                                            <button class="add-to-wishlist" disabled>
                                                                <i class="fa fa-heart"></i>
                                                                <span
                                                                    class="tooltipp">{{ __('products.Addedd_to_wishlist') }}</span>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('favorite.add', $product->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="product-btns">
                                                                <button class="add-to-wishlist">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    <span
                                                                        class="tooltipp">{{ __('products.add_to_wishlist') }}</span>
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
                            {{ __('products.No') }}
                            @endforelse
                        </div>
                    </div>
                    <br>
                    <div class="store-filter clearfix">
                        <ul>
                            {{ $products->links() }}

                        </ul>
                    </div>
                </div>
            </div>
            <!-- /STORE -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
    <!-- /SECTION -->
    <!-- /NEWSLETTER -->
@endsection
