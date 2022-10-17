@extends('admin.layouts.master')

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ecommerce</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Product-Cart</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon mr-2"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-danger btn-icon mr-2"><i class="mdi mdi-star"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon mr-2"><i class="mdi mdi-refresh"></i></button>
            </div>
            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate"
                         data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    @if( count((array) session('cart')) != 0)
        <!-- row opened -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Shopping Cart-->
                        @php $total = 0 @endphp

                        @if(session('cart'))

                            <div class="product-details table-responsive text-nowrap">
                                <table class="table table-bordered table-hover mb-0 text-nowrap">
                                    <thead>


                                    <th class="text-left">Product</th>
                                    <th class="w-150">Quantity</th>
                                    <th class="w-150">Details</th>
                                    <th>Price</th>
                                    <th>SUBTOTAL</th>

                                    <th><a class="btn btn-sm btn-outline-danger" href="{{route('clearCart')}}">Clear Cart</a></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(session('cart') as $id => $details)
                                        <tr data-id="{{ $id }}">
                                            <td>
                                                <div class="media">
                                                    <div class="card-aside-img">
                                                        {{--                                            <img src="{{asset('storage/'.$details['cover'])}}" alt="img" class="h-60 w-60">--}}
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="card-item-desc mt-0">
                                                            <dt>Product Name:</dt>
                                                            <h6 class="font-weight-semibold mt-0 text-uppercase">{{ \App\Models\Product::find($details['id'])->title}}
                                                            </h6>
{{--                                                            <dl class="card-item-desc-1">--}}
{{--                                                                <dt>Size:</dt>--}}
{{--                                                                @foreach(collect($details['color_items'])->pluck('size')->unique() as $size)--}}
{{--                                                                    <dd>--}}
{{--                                                                        {{  \App\Models\Size::find($size)->name }}--}}
{{--                                                                    </dd>--}}
{{--                                                                @endforeach--}}
{{--                                                            </dl>--}}
{{--                                                            <dl class="card-item-desc-1">--}}
{{--                                                                <dt>Color:</dt>--}}
{{--                                                                @foreach(collect($details['color_items'])->pluck('color')->unique() as $color)--}}
{{--                                                                    <dd>--}}
{{--                                                                        {{  \App\Models\Color::find($color)->name }}--}}
{{--                                                                    </dd>--}}
{{--                                                                @endforeach--}}
{{--                                                            </dl>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <?php $sum = 0 ?>
                                                    @foreach($details['color_items'] as $key=> $c)
                                                       <?php $sum+= $c['quantity'] ?>

{{--                                                        @php $total += \App\Models\Product::find($details['id'])->price * $c['quantity'] @endphp--}}
{{--                                                        <input type="number" value="${{$c['quantity']}}"--}}
{{--                                                               class="form-control quantity update-cart" disabled/>--}}
                                                    @endforeach
                                                    <?php echo $sum ?>


                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <a  href="{{route('checkout.details',$id)}}">Details</a>
                                                </div>
                                            </td>
                                                                            <td class="text-center text-lg text-medium">${{ \App\Models\Product::find($details['id'])->price }}</td>
                                                                            <td class="text-center text-lg text-medium">${{ \App\Models\Product::find($details['id'])->price * $sum }}</td>
                                            <td class="text-center"><a class="remove-from-cart" href="#"
                                                                       data-toggle="tooltip" title=""
                                                                       data-original-title="Remove item"><i
                                                        class="fa fa-trash"></i></a></td>
                                        </tr>
                                        @php $total += \App\Models\Product::find($details['id'])->price * $sum @endphp

                                    @endforeach

                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="shopping-cart-footer  border-top-0">
                                <div class="column">
                                    <form class="coupon-form" method="post">
                                        <input class="form-control" type="text" placeholder="Coupon code" required="">
                                        <button class="btn btn-outline-primary" type="submit">Apply Coupon</button>
                                    </form>
                                </div>
                                                        <div data-th="Subtotal" class="column text-lg">Subtotal: ${{$total}}<span class="tx-20 font-weight-bold ml-2"></span></div>

                            </div>
                            <div class="shopping-cart-footer">
                                <div class="column"><a class="btn btn-secondary" href="{{route('products.index')}}">Back to Shopping</a></div>
                                <div class="column"><a
                                        class="btn btn-success" href="{{route('checkout.index')}}">Checkout</a></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    @else
        No Products Found!
    @endif

@endsection
