@extends('layouts.master')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}" />
    <style>
        .title {
            margin-bottom: 5vh;
        }

        @media(max-width:767px) {
            .card {
                margin: 3vh auto;
            }
        }

        .cart {
            background-color: #fff;
            padding: 4vh 5vh;
            border-bottom-left-radius: 1rem;
            border-top-left-radius: 1rem;
        }

        @media(max-width:767px) {
            .cart {
                padding: 4vh;
                border-bottom-left-radius: unset;
                border-top-right-radius: 1rem;
            }
        }

        .summary {
            background-color: #ddd;
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
            padding: 4vh;
            color: rgb(65, 65, 65);
        }

        @media(max-width:767px) {
            .summary {
                border-top-right-radius: unset;
                border-bottom-left-radius: 1rem;
            }
        }

        .summary .col-2 {
            padding: 0;
        }

        .summary .col-10 {
            padding: 0;
        }

        .row {
            margin: 0;
        }

        .title b {
            font-size: 2.5rem;
        }

        .main {
            margin: 0;
            padding: 2vh 0;
            width: 100%;
        }

        .col-2,
        .col {
            padding: 0 1vh;
        }

        .close {
            /* margin-left: auto; */
            /* font-size: 0.7rem; */
        }

        .back-to-shop {
            margin-top: 4.5rem;
        }

        h5 {
            margin-top: 4vh;
        }

        hr {
            margin-top: 1.25rem;
        }

        .selects {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1.5vh 1vh;
            margin-bottom: 4vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247);
        }

        input {
            border: 1px solid rgba(0, 0, 0, 0.137);
            padding: 1vh;
            outline: none;
            width: 100%;
            background-color: rgb(247, 247, 247);
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        .btn {
            background-color: #000;
            border-color: #000;
            color: white;
            width: 100%;
            font-size: 1.3rem;
            margin-top: 4vh;
            padding: 1vh;
            border-radius: 0;
        }

        .btn:focus {
            box-shadow: none;
            outline: none;
            box-shadow: none;
            color: white;
            -webkit-box-shadow: none;
            -webkit-user-select: none;
            transition: none;
        }

        .btn:hover {
            color: white;
        }

        a {
            color: black;
        }

        a:hover {
            color: black;
            text-decoration: none;
        }

        /* #code {
                        background-image: linear-gradient(to left, rgba(255, 255, 255, 0.253), rgba(255, 255, 255, 0.185)), url("https://img.icons8.com/small/16/000000/long-arrow-right.png");
                        background-repeat: no-repeat;
                        background-position-x: 95%;
                        background-position-y: center;
                    } */
    </style>
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- card -->
            <div class="card">
                <div class="row">
                    <div class="col-md-8 cart">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    <h4><b>{{ __('cart.Shopping_Cart') }}</b></h4>
                                </div>
                                <div class="col align-self-center text-right text-muted">{{ count($cart) }}
                                    {{ __('cart.items') }}</div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="p-4 mb-3 bg-green-400 rounded">
                                <p class="text-green-800">{{ $message }}</p>
                            </div>
                        @endif

                        @php $total = 0 @endphp
                        @forelse($cart as $id => $details)
                            <div class="row border-top border-bottom">


                                <div class="row main align-items-center">
                                    <div class="col-2"><img class="img-fluid"
                                            src="{{ asset('storage/' . \App\Models\Product::find($details['id'])->cover) }}">
                                    </div>
                                    <div class="col">
                                        <div class="row text-muted">{{ \App\Models\Product::find($details['id'])->title }}
                                        </div>
                                        <div class="row">{{ __('cart.Material') }}:
                                            @foreach (\App\Models\Product::find($details['id'])->material as $cats)
                                                {{ $cats->name }}
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col">
                                        <?php $sum = 0; ?>
                                        @foreach ($details['color_items'] as $key => $c)
                                            <?php $sum += $c['quantity']; ?>
                                        @endforeach
                                        <div class="col">{{ $sum }} {{ __('cart.items') }}
                                            <div><a style="color: red"
                                                    href="{{ route('checkout.details', $details['id']) }}">{{ __('cart.Details') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">&dollar;
                                        {{ \App\Models\Product::find($details['id'])->offer_price }}
                                    </div>


                                    <form action="{{ route('remove.from.cart') }}" method="POST" class="col">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" value="{{ $details['id'] }}" name="id">
                                        <button class="close">&#10005;</button>

                                    </form>

                                    {{-- <div class="col">&euro; 44.00 <span class="close">&#10005;</span></div> --}}


                                </div>
                            </div>
                            @php $total += \App\Models\Product::find($details['id'])->offer_price * $sum @endphp
                        @empty
                            {{ __('cart.NO') }}
                        @endforelse

                        <div class="back-to-shop" style=position:absolute;bottom:10px;"><a
                                href="{{ route('product.view') }}">&leftarrow;</a><span class="text-muted">
                                {{ __('cart.Back') }}</span></div>
                    </div>
                    <div class="col-md-4 summary">
                        <div>
                            <h5><b> {{ __('cart.Summary') }}</b></h5>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col" style="padding-left:0;">{{ __('cart.Subtotal') }}</div>
                            <div class="col text-right">${{ $total }}</div>
                        </div>
                        @if (count($remains))
                            <div class="row">
                                <div class="col" style="padding-left:0;">{{ __('cart.Coupon') }}
                                    <a style="color: red;size: 1px;"
                                        href="{{ route('removeCouponCode') }}">({{ __('cart.Remove') }})</a>
                                </div>
                                <div class="col text-right" id="code">{{ $remains['code'] }}</div>
                            </div>
                            <div class="row">
                                <div class="col" style="padding-left:0;">{{ __('cart.Discount') }}</div>
                                <div class="col text-right" id="value">%{{ $remains['value'] }}</div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col hide show_coupon_code" style="padding-left:0;">{{ __('cart.Coupon') }}
                                <a style="color: red;size: 1px;"
                                    href="{{ route('removeCouponCode') }}">({{ __('cart.Remove') }})</a>
                            </div>
                            <div class="col text-right" id="code"></div>
                        </div>
                        <div class="row">
                            <div class="col hide show_coupon_code" style="padding-left:0;">{{ __('cart.Discount') }}</div>
                            <div class="col text-right" id="value"></div>
                        </div>
                        @if (count($remains))
                            <div class="row">
                                <div class="col" style="padding-left:0;">{{ __('cart.Total') }}</div>
                                <div class="col text-right" id="total_price">${{ $remains['remain'] }}</div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col" style="padding-left:0;">{{ __('cart.Total') }}</div>
                                <div class="col text-right" id="total_price">${{ $total }}</div>
                            </div>
                        @endif




                        <hr>
                        <form action="{{ route('checkout.index') }}" method="post">
                            @csrf
                            @method('GET')
                            <input type="hidden" name="total" value="{{ $total }}">

                            <div>
                                <a href="{{ route('clearCart') }}" class="px-6 py-2 text-red-800 bg-red-300">
                                    {{ __('cart.Remove_All_Cart') }}</a>
                            </div>
                            <button class="btn">{{ __('cart.CHECKOUT') }}</button>

                            <br>
                            <br>
                            <br>
                            @if (count($cart))
                                <form class="coupon-form" method="post">
                                    @csrf
                                    <p>{{ trans('cart.Give') }}</p>
                                    <input placeholder="{{ __('cart.Enter_your_code') }}" name="coupon_code"
                                        id="coupon_code">
                                    <button class="btn btn-outline-primary" type="button" onclick="applyCouponCode()">
                                        {{ __('cart.Apply') }}
                                    </button>
                                    <div style="color: red" id="coupon_code_msg"></div>
                                </form>
                            @endif
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
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
                            jQuery('#coupon_code_msg').html('{{ __('cart.applied') }}');

                        } else {
                            if (respons.status === 'error1') {
                                jQuery('#coupon_code_msg').html('{{ __('cart.valid') }}');

                            } else {
                            jQuery('#coupon_code_msg').html('{{ __('cart.deactivated') }}');

                            }
                        }
                    },
                });
            } else {
                jQuery('#coupon_code_msg').html('{{ __('cart.Please') }}');
            }
        }
    </script>
@endif
