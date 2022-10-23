<header>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
            </ul>
            <ul class="header-links pull-right">
                <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
                @if(\Illuminate\Support\Facades\Auth::guest())
                    <li><a href="{{route('login')}}"><i class="fa fa-user-o"></i> My Account</a></li>
                @else
                    <li><a href="{{route('home.page')}}"><i
                                class="fa fa-user-o"></i> {{$user->first_name.' '.$user->last_name}}</a></li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('assets/home/img/logo.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-5">
                    <div class="header-search">
                        <form>
                            <select class="input-select">
                                <option value="0">All Categories</option>
                                <option value="1">Category 01</option>
                                <option value="1">Category 02</option>
                            </select>
                            <input class="input" placeholder="Search here">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-4 clearfix">
                    <div class="header-ctn" >
                        <!-- Wishlist -->
                        <div>
                            <a href="{{route('wishlist')}}">
                                <i class="fa fa-heart-o"></i>
                                <span>Your Wishlist</span>
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <div class="qty">{{\App\Models\Product::whereHasFavorite($user)->count()}}</div>
                                @else
                                    <div class="qty">0</div>
                                @endif
                            </a>
                        </div>
                        <!-- /Wishlist -->
                        @auth
                        <div>
                            <a href="{{route('wishlist')}}">
                                <i class="fa fa-th-list"></i>
                                <span>Your Orders</span>
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <div class="qty">{{\App\Models\Product::whereHasFavorite($user)->count()}}</div>
                                @else
                                    <div class="qty">0</div>
                                @endif
                            </a>
                        </div>
                        @endauth
                        
                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your Cart</span>
                                <div class="qty">{{count($cartItems)}}</div>
                            </a>
                            <?php $total=0 ?>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    @if(count($cartItems) != 0)
                                    @foreach ($cartItems as $id => $item)
                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img
                                                    src="{{asset('storage/'. \App\Models\Product::find($item['id'])->cover)}}"
                                                    alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a
                                                        href="#">{{ \App\Models\Product::find($item['id'])->title}}</a>
                                                </h3>
                                                <h4 class="product-price"><span class="qty">
                                                    <?php $sum = 0 ?>
                                                        @foreach($item['color_items'] as $key=> $c)
                                                                <?php $sum += $c['quantity'] ?>
                                                        @endforeach
                                                        {{ $sum }}x</span>${{ \App\Models\Product::find($item['id'])->price * $sum }}</h4>
                                            </div>
                                            <form action="#" method="POST">
                                                @csrf
                                                {{--                                            <input type="hidden" value="{{ $item->id }}" name="id">--}}
                                                <button class="delete"><i class="fa fa-close"></i></button>
                                            </form>
                                        </div>
                                        @php $total += \App\Models\Product::find($item['id'])->price * $sum @endphp
                                    @endforeach
                                    @else
                                    There is no products in cart!
                                    @endif

                                </div>
                                <div class="cart-summary">
                                    <small>{{ count($cartItems)}} Item(s) selected</small>
                                    <h5>SUBTOTAL: ${{$total}}</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="{{route('cart')}}">View Cart</a>
                                    <a href="#">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="{{ Route::currentRouteNamed('home.page') ? 'active' : ''  }}"><a href="{{url('/')}}">Home</a></li>
                <li class="{{ Route::currentRouteNamed('product.view') ? 'active' : ''  }}"> <a href="{{route('product.view')}}">Products</a></li>
                {{--                <li><a href="#">Categories</a></li>--}}
                {{--                <li><a href="#">Laptops</a></li>--}}
                {{--                <li><a href="#">Smartphones</a></li>--}}
                {{--                <li><a href="#">Cameras</a></li>--}}
                {{--                <li><a href="#">Accessories</a></li>--}}
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->
