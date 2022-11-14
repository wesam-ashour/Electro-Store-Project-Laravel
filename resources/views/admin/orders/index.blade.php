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
                    @if (count($orders) > 0)
                        
                    
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
                                            last 3 months</option>



                                        <option {{ request()->input('filter') == 2 ? 'selected' : '' }} value="2">
                                            last 6 months</option>
                                        <option {{ request()->input('filter') == 3 ? 'selected' : '' }} value="3">
                                            last 9 months</option>
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
                                    <th class="wd-lg-20p"><span>total</span></th>
                                    <th class="wd-lg-20p"><span>payment method</span></th>
                                    <th class="wd-lg-20p"><span>payment status</span></th>
                                    <th class="wd-lg-20p"><span>status</span></th>
                                    <th class="wd-lg-20p"><span>Details</span></th>
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
                                        <td>
                                            <a>{{ $order->grand_total }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $order->payment_method }}</a>
                                        </td>
                                        <td>
                                            <a>
                                                @if ($order->payment_status == 1)
                                                    Success
                                                @elseif ($order->payment_status == 0)
                                                    Pending
                                                @elseif ($order->payment_status == 4)
                                                    Refunded
                                                @else
                                                    canceled
                                                @endif
                                            </a>
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <a href="{{ route('address_for_order', $order->id) }}">Details</a>
                                        </td>

                                        <td>
                                            @if ($order->status == '2' || $order->status == '3')
                                                <a href="{{ route('orders.cancel', $order->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-sm">
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            <a href="{{ route('show_orders_all_details', $order->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="las la-search"></i>
                                            </a>
                                            {{-- <a href="{{ route('edit_orders_status', $order->id) }}" class="btn btn-sm btn-info">
                                                <i class="las la-pen"></i>
                                            </a> --}}
                                            <form method="POST" action="{{ route('update_orders_status', $order) }}"
                                                style="display: inline-block">
                                                @csrf
                                                @method('PUT')

                                                <div class="col-sm-6 col-md-3 mg-t-10 mg-sm-t-0">
                                                    <div class="dropdown dropleft">
                                                        <button aria-expanded="false" aria-haspopup="true"
                                                            class="btn ripple btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" id="dropleftMenuButton"
                                                            type="button">Change status</button>
                                                        <div aria-labelledby="dropleftMenuButton"
                                                            class="dropdown-menu tx-13">
                                                            @if ($order->status == 'refunded' || $order->status == '1' || $order->status == '6')
                                                                <a class="dropdown-item"> No Actions</a>
                                                            @else
                                                                <button class="dropdown-item" name="status"
                                                                    value="{{ \App\Models\Status::where('id', '>', $order->status)->orderBy('id')->first()->id }}">

                                                                    {{ \App\Models\Status::where('id', '>', $order->status)->orderBy('id')->first()->status }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>




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
