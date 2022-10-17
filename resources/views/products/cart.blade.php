@extends('layouts.master')
@section('content')
    <br>
    <style>
        .shopping-cart{
            padding-bottom: 50px;
            font-family: 'Montserrat', sans-serif;
        }

        .shopping-cart.dark{
            background-color: #f6f6f6;
        }

        .shopping-cart .content{
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
            background-color: white;
        }

        .shopping-cart .block-heading{
            padding-top: 50px;
            margin-bottom: 40px;
            text-align: center;
        }

        .shopping-cart .block-heading p{
            text-align: center;
            max-width: 420px;
            margin: auto;
            opacity:0.7;
        }

        .shopping-cart .dark .block-heading p{
            opacity:0.8;
        }

        .shopping-cart .block-heading h1,
        .shopping-cart .block-heading h2,
        .shopping-cart .block-heading h3 {
            margin-bottom:1.2rem;
            color: #3b99e0;
        }

        .shopping-cart .items{
            margin: auto;
        }

        .shopping-cart .items .product{
            margin-bottom: 20px;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .shopping-cart .items .product .info{
            padding-top: 0px;
            text-align: center;
        }

        .shopping-cart .items .product .info .product-name{
            font-weight: 600;
        }

        .shopping-cart .items .product .info .product-name .product-info{
            font-size: 14px;
            margin-top: 15px;
        }

        .shopping-cart .items .product .info .product-name .product-info .value{
            font-weight: 400;
        }

        .shopping-cart .items .product .info .quantity .quantity-input{
            margin: auto;
            width: 80px;
        }

        .shopping-cart .items .product .info .price{
            margin-top: 15px;
            font-weight: bold;
            font-size: 22px;
        }

        .shopping-cart .summary{
            border-top: 2px solid #5ea4f3;
            background-color: #f7fbff;
            height: 100%;
            padding: 30px;
        }

        .shopping-cart .summary h3{
            text-align: center;
            font-size: 1.3em;
            font-weight: 600;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .shopping-cart .summary .summary-item:not(:last-of-type){
            padding-bottom: 10px;
            padding-top: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .shopping-cart .summary .text{
            font-size: 1em;
            font-weight: 600;
        }

        .shopping-cart .summary .price{
            font-size: 1em;
            float: right;
        }

        .shopping-cart .summary button{
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
                                            <img class="img-fluid mx-auto d-block image" style="height: 180px;width: 180px" src="{{asset('storage/'. \App\Models\Product::find($details['id'])->cover)}}">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-5 product-name">
                                                        <div class="product-name">
                                                            <a href="#">{{ \App\Models\Product::find($details['id'])->title}}</a>
                                                            <div class="product-info">
                                                                <div ><span class="value"><a style="color: red" href="{{route('checkout.details',$details['id'])}}">Details</a></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="" method="POST">
                                                        @csrf
                                                        <div class="col-md-4 quantity">
                                                            <label for="quantity">Quantity:</label>
{{--                                                            <input type="hidden" name="id" value="{{ $item->id}}" >--}}
                                                                <?php $sum = 0 ?>
                                                            @foreach($details['color_items'] as $key=> $c)
                                                                    <?php $sum+= $c['quantity'] ?>

                                                                {{--                                                        @php $total += \App\Models\Product::find($details['id'])->price * $c['quantity'] @endphp--}}
                                                                {{--                                                        <input type="number" value="${{$c['quantity']}}"--}}
                                                                {{--                                                               class="form-control quantity update-cart" disabled/>--}}
                                                            @endforeach
                                                            <input disabled type="number" value ="{{ $sum }}" class="form-control">

                                                        </div>
                                                    </form>

                                                    <div class="col-md-3">
                                                        <span>Price: ${{ \App\Models\Product::find($details['id'])->price }}</span>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-3">
                                                        <span>Subtotal: ${{ \App\Models\Product::find($details['id'])->price * $sum }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{route('remove.from.cart')}}">
                                            <input type="hidden" id="myid" data-item-id="{{ $id }}" value="{{ $id}}" name="id">
                                            <button class="px-4 py-2 text-white bg-red-600 remove-from-cart">x</button>
                                        </form>
                                    </div>
                                </div>
                                    @php $total += \App\Models\Product::find($details['id'])->price * $sum @endphp
                                @empty
                                    No products found in cart!
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="summary">
                                <h3>Summary</h3>
                                <div class="summary-item"><span class="text">Subtotal</span><span class="price">${{$total}}</span></div>
                                <div class="summary-item"><span class="text">Discount</span><span class="price">$0</span></div>
                                <div class="summary-item"><span class="text">Shipping</span><span class="price">$0</span></div>
                                <div class="summary-item"><span class="text">Total</span><span class="price">${{$total}}</span></div>
                                <button type="button" class="btn btn-primary btn-lg btn-block">Checkout</button>
                                <div>


                                        <a href="{{route('clearCart')}}" class="px-6 py-2 text-red-800 bg-red-300">Remove All Cart</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection


{{--@extends('layouts.master')--}}


{{--@section('content')--}}
{{--    <main class="my-8">--}}
{{--        <div class="container px-6 mx-auto">--}}
{{--            <div class="flex justify-center my-6">--}}
{{--                <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">--}}
{{--                    @if ($message = Session::get('success'))--}}
{{--                        <div class="p-4 mb-3 bg-green-400 rounded">--}}
{{--                            <p class="text-green-800">{{ $message }}</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <h3 class="text-3xl text-bold">Cart List</h3>--}}
{{--                    <div class="flex-1">--}}
{{--                        <table class="w-full text-sm lg:text-base" cellspacing="0">--}}
{{--                            <thead>--}}
{{--                            <tr class="h-12 uppercase">--}}
{{--                                <th class="hidden md:table-cell"></th>--}}
{{--                                <th class="text-left">Name</th>--}}
{{--                                <th class="pl-5 text-left lg:text-right lg:pl-0">--}}
{{--                                    <span class="lg:hidden" title="Quantity">Qtd</span>--}}
{{--                                    <span class="hidden lg:inline">Quantity</span>--}}
{{--                                </th>--}}
{{--                                <th class="hidden text-right md:table-cell"> price</th>--}}
{{--                                <th class="hidden text-right md:table-cell"> Remove </th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach ($cartItems as $item)--}}
{{--                                <tr>--}}
{{--                                    <td class="hidden pb-4 md:table-cell">--}}
{{--                                        <a href="#">--}}
{{--                                            <img src="{{ $item->attributes->image }}" class="w-20 rounded" alt="Thumbnail">--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <a href="#">--}}
{{--                                            <p class="mb-2 md:ml-4">{{ $item->name }}</p>--}}

{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                    <td class="justify-center mt-6 md:justify-end md:flex">--}}
{{--                                        <div class="h-10 w-28">--}}
{{--                                            <div class="relative flex flex-row w-full h-8">--}}

{{--                                                <form action="{{ route('cart.update') }}" method="POST">--}}
{{--                                                    @csrf--}}
{{--                                                    <input type="hidden" name="id" value="{{ $item->id}}" >--}}
{{--                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"--}}
{{--                                                           class="w-6 text-center bg-gray-300" />--}}
{{--                                                    <button type="submit" class="px-2 pb-2 ml-2 text-white bg-blue-500">update</button>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td class="hidden text-right md:table-cell">--}}
{{--                                <span class="text-sm font-medium lg:text-base">--}}
{{--                                    ${{ $item->price }}--}}
{{--                                </span>--}}
{{--                                    </td>--}}
{{--                                    <td class="hidden text-right md:table-cell">--}}
{{--                                        <form action="{{ route('cart.remove') }}" method="POST">--}}
{{--                                            @csrf--}}
{{--                                            <input type="hidden" value="{{ $item->id }}" name="id">--}}
{{--                                            <button class="px-4 py-2 text-white bg-red-600">x</button>--}}
{{--                                        </form>--}}

{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                        <div>--}}
{{--                            Total: ${{ Cart::getTotal() }}--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <form action="{{ route('cart.clear') }}" method="POST">--}}
{{--                                @csrf--}}
{{--                                <button class="px-6 py-2 text-red-800 bg-red-300">Remove All Cart</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </main>--}}
{{--@endsection--}}
