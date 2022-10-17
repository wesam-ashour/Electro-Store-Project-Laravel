@extends('admin.layouts.master')
@section('content')
    <br>
    <section class="section-pagetop bg-dark">
        <div class="container clearfix">
            <h2 class="title-page">Checkout</h2>
        </div>
    </section>
    <section class="section-content bg padding-y">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @if (Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                </div>
            </div>
            <form action="{{ route('checkout.place.order') }}" method="POST" role="form" class="validation"
                  data-cc-on-file="false"
                  data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                  id="payment-form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <header class="card-header">
                                <h4 class="card-title mt-2">Billing Details</h4>
                            </header>
                            <article class="card-body">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ auth()->user()->first_name }}">
                                    </div>
                                    <div class="col form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ auth()->user()->last_name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>City</label>
                                        <input type="text" class="form-control" name="city">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group  col-md-6">
                                        <label>Post Code</label>
                                        <input type="text" class="form-control" name="post_code">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" disabled>
                                    <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label>Order Notes</label>
                                    <textarea class="form-control" name="notes" rows="6"></textarea>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <header class="card-header">
                                        <?php $total = 0 ?>
                                        @foreach(session('cart') as $id => $details)
                                        <h4 class="card-title mt-2">Your Order</h4>
                                        <h5 class="card-title mt-2">{{$loop->iteration}}- {{\App\Models\Product::find($details['id'])->title}}</h5>
                                    </header>
                                    <article class="card-body">
                                        <dl class="dlist-align">
                                                <?php $sum = 0 ?>
                                            @foreach($details['color_items'] as $key=> $c)
                                                    <?php $sum+= $c['quantity'] ?>

                                                {{--                                                        @php $total += \App\Models\Product::find($details['id'])->price * $c['quantity'] @endphp--}}
                                                {{--                                                        <input type="number" value="${{$c['quantity']}}"--}}
                                                {{--                                                               class="form-control quantity update-cart" disabled/>--}}
                                            @endforeach
                                            <dt>Total cost: </dt>

{{--                                                    <h6> {{$loop->iteration}}--}}
{{--                                                        - {{\App\Models\Product::find($details['id'])->title}}</h6>--}}
                                                    @php $total += \App\Models\Product::find($details['id'])->price * $sum @endphp

{{--                                                <?php echo $sum ?>--}}
                                            <input type="hidden" name="item_count" value="{{$sum}}">

                                            @endforeach
                                            <dd class="text-right h5 b"> ${{ $total }} </dd>
                                            <input type="hidden" name="grand_total" value="{{$total}}">
                                        </dl>
                                    </article>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group required'>
                                        <label class='control-label'>Name on Card</label> <input
                                            class='form-control' size='4' type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group card required'>
                                        <label class='control-label'>Card Number</label> <input
                                            autocomplete='off' class='form-control card-num' size='20'
                                            type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label>
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4'
                                               type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> <input
                                            class='form-control card-expiry-month' placeholder='MM' size='2'
                                            type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label> <input
                                            class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                            type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-md-12 hide error form-group'>
                                        <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now (₹100)</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="subscribe btn btn-success btn-lg btn-block">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
