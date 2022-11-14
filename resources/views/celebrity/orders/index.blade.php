@extends('celebrity.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Orders Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Orderlist</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Orders Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all orders</p>
                </div>
                <div class="card-body">
                    @if (count($orders) > 0)
                        <div style="display: inline-block;">
                            <form method="GET">
                                <div class="input-group mb-5">
                                    <form action="{{ route('show_orders_all') }}">
                                        
                                        <select id='status' class="form-control" name="filter">

                                            <option {{ is_null(request()->input('filter')) ? 'selected' : '' }}
                                                value="0">
                                                -Select-</option>

                                            <option {{ request()->input('filter') == 1 ? 'selected' : '' }} value="1">
                                                Last 3 months</option>



                                            <option {{ request()->input('filter') == 2 ? 'selected' : '' }} value="2">
                                                Last 6 months</option>

                                            <option {{ request()->input('filter') == 3 ? 'selected' : '' }} value="3">
                                                Last 9 months</option>

                                        </select>&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-warning">Sort</button>
                                        &nbsp;&nbsp;
                                        <select id='status' class="form-control" name="export">

                                            <option {{ is_null(request()->input('export')) ? 'selected' : '' }}
                                                value="">
                                                -Select-</option>

                                            <option {{ request()->input('export') == 1 ? 'selected' : '' }} value="1">
                                                PDF
                                            </option>

                                            <option {{ request()->input('export') == 2 ? 'selected' : '' }} value="2">
                                                EXCEL</option>

                                            <option {{ request()->input('export') == 3 ? 'selected' : '' }} value="3">
                                                CSV
                                            </option>
                                        </select>&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-success">Export</button>
                                    </form>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive border-top userlist-table">
                            <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-20p"><span>order id</span></th>
                                        <th class="wd-lg-20p"><span>product</span></th>
                                        <th class="wd-lg-20p"><span>quantity</span></th>
                                        <th class="wd-lg-20p"><span>created at</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>
                                                <a>
                                                    {{ $loop->iteration }}
                                                </a>
                                            </td>
                                            <td>
                                                <a> {{ \App\Models\Product::find($order->product_id)->title }}</a>
                                            </td>
                                            <td>
                                                <a>{{ $order->quantity }}</a>
                                            </td>

                                            <td>
                                                <a>{{ $order->created_at }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $orders->links() }}
                        </div>
                    @else
                        No Orders Found!
                    @endif
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
