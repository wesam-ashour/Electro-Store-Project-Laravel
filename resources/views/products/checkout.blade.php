@extends('layouts.master')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <style>

    </style>
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Checkout</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="#">Home</a></li>
                        <li class="active">Checkout</li>
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
                <form role="form" action="{{ route('stripe.post') }}" method="post"
                    data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    @csrf
                    <div class="col-md-7">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Billing address</h3>
                            </div>
                            <div class="form-group">
                                <label>First name</label>
                                <label></label>
                                <input class="input" type="text" value="{{ auth()->user()->first_name }}"
                                    name="first_name" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label>Last name</label>
                                <input class="input" type="text" value="{{ auth()->user()->last_name }}"
                                    name="last_name" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="input" type="email" value="{{ auth()->user()->email }}" name="email"
                                    placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input class="input" type="text" name="address" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input class="input" type="text" name="city" placeholder="City">
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <input class="input" type="text" name="country" placeholder="Country">
                            </div>
                            <div class="form-group">
                                <label>Post Code</label>
                                <input class="input" type="text" name="post_code" placeholder="Post Code">
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input class="input" type="tel" value="{{ auth()->user()->mobile }}"
                                    name="phone_number" placeholder="Telephone">
                            </div>
                        </div>
                        <!-- /Billing Details -->

                        <!-- Shiping Details -->

                        <!-- /Shiping Details -->

                        <!-- Order notes -->
                        <div class="order-notes">
                            <label>Notes</label>
                            <textarea class="input" name="notes" placeholder="Order Notes"></textarea>
                        </div>
                        <!-- /Order notes -->
                    </div>

                    <!-- Order Details -->
                    <div class="col-md-5 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Your Order</h3>
                        </div>
                        <div class="order-summary">
                            <div class="order-col">
                                <div><strong>PRODUCT</strong></div>
                                <div><strong>TOTAL</strong></div>
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
                                        <div>${{ \App\Models\Product::find($item['id'])->price * $sum }}</div>
                                    </div>
                                    @php $total += \App\Models\Product::find($item['id'])->price * $sum @endphp
                                @endforeach
                            </div>
                            <div class="order-col">
                                <div>Shiping</div>
                                <div><strong>FREE</strong></div>
                            </div>
                            <div class="order-col">
                                <div><strong>TOTAL</strong></div>
                                @if (count($remains))
                                    <div><strong class="order-total">${{ $remains['remain'] }}</strong></div>
                                @else
                                    <div><strong class="order-total">${{ $total }}</strong></div>
                                @endif
                            </div>
                        </div>
                        <div class="payment-method">

                            <div class="input-radio">
								<input type="radio" name="payment" id="payment-1">
								<label for="payment-1">
									<span></span>
									Credit Card
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
									Cash On Delevery
								</label>
								<div class="caption">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
							</div>
							

                            <button type="submit" class="primary-btn order-submit">Place order</a>
                        </div>
                        <!-- /Order Details -->
                    </div>
                    <!-- /row -->
                </form>
            </div>
            <!-- /container -->
        </div>
        <!-- /SECTION -->

        <!-- NEWSLETTER -->
        <div id="newsletter" class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="newsletter">
                            <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                            <form>
                                <input class="input" type="email" placeholder="Enter Your Email">
                                <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                            </form>
                            <ul class="newsletter-follow">
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /NEWSLETTER -->
    @endsection
