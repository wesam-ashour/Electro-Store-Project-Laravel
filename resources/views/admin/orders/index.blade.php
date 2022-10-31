@extends('admin.layouts.master')
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
                    <div style="display: inline-block;">
                        <form method="GET">
                            <div class="input-group mb-5">
                                <form action="{{ route('show_orders_all') }}">
                                    <input type="text" name="search" value="{{ request()->get('search') }}"
                                        class="form-control" placeholder="Search..." aria-label="Search"
                                        aria-describedby="button-addon2">&nbsp;&nbsp;

                                    <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                                    &nbsp;&nbsp;

                                    <select id='status' class="form-control" name="filter">

                                        <option {{ is_null(request()->input('filter')) ? 'selected' : '' }} value="0">
                                            -Select-</option>

                                        <option {{ request()->input('filter') == 1 ? 'selected' : '' }} value="1">
                                            Alphabetical</option>

    

                                        <option {{ request()->input('filter') == 2 ? 'selected' : '' }} value="2">
                                            Date of registration</option>

                                    </select>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-warning">Sort</button>
                                    &nbsp;&nbsp;
                                    <select id='status' class="form-control" name="export">

                                        <option {{ is_null(request()->input('export')) ? 'selected' : '' }} value="">
                                            -Select-</option>

                                        <option {{ request()->input('export') == 1 ? 'selected' : '' }} value="1">PDF
                                        </option>

                                        <option {{ request()->input('export') == 2 ? 'selected' : '' }} value="2">
                                            EXCEL</option>

                                        <option {{ request()->input('export') == 3 ? 'selected' : '' }} value="3">CSV
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
                                    <th class="wd-lg-20p"><span>order number</span></th>
                                    <th class="wd-lg-20p"><span>created at</span></th>
                                    <th class="wd-lg-20p"><span>user name</span></th>
                                    <th class="wd-lg-20p"><span>email</span></th>
                                    <th class="wd-lg-20p"><span>mobile</span></th>
                                    <th class="wd-lg-20p"><span>status</span></th>
                                    <th class="wd-lg-20p"><span>total</span></th>
                                    <th class="wd-lg-20p"><span>payment method</span></th>
                                    <th class="wd-lg-20p"><span>address</span></th>

                                    <th class="wd-lg-20p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>
                                            <a>{{ $order->order_number }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $order->created_at }}</a>
                                        </td>
                                        <td>{{ \App\Models\User::find($order->user_id)->first_name . ' ' . \App\Models\User::find($order->user_id)->last_name }}</td>
                                        <td>
                                            <a>{{ \App\Models\User::find($order->user_id)->email }}</a>
                                        </td>
                                        <td>
                                            <a>{{ \App\Models\User::find($order->user_id)->mobile }}</a>
                                        </td>
                                        
                                        <td>
                                            <a><label class="badge badge-success">{{ $order->status }}</label></a>
                                        </td>
                                        <td>
                                            <a>{{ $order->grand_total }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $order->payment_method }}</a>
                                        </td>
                                        <td>
                                            <a href="{{route('address_for_order',$order->address_id)}}">Click</a>
                                        </td>
                                        {{-- <td class="text-center">
                                            @if ($admin->status == '1')
                                                <span class="label text-success d-flex">
                                                    <div class="dot-label bg-success mr-1"></div> Active
                                                @else
                                                    <span class="label text-muted d-flex">
                                                        <div class="dot-label bg-gray-300 mr-1"></div>Inactive
                                            @endif
                                        </td> --}}
                                        <td>
                                            <a href="{{ route('show_orders_all_details', $order->id) }}" class="btn btn-sm btn-primary">
                                                <i class="las la-search"></i>
                                            </a>
                                            <a href="{{ route('edit_orders_status', $order->id) }}" class="btn btn-sm btn-info">
                                                <i class="las la-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
