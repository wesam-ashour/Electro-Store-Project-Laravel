@extends('admin.layouts.master')
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
                                    <i class="fe fe-users tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">Users</span>
                                    <h2 class="text-white mb-0">{{$users}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-danger-gradient text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fe fe-users tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">Celebrities</span>
                                    <h2 class="text-white mb-0">{{$celebrities}}</h2>
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
                                    <span class="text-white">Orders</span>
                                    <h2 class="text-white mb-0">{{$orders}}</h2>
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
                                    <span class="text-white">Transactions</span>
                                    <h2 class="text-white mb-0">{{$transactions}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-sm">

            <div class="col-md-12 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Last Orders</h4>
                            <i class="mdi mdi-dots-vertical"></i>
                        </div>
                        <p class="card-description mb-1"></p>
                        @forelse ($newOrders as $order)
                        
                        <div class="list d-flex align-items-center border-bottom py-3">
                           
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0">
                                    <b>{{$order->order_number}} </b>Items: {{$order->item_count}}
                                </p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-chart-pie text-muted mr-1"></i>
                                        <p class="mb-0">
                                            @if ($order->status == '1')
                                                <a class="badge badge-danger" href="#">canceled</a>
                                            @elseif ($order->status == '2')
                                                <a class="badge badge-warning" href="#">new order</a>
                                            @elseif ($order->status == '3')
                                                <a class="badge badge-secondary" href="#">pending</a>
                                            @elseif ($order->status == '4')
                                                <a class="badge badge-info" href="#">being bagged</a>
                                            @elseif ($order->status == '5')
                                                <a class="badge badge-primary" href="#">on the way</a>
                                            @elseif ($order->status == '6')
                                                <a class="badge badge-success" href="#">delivered</a>
                                            @endif
                                        </p>
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

            <div class="col-md-12 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Last Trasanctions</h4>
                            <i class="mdi mdi-dots-vertical"></i>
                        </div>
                        <p class="card-description mb-1"></p>
                        @forelse ($newTransactions as $transaction)
                        <div class="list d-flex align-items-center border-bottom py-3">
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0">
                                    <b>${{$transaction->order_amount}} </b>payment: {{$transaction->payment_method}}
                                </p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-approval text-muted mr-1"></i>
                                        <p class="mb-0">
                                            @if ($transaction->status == '1')
                                                    <span class="label text-success d-flex">
                                                         success
                                                    @elseif($transaction->status == '2')
                                                        <span class="label text-muted d-flex">
                                                            failed
                                                        @else
                                                            <span class="label text-muted d-flex">
                                                                refunded
                                                @endif
                                        </p>
                                    </div>
                                    <small class="text-muted ml-auto">{{$transaction->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Transactions Found!
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">New Messages</h4>
                            <i class="mdi mdi-dots-vertical"></i>
                        </div>
                        <p class="card-description mb-1"></p>
                        @forelse ($newMesseages as $messages)
                        <div class="list d-flex align-items-center border-bottom py-3">
                            
                            <div class="wrapper w-100 ml-3">
                                <p class="mb-0">
                                    <b>Name: {{$messages->name}} </b>
                                </p>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-email text-muted mr-1"></i>
                                        <p class="mb-0">{{$messages->email}} </p>
                                    </div>
                                    <small class="text-muted ml-auto">{{$messages->created_at->diffForHumans()}}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        No Messages Found!
                        @endforelse
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
