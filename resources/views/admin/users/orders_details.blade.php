@extends('admin.layouts.master')
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Orders Details Sections</h4><span
                    class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Order Details List</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">ORDERS details table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all order details</p>
                    <div class="row row-xs wd-xl-80p">
                        <div class="pull-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-lg-20p"><span>order number</span></th>
                                    <th class="wd-lg-20p"><span>product</span></th>
                                    <th class="wd-lg-20p"><span>quantity</span></th>
                                    <th class="wd-lg-20p"><span>price</span></th>
                                    <th class="wd-lg-20p"><span>created at</span></th>
                                    <th class="wd-lg-20p"><span>updated at</span></th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetails as $orders_detail)
                                    <tr>
                                        <td>{{ $orders_detail->order_id }}</td>
                                        <td>{{ $orders_detail->product->title}}</td>
                                        <td>{{ $orders_detail->quantity }}</td>
                                        <td>{{ $orders_detail->price }}</td>
                                        <td>{{ $orders_detail->created_at }}</td>
                                        <td>{{ $orders_detail->updated_at }}</td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        {{ $orderDetails->links() }}
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
