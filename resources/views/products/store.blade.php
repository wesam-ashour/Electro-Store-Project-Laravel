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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">All Categories</a></li>
                        <li class="active"><a href="#">All Products</a></li>
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
                        <h3 class="aside-title">Categories</h3>
                        <div class="checkbox-filter">

                            <select name="category" id="category" class="form-control  nice-select  custom-select">
                                <option value="0">--Select--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /aside Widget -->





                    <!-- aside Widget -->
                    <div class="aside">
                        <h3 class="aside-title">Top selling</h3>
                        @forelse ($topSellings as $topSelling)
                            <div class="product-widget">
                                <div class="product-img">
                                    <img src="{{ asset('storage/' . $topSelling['cover']) }}" alt="">
                                </div>
                                <div class="product-body">
                                    {{-- <p class="product-category">Category</p> --}}
                                    <h3 class="product-name"><a
                                            href="{{ route('product.show', $topSelling->id) }}">{{ $topSelling->title}}</a>
                                    </h3>
                                    <h4 class="product-price">${{ $topSelling->offer_price }}
                                        <del class="product-old-price">${{ $topSelling->price }}</del>
                                    </h4>
                                </div>
                            </div>
                        @empty
                            No products found
                        @endforelse
                    </div>
                    <!-- /aside Widget -->
                </div>
                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-md-9">
                    <!-- store top filter -->
                    
                    <!-- /store top filter -->

                    <!-- store products -->
                    <div class="row" id="tbody">
                        <div class="viewRender">
                            @forelse($products as $product)
                                <!-- product -->
                                <div class="col-md-4 col-xs-6">
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
                                                    href="{{ route('product.show', $product->id) }}">{{ $product['title'] }}</a>
                                            </h3>
                                            <h4 class="product-price">${{ $product['offer_price'] }}
                                                <del class="product-old-price">${{ $product['price'] }}</del>
                                            

                                            @if (DB::table('markable_favorites')->where('markable_id',$product->id)->where('user_id',$user->id)->exists())
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
                                                    <button class="add-to-wishlist">
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
                    </div>
                    <br>


                    <!-- /store products -->
                    <!-- store bottom filter -->
                    <div class="store-filter clearfix">
                        <ul>
                            {{ $products->links() }}

                        </ul>
                    </div>
                    <!-- /store bottom filter -->
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
