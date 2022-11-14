@extends('layouts.master')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="#">{{ __('cart.Home') }}</a></li>
                        <li class="active">{{ __('cart.Checkout') }}</li>
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
                <form role="form" action="{{ route('stripe.post') }}" method="post" data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    @csrf
                    <div class="col-md-7">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">{{ __('cart.Billing') }}</h3>
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
                            <div class="form-group">
                                <label>{{ __('cart.First_name') }}</label>
                                <label></label>
                                <input class="input" type="text" value="{{ auth()->user()->first_name }}" disabled
                                    placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('cart.Last_name') }}</label>
                                <input class="input" type="text" value="{{ auth()->user()->last_name }}" disabled
                                    placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label>{{ __('cart.Email') }}</label>
                                <input class="input" type="email" value="{{ auth()->user()->email }}" disabled
                                    placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>{{ __('cart.Address') }}</label>

                                @if (count($addresss) > 0)
                                    <select name="address" class="form-control">
                                        @forelse ($addresss as $address)
                                            <option value="{{ $address->id }}">{{ $address->street_no }}
                                            </option>
                                        @empty
                                            {{ __('cart.No') }}
                                        @endforelse
                                    </select>
                                @else
                                    <p>No address found.. please add new address
                                        <a class="btn btn-primary-gradient" style="padding: 3px; color:blue"
                                            href="{{ route('profile_user') }}"> Add new address</a>
                                    </p>
                                @endif

                            </div>
                        </div>
                        <div class="order-notes">
                            <label>{{ __('cart.Notes') }}</label>
                            <textarea class="input" name="notess" placeholder="{{ __('cart.OrderـNotes') }}"></textarea>
                        </div>
                        <!-- /Order notes -->
                    </div>

                    <!-- Order Details -->
                    <div class="col-md-5 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">{{ __('cart.Your_Order') }}</h3>
                        </div>
                        <div class="order-summary">
                            <div class="order-col">
                                <div><strong>{{ __('cart.PRODUCT') }}</strong></div>
                                <div><strong>{{ __('cart.TOTAL') }}</strong></div>
                            </div>
                            <div class="order-products">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($oldCart as $id => $item)
                                    <div class="order-col">
                                        <div><?php $sum = 0; ?>
                                            @foreach ($item['color_items'] as $key => $c)
                                                <?php $sum += $c['quantity']; ?>
                                            @endforeach {{ $sum }}x
                                            {{ \App\Models\Product::find($item['id'])->title }}
                                        </div>
                                        <div>${{ \App\Models\Product::find($item['id'])->offer_price * $sum }}</div>
                                    </div>
                                    @php $total += \App\Models\Product::find($item['id'])->offer_price * $sum @endphp
                                @endforeach
                            </div>
                            <div class="order-col">
                                <div>{{ __('cart.Shiping') }}</div>
                                <div><strong>{{ __('cart.FREE') }}</strong></div>
                            </div>
                            <div class="order-col">
                                <div><strong>{{ __('cart.TOTAL') }}</strong></div>
                                @if (count($remains))
                                    <div><strong class="order-total">${{ $remains['remain'] }}</strong></div>
                                @else
                                    <div><strong class="order-total">${{ $total }}</strong></div>
                                @endif
                            </div>
                        </div>
                        <div class="payment-method">

                            <div class="input-radio">
                                <input type="radio" name="payment" required id="payment-1">
                                <label for="payment-1">
                                    <span></span>
                                    {{ __('cart.Credit') }}
                                </label>
                                <div class="caption">
                                    <form action="/charge" method="post" id="payment-form">

                                        <div class="form-row">

                                            <div id="card-element">

                                                <!-- a Stripe Element will be inserted here. -->

                                            </div>

                                            <!-- Used to display form errors -->

                                            <div id="card-errors"></div>

                                        </div>

                                        {{-- <input type="submit" class="submit" value="Submit Payment"> --}}

                                    </form>
                                </div>
                            </div>
                            <div class="input-radio">
                                <input type="radio" name="payment" value="CODE" id="payment-2">
                                <label for="payment-2">
                                    <span></span>
                                    {{ __('cart.Cash') }}
                                </label>
                                <div class="caption">
                                    <p>{{ __('cart.Pay') }}</p>
                                </div>
                            </div>


                            <button type="submit" class="primary-btn order-submit">{{ __('cart.Place') }} </a>
                        </div>
                        <!-- /Order Details -->
                    </div>
                    <!-- /row -->
                </form>
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->

        <!-- /NEWSLETTER -->
    @endsection
