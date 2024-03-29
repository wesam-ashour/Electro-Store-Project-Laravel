@extends('layouts.master')
@section('content')
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
                    <h2>{{ __('cart.Shopping_Cart_Details') }}</h2>
                </div>
                @if ($message = Session::get('success'))
                    <div class="p-4 mb-3 bg-green-400 rounded">
                        <p class="text-green-800">{{ $message }}</p>
                    </div>
                @endif
                @php $total = 0 @endphp
                <div class="content">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="items">
                                {{-- <table class="table align-middle mb-0 bg-white">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Position</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                    <div class="ms-3">
                                                        <p class="fw-bold mb-1">John Doe</p>
                                                        <p class="text-muted mb-0">john.doe@gmail.com</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">Software engineer</p>
                                                <p class="text-muted mb-0">IT department</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-success rounded-pill d-inline">Active</span>
                                            </td>
                                            <td>Senior</td>
                                            <td>
                                                <button type="button" class="btn btn-link btn-sm btn-rounded">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                                @foreach ($carts['color_items'] as $key => $details)
                                    <form method="POST" action="{{ route('update.cart', $key) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" value="{{ $carts['id'] }}" name="idProduct">
                                        <input type="hidden" value="{{ $key }}" name="idItem">
                                        <input type="hidden" value="{{ $carts['id'] }}" name="idCart">
                                        <div>
                                            <div class="product">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img class="img-fluid mx-auto d-block image"
                                                            style="height: 180px;width: 180px"
                                                            src="{{ asset('images/cover/' . \App\Models\Product::find($carts['id'])->cover) }}">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="info">
                                                            <div class="row">
                                                                <div class="col-md-5 product-name">
                                                                    <div class="product-name">
                                                                        <a
                                                                            href="#">{{ \App\Models\Product::find($carts['id'])->title }}</a>
                                                                        <div class="product-info">
                                                                            <div><span
                                                                                    class="value">{{ \App\Models\Size::find($details['size'])->name }}</span>
                                                                            </div>
                                                                            <div><span
                                                                                    class="value">{{ \App\Models\Color::find($details['color'])->name }}</span>
                                                                                <input type="hidden" name="color"
                                                                                    value="{{ $details['color'] }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 quantity">
                                                                    <label
                                                                        for="quantity">{{ __('cart.Quantity') }}:</label>
                                                                    <div class="qty-label">
                                                                        <div class="input-number">
                                                                            <input id="qty" type="number"
                                                                                name="quantity"
                                                                                value="{{ $details['quantity'] }}"
                                                                                class="form-control quantity">
                                                                            <span class="qty-up">+</span>
                                                                            <span class="qty-down">-</span>
                                                                        </div>
                                                                        <br>
                                                                        <button type="submit"
                                                                            class="btn btn-button-primary">{{ __('cart.Update') }}</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <span>{{ __('cart.Price') }}:
                                                                        ${{ \App\Models\Product::find($carts['id'])->price }}</span>
                                                                </div>
                                                                <br>
                                                                <div class="col-md-3">
                                                                    @php $total = \App\Models\Product::find($carts['id'])->price * $details['quantity'] @endphp
                                                                    <span>{{ __('cart.Subtotal') }}:
                                                                        ${{ $total }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </form>
                                    <form action="{{ route('clearCartItems', $key) }}" method="post">
                                        @csrf
                                        {{-- @method('PUT') --}}
                                        @method('DELETE')
                                        <input type="hidden" value="{{ $key }}" name="idItem">
                                        <input type="hidden" value="{{ $carts['id'] }}" name="idCart">
                                        <input type="hidden" value="{{ $id }}" name="id">

                                        <button type="submit" class="btn btn-danger-gradient">x</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            </div>
            </div>
            </div>
        </section>
    </main>
@endsection
