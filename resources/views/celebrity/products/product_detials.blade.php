@extends('celebrity.layouts.master')
@section('content')
<style>
    .dott {
      height: 25px;
      width: 25px;
      border-radius: 50%;
      display: inline-block;
    }
    </style>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ecommerce</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Product-Detaisl</span>
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-primary-gradient btn-block" href="{{ route('create_color_product', $products) }}"> Add
                    New
                    Product Color</a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row opened -->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Shopping Cart-->
                    <div class="product-details table-responsive text-nowrap">
                        @if (count($productsColor))
                            <table class="table table-bordered table-hover mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-left">Product</th>
                                        <th class="w-150">Color</th>
                                        <th class="w-150">Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productsColor as $product)
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="card-aside-img">
                                                        <img src="{{ asset('storage/' . $product['logo']) }}" alt="img"
                                                            class="h-60 w-60">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="card-item-desc mt-0">
                                                            <h6 class="font-weight-semibold mt-0 text-uppercase">
                                                                Product title: <br><br>
                                                                {{ \App\Models\Product::find($product['product_id'])->title }}
                                                            </h6>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="dott" style="background-color:{{ \App\Models\Color::find($product['color_id'])->color }}"></span>
                                               </td>

                                            <td class="text-center">{{ $product['quantity'] }}</td>
                                            <td class="text-center">
                                                <a class="form-control"
                                                    href="{{ route('edit_details_products', $product->id) }}"><i
                                                        class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('delete_color_products', $product->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="form-control"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        @else
                            No product color found!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
