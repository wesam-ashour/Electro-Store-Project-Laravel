@extends('layouts.master')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}" />
    <br>
    <style>
        .shopping-cart {
            padding-bottom: 50px;
            font-family: 'Montserrat', sans-serif;
        }

        .shopping-cart.dark {
            background-color: #f6f6f6;
        }

        .shopping-cart .content {
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
            background-color: white;
        }

        .shopping-cart .block-heading {
            padding-top: 50px;
            margin-bottom: 40px;
            text-align: center;
        }

        .shopping-cart .block-heading p {
            text-align: center;
            max-width: 420px;
            margin: auto;
            opacity: 0.7;
        }

        .shopping-cart .dark .block-heading p {
            opacity: 0.8;
        }

        .shopping-cart .block-heading h1,
        .shopping-cart .block-heading h2,
        .shopping-cart .block-heading h3 {
            margin-bottom: 1.2rem;
            color: #3b99e0;
        }

        .shopping-cart .items {
            margin: auto;
        }

        .shopping-cart .items .product {
            margin-bottom: 20px;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .shopping-cart .items .product .info {
            padding-top: 0px;
            text-align: center;
        }

        .shopping-cart .items .product .info .product-name {
            font-weight: 600;
        }

        .shopping-cart .items .product .info .product-name .product-info {
            font-size: 14px;
            margin-top: 15px;
        }

        .shopping-cart .items .product .info .product-name .product-info .value {
            font-weight: 400;
        }

        .shopping-cart .items .product .info .quantity .quantity-input {
            margin: auto;
            width: 80px;
        }

        .shopping-cart .items .product .info .price {
            margin-top: 15px;
            font-weight: bold;
            font-size: 22px;
        }

        .shopping-cart .summary {
            border-top: 2px solid #5ea4f3;
            background-color: #f7fbff;
            height: 100%;
            padding: 30px;
        }

        .shopping-cart .summary h3 {
            text-align: center;
            font-size: 1.3em;
            font-weight: 600;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .shopping-cart .summary .summary-item:not(:last-of-type) {
            padding-bottom: 10px;
            padding-top: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .shopping-cart .summary .text {
            font-size: 1em;
            font-weight: 600;
        }

        .shopping-cart .summary .price {
            font-size: 1em;
            float: right;
        }

        .shopping-cart .summary button {
            margin-top: 20px;
        }

        @media (min-width: 768px) {
            .shopping-cart .items .product .info {
                padding-top: 25px;
                text-align: left;
            }

            .shopping-cart .items .product .info .price {
                font-weight: bold;
                font-size: 22px;
                top: 17px;
            }

            .shopping-cart .items .product .info .quantity {
                text-align: center;
            }

            .shopping-cart .items .product .info .quantity .quantity-input {
                padding: 4px 10px;
                text-align: center;
            }
        }
    </style>
    <main class="page">
        <section class="shopping-cart dark">
            <div class="container">
                <div class="block-heading">
                    <h2>Shopping Cart</h2>
                </div>
                @if ($message = Session::get('success'))
                    <div class="p-4 mb-3 bg-green-400 rounded">
                        <p class="text-green-800">{{ $message }}</p>
                    </div>
                @endif

                @php $total = 0 @endphp
                <div class="content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                                @forelse($cart as $id => $details)
                                    <div class="product">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img class="img-fluid mx-auto d-block image"
                                                    style="height: 180px;width: 180px"
                                                    src="{{ asset('storage/' . \App\Models\Product::find($details['id'])->cover) }}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="info">
                                                    <div class="row">
                                                        <div class="col-md-5 product-name">
                                                            <div class="product-name">
                                                                <a
                                                                    href="#">{{ \App\Models\Product::find($details['id'])->title }}</a>
                                                                <div class="product-info">
                                                                    <div><span class="value"><a style="color: red"
                                                                                href="{{ route('checkout.details', $details['id']) }}">Details</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form action="" method="POST">
                                                            @csrf
                                                            <div class="col-md-4 quantity">
                                                                <label for="quantity">Quantity:</label>
                                                                <?php $sum = 0; ?>
                                                                @foreach ($details['color_items'] as $key => $c)
                                                                    <?php $sum += $c['quantity']; ?>
                                                                @endforeach
                                                                <input disabled type="number" value="{{ $sum }}"
                                                                    class="form-control">

                                                            </div>
                                                        </form>

                                                        <div class="col-md-3">
                                                            <span>Price:
                                                                ${{ \App\Models\Product::find($details['id'])->offer_price }}</span>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-3">
                                                            <span>Subtotal:
                                                                ${{ \App\Models\Product::find($details['id'])->offer_price * $sum }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('remove.from.cart') }}">
                                                <input type="hidden" id="myid" data-item-id="{{ $id }}"
                                                    value="{{ $id }}" name="id">
                                                <button class="px-4 py-2 text-white bg-red-600 remove-from-cart">x
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @php $total += \App\Models\Product::find($details['id'])->offer_price * $sum @endphp
                                @empty
                                    No products found in cart!
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="summary">
                                <h3>Summary</h3>
                                <div class="summary-item"><span class="text">Subtotal</span><span
                                        class="price">${{ $total }}</span></div>
                                @if (count($remains))
                                    <div class="summary-item show_coupon_code"><span class="text">Coupon code&nbsp; <a
                                                style="color: red;size: 1px;"
                                                href="{{ route('removeCouponCode') }}">Remove</a>
                                        </span><span class="price" id="code">{{ $remains['code'] }}</span></div>
                                    <div class="summary-item show_coupon_code"><span class="text">Discount</span><span
                                            class="price" id="value">%{{ $remains['value'] }}</span></div>
                                @endif
                                <div class="summary-item hide show_coupon_code"><span class="text">Coupon code&nbsp; <a
                                            style="color: red;size: 1px;" href="{{ route('removeCouponCode') }}">Remove</a>
                                    </span><span class="price" id="code"></span>
                                </div>
                                <div class="summary-item hide show_coupon_code"><span class="text">Discount</span><span
                                        class="price" id="value"></span></div>

                                {{-- <div class="summary-item hide show_coupon_code"><span
                                            class="text">Discount</span><span class="price" id="value"></span></div> --}}
                                <div class="summary-item"><span class="text">Shipping</span><span class="price">$0</span>
                                </div>
                                @if (count($remains))
                                    <div class="summary-item"><span class="text">Total</span><span class="price"
                                            id="total_price">${{ $remains['remain'] }}</span></div>
                                @else
                                    <div class="summary-item"><span class="text">Total</span><span class="price"
                                            id="total_price">${{ $total }}</span></div>
                                @endif


                                <form action="{{ route('checkout.index') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="total" value="{{ $total }}">
                                    <button class="btn btn-primary btn-lg btn-block">Checkout</button>


                                    <div>
                                        <a href="{{ route('clearCart') }}" class="px-6 py-2 text-red-800 bg-red-300">Remove
                                            All Cart</a>
                                    </div>
                                    <br>
                                    @if (count($cart))
                                        <div class="column">
                                            <form class="coupon-form" method="post">
                                                @csrf
                                                <input class="form-control" type="text" name="coupon_code"
                                                    id="coupon_code" placeholder="Coupon code">
                                                <button class="btn btn-outline-primary" type="button"
                                                    onclick="applyCouponCode()">Apply Coupon
                                                </button>
                                                <div style="color: red" id="coupon_code_msg"></div>
                                            </form>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@if (count(session()->get('cart', [])) > 0)
    <script type="text/javascript">
        function applyCouponCode() {
            var coupon_code = jQuery('#coupon_code').val();
            if (coupon_code !== '') {
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'post',
                    url: '{{ route('applyCouponCode') }}',
                    data: {
                        coupon_code: coupon_code,
                        total: '{{ $total }}'
                    },
                    success: function(result) {
                        var respons = result;
                        var totals = respons.remain;
                        if (respons.status === 'success') {
                            jQuery('.show_coupon_code').removeClass('hide');
                            jQuery('#coupon_code_str').html(coupon_code);
                            jQuery('#code').html(respons.code);
                            jQuery('#value').html('%' + respons.value);
                            jQuery('#total_price').html('$' + respons.remain);
                            jQuery('#coupon_code_msg').html(respons.msg);

                        } else {
                            jQuery('#coupon_code_msg').html(respons.msg);
                        }
                    },
                });
            } else {
                jQuery('#coupon_code_msg').html('Please inter coupon code');
            }
        }
    </script>
@endif
