@extends('celebrity.layouts.master')
@section('content')

<br>
    <!-- row opened -->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Products Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all products</p>
                    <div class="row row-xs wd-xl-80p">

                        <div class="pull-right">
                            <a class="btn btn-primary-gradient btn-block" href="{{ route('products.create') }}"> Create
                                New
                                Product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Shopping Cart-->
                    <div class="product-details table-responsive text-nowrap">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-left">Product</th>
                                    <th class="w-150">Quantity</th>
                                    <th class="w-150">SubCategory</th>
                                    <th>Subtotal</th>
                                    <th>Discount</th>
                                    <th>Detaisl</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="card-aside-img">
                                                    <img src="{{ asset('images/cover/' . $product['cover']) }}" alt="img"
                                                        class="h-60 w-60">
                                                </div>
                                                <div class="media-body">
                                                    <div class="card-item-desc mt-0">
                                                        <h6 class="font-weight-semibold mt-0 text-uppercase">
                                                            {{ $product['title'] }}</h6>
                                                        <dl class="card-item-desc-1">
                                                            <dt>Size:</dt>
                                                            @foreach ($product->size as $size)
                                                                <dd class="tag-sm">{{ $size->name  }}</dd>
                                                            @endforeach
                                                        </dl>
                                                        <dl class="card-item-desc-1">
                                                            <dt>Color:</dt>
                                                            @foreach ($product->color_product as $colors)
                                                                <dd class="tag-sm">{{ $colors->color->name }}</dd>
                                                            @endforeach

                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center text-lg text-medium" style="color: orangered">
                                                @php $total = 0; @endphp
                                                @foreach ($product->color_product as $pro)
                                                    @php $total += $pro->quantity; @endphp
                                                @endforeach
                                                {{ $total }}
                                            </div>
                                        </td>
                                        <td class="text-center text-lg text-medium">
                                            @foreach ($product->category as $cats)
                                                {{ $cats->name }}
                                            @endforeach
                                        </td>
                                        <td class="text-center text-lg text-medium">{{ $product->price }}</td>
                                        <td class="text-center text-lg text-medium">{{ $product->offer_price }}</td>
                                        <td class="text-center"><a class="form-control"
                                                href="{{ route('edit_all_details_products', $product->id) }}">Details</a></td>
                                        <td class="text-center">
                                            <a class="form-control" href="{{ route('products.edit', $product->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="form-control"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{ $products->links() }}
        </div>
    </div>
@endsection
