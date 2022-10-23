@extends('celebrity.layouts.master')
@section('content')
    <style>
        .dott {
            height: 30px;
            width: 30px;

            margin: 10px;
            display: inline-block;
            justify-content: center;
            align-items: center;

        }
    </style>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ecommerce</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Product-details</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body h-100">
                    <div class="row row-sm ">

                        <div class=" col-xl-5 col-lg-12 col-md-12">

                            <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="pic-1"><img
                                        src="{{asset('storage/'.$product->cover)}}"
                                        style="height: 350px;width: 400px" alt="image"/></div>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">

                                @foreach($product->color_product as $colors)
                                    <li><a data-target="#pic-2" data-toggle="tab"><img
                                                src="{{asset('storage/'.$colors->logo)}}" alt="image"/></a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                            <h4 class="product-title mb-1">{{$product->title}}</h4>
                            <p class="text-muted tx-13 mb-1">{{$product->description}}</p>
                            <div class="rating mb-1">
                                <div class="stars">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star text-muted"></span>
                                    <span class="fa fa-star text-muted"></span>
                                </div>
                                <span class="review-no">41 reviews</span>
                            </div>
                            <h6 class="price">current price: <span class="h3 ml-2">${{$product->offer_price}}</span>
                            </h6>
                            <p class="product-description">
                                @foreach($product->category as $cats)
                                    <large>Category:</large>{{$cats->name}}
                                @endforeach
                            </p>
                            <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87
                                    votes)</strong></p>
                            <form action="{{route('add.to.cart', $product->id)}}" method="post">
                            <div class="sizes d-flex">sizes:
                                @foreach($product->size as $size)

                                    <span class="size d-flex" data-toggle="tooltip" title="small"><label
                                            class="rdiobox mb-0"><input checked="" name="size" value="{{$size->id}}" type="radio"> <span
                                                class="font-weight-bold">{{$size->name}}</span></label></span>
                                @endforeach
                            </div>

                                @csrf
                                <div class="colors d-flex mr-3 mt-2">
                                    <span class="mt-2">colors:</span>
                                    <div class="row gutters-xs ml-4">
                                        <div class="mr-2">
                                            @foreach($product->color_product as $colors)
                                                <label class="colorinput">
                                                    <input name="color" type="radio" value="{{$colors->color->id}}">
                                                    <span class="dott" style="background-color:{{ $colors->color->color }}"></span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex  mt-2">
                                    @php
                                        $total = 0;
                                    @endphp
                                    <div class="mt-2 product-title">Total
                                        Quantity: @foreach($product->color_product as $pro)
                                            @php
                                                $total += $pro->quantity;
                                            @endphp

                                        @endforeach</div>
                                    {{ $total }}
                                    <div class="d-flex ml-2">
                                        <ul class=" mb-0 qunatity-list">
                                            <li>
                                                <div class="form-group">
                                                    {{--                                                <select name="quantity" id="select-countries17"--}}
                                                    {{--                                                        class="form-control nice-select wd-100">--}}
                                                    {{--                                                    <option value="1" selected="">1</option>--}}
                                                    {{--                                                    <option value="2">2</option>--}}
                                                    {{--                                                    <option value="3">3</option>--}}
                                                    {{--                                                    <option value="4">4</option>--}}
                                                    {{--                                                </select>--}}
                                                    {{--                                                <input name="quantity" type="number">--}}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="action">
                                    <button class="add-to-cart btn btn-danger" type="button">ADD TO WISHLIST</button>

                                    <input type="number" name="quantity">
                                    <p class="btn-holder">
                                        <button class="btn btn-warning btn-block text-center" role="button">Add to cart
                                        </button>
                                    </p>

                                    <button class="add-to-cart btn btn-success" type="button">ADD TO CART</button>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /row -->

        <!-- row -->
        <div class="row">
            <div class="col-lg-3">
                <div class="card item-card">
                    <div class="card-body pb-0 h-100">
                        <div class="text-center">
                            <img src="../../assets/img/ecommerce/01.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="card-body cardbody relative">
                            <div class="cardtitle">
                                <span>Items</span>
                                <a>Sport shoes</a>
                            </div>
                            <div class="cardprice">
                                <span class="type--strikethrough">$999</span>
                                <span>$799</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
                        <a href="#" class="btn btn-primary"> View More</a>
                        <a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card item-card">
                    <div class="card-body pb-0 h-100">
                        <div class="text-center">
                            <img src="../../assets/img/ecommerce/04.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="card-body cardbody relative">
                            <div class="cardtitle">
                                <span>Fashion</span>
                                <a>Mens Shoes</a>
                            </div>
                            <div class="cardprice">
                                <span class="type--strikethrough">$999</span>
                                <span>$799</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
                        <a href="#" class="btn btn-primary"> View More</a>
                        <a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card item-card">
                    <div class="card-body pb-0 h-100">
                        <div class="text-center">
                            <img src="../../assets/img/ecommerce/07.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="card-body cardbody relative ">
                            <div class="cardtitle">
                                <span>Accessories</span>
                                <a>Metal Watch</a>
                            </div>
                            <div class="cardprice">
                                <span class="type--strikethrough">$999</span>
                                <span>$799</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
                        <a href="#" class="btn btn-primary"> View More</a>
                        <a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card item-card">
                    <div class="card-body pb-0 h-100">
                        <div class="text-center">
                            <img src="../../assets/img/ecommerce/08.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="card-body cardbody relative">
                            <div class="cardtitle">
                                <span>Accessories</span>
                                <a>Metal Watch</a>
                            </div>
                            <div class="cardprice">
                                <span class="type--strikethrough">$999</span>
                                <span>$799</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
                        <a href="#" class="btn btn-primary"> View More</a>
                        <a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row -->

        <!-- row -->
        <div class="row row-sm">
            <div class="col-md-12 col-xl-4 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="feature2">
                            <i class="mdi mdi-airplane-takeoff bg-purple ht-50 wd-50 text-center brround text-white"></i>
                        </div>
                        <h5 class="mb-2 tx-16">Free Shipping</h5>
                        <span class="fs-14 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="feature2">
                            <i class="mdi mdi-headset bg-pink  ht-50 wd-50 text-center brround text-white"></i>
                        </div>
                        <h5 class="mb-2 tx-16">Customer Support</h5>
                        <span class="fs-14 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4 col-xs-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="feature2">
                            <i class="mdi mdi-refresh bg-teal ht-50 wd-50 text-center brround text-white"></i>
                        </div>
                        <div class="icon-return"></div>
                        <h5 class="mb-2  tx-16">30 days money back</h5>
                        <span class="fs-14 text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua domenus orioneu.</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
