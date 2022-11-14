@extends('celebrity.layouts.master')
@section('content')
    <!-- container -->
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">Home</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                        Statics</span>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->

        <div class="row row-sm">

            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-primary-gradient text-white ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fe fe-tag tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">Categories</span>
                                    <h2 class="text-white mb-0">{{$categories}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-success-gradient text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fe fe-shopping-cart tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">Products</span>
                                    <h2 class="text-white mb-0">{{$products}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-warning-gradient text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fe fe-bar-chart-2 tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">Orders Items</span>
                                    <h2 class="text-white mb-0">{{$orders}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-sm">

            <div class="col-md-15 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Last Orders Items</h4>
                            <i class="mdi mdi-dots-vertical"></i>
                        </div>
                        <p class="card-description mb-1"></p>
                        @forelse ($newOrders as $order)
                        
                        <div class="list d-flex align-items-center border-bottom py-3">
                           
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0">
                                   Product Name: <b>{{ \App\Models\Product::find($order->product_id)->title }} </b>
                                </p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-chart-pie text-muted mr-1"></i>quantity: {{ $order->quantity }}
                                    </div>
                                    <small class="text-muted ml-auto">{{$order->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Orders Found!
                        @endforelse
                    </div>
                </div>
            </div>

            


        </div>
    </div>
@endsection
