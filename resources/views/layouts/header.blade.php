<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .topnav {
        overflow: hidden;
        background-color: rgb(21, 22, 29);
    }

    .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .topnav a.active {
        background-color: #04AA6D;
        color: white;
    }

    .topnav .icon {
        display: none;
    }

    @media screen and (max-width: 600px) {
        .topnav a:not(:first-child) {
            display: none;
        }

        .topnav a.icon {
            float: right;
            display: block;
        }
    }

    @media screen and (max-width: 600px) {
        .topnav.responsive {
            position: relative;
        }

        .topnav.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }

        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
    }
</style>
<header>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> 059-99999999</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> admin@admin.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> {{ __('welcome.Palestine_Gaza_Strip') }}</a></li>
                <select class="select changeLang" data-width="fit">
                    <option value="en" data-content='<span class="flag-icon flag-icon-us"></span> English'
                        {{ session()->get('locale') == 'en' ? 'selected' : '' }} class="bfh-selectbox bfh-languages"
                        data-language="en_US" data-available="en_US,fr_CA,es_MX" data-flags="true">EN</option>
                    <option value="ar" data-content='<span class="flag-icon flag-icon-ksa"></span> Arabic'
                        {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>AR</option>

                </select>
            </ul>
            <ul class="header-links pull-right">
                @if (\Illuminate\Support\Facades\Auth::guest())
                    <li><a href="{{ route('login') }}"><i class="fa fa-user-o"></i>{{ __('welcome.My_Account') }}</a>
                    </li>
                @else
                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i
                                class="fa fa-sign-out"></i>{{ __('welcome.logout') }}</a></li>


                    <li><a href="{{ route('profile_user') }}"><i class="fa fa-user-o"></i>
                            {{ $user->first_name . ' ' . $user->last_name }}</a></li>
                @endif
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
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
                        <a href="{{ url('/') }}" class="logo">
                            <img src="{{ asset('assets/home/img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-5">
                    <div class="header-search">

                        <form action="{{ route('product.view') }}">
                            <select class="input-select">
                                <option value="0">{{ __('welcome.All_Categories') }}</option>
                            </select>
                            <input class="input" value="{{ request()->get('search') }}"  name="search" placeholder="{{ __('welcome.Search_here') }}">
                            <button type="submit" class="search-btn">{{ __('welcome.Search') }}</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-4 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            <a href="{{ route('wishlist') }}">
                                <i class="fa fa-heart-o"></i>
                                <span>{{ __('welcome.Your_Wishlist') }}</span>
                                @if (\Illuminate\Support\Facades\Auth::check())
                                    <div class="qty">{{ \App\Models\Product::whereHasFavorite($user)->count() }}
                                    </div>
                                @else
                                    <div class="qty">0</div>
                                @endif
                            </a>
                        </div>
                        <!-- /Wishlist -->
                        @auth
                            <div>
                                <a href="{{ route('orders.index') }}">
                                    <i class="fa fa-th-list"></i>
                                    <span>{{ __('welcome.Your_Orders') }}</span>
                                    @if (\Illuminate\Support\Facades\Auth::check())
                                        <div class="qty">
                                            {{ \App\Models\Order::where('user_id', $user->id)->count() }}
                                        </div>
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
                                <span>{{ __('welcome.Your_Cart') }}</span>
                                @if (count(session()->get('cart', [])) != 0)
                                    <div class="qty">{{ count(session()->get('cart', [])) }}</div>
                                @else
                                    <div class="qty">0</div>
                                @endif
                            </a>
                            <?php $total = 0; ?>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    @if (count(session()->get('cart', [])))
                                        @foreach (session()->get('cart', []) as $id => $item)
                                            <div class="product-widget">
                                                <div class="product-img">
                                                    <img src="{{ asset('images/cover/' . \App\Models\Product::find($item['id'])->cover) }}"
                                                        alt="">
                                                </div>
                                                <div class="product-body">
                                                    <h3 class="product-name">
                                                        <a href="#">{{ \App\Models\Product::find($item['id'])->title }}</a>
                                                    </h3>
                                                    <h4 class="product-price"><span class="qty">
                                                            <?php $sum = 0; ?>
                                                            @foreach ($item['color_items'] as $key => $c)
                                                                <?php $sum += $c['quantity']; ?>
                                                            @endforeach
                                                            {{ $sum }}x
                                                        </span>${{ \App\Models\Product::find($item['id'])->offer_price * $sum }}
                                                    </h4>
                                                </div>
                                                <form action="{{ route('remove.from.cart') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" value="{{ $item['id'] }}" name="id">
                                                    <button class="delete"><i class="fa fa-close"></i></button>
                                                </form>
                                            </div>
                                            @php $total += \App\Models\Product::find($item['id'])->offer_price * $sum @endphp
                                        @endforeach
                                    @else
                                        {{ __('welcome.No_Product_cart') }}
                                    @endif

                                </div>
                                <div class="cart-summary">
                                    <small>{{ count(session()->get('cart', [])) . ' ' . __('welcome.item_selected') }}</small>
                                    <h5>{{ __('welcome.SUBTOTAL') }}{{ $total }}</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="{{ route('cart') }}"
                                        style="width:30.5rem">{{ __('welcome.View_Cart') }}</a>

                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->
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

<div class="topnav" id="myTopnav">
    <div class="container">
        <a href="{{ url('/') }}"
            class="{{ Route::currentRouteNamed('home.page') ? 'active' : '' }}">{{ __('welcome.Home') }}</a>
        <a href="{{ route('product.view') }}"
            class="{{ Route::currentRouteNamed('product.view') ? 'active' : '' }}">{{ __('welcome.Products') }}</a>
        <a href="{{ route('send_submisions') }}"
            class="{{ Route::currentRouteNamed('send_submisions') ? 'active' : '' }}">{{ __('welcome.Contact_Us') }}</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
