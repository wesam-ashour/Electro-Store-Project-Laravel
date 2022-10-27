@extends('admin.layouts.master')
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Orders Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Order List</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">ORDERS Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all orders</p>
                    <div class="row row-xs wd-xl-80p">
                        <div class="pull-right">
                        </div>
                    </div>
                </div>
                @if (count($orders))
                    <div class="card-body">
                        <div class="table-responsive border-top userlist-table">
                            <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-20p"><span>order number</span></th>
                                        <th class="wd-lg-20p"><span>grand total</span></th>
                                        <th class="wd-lg-20p"><span>item count</span></th>
                                        <th class="wd-lg-20p"><span>payment status</span></th>
                                        <th class="wd-lg-20p"><span>payment method</span></th>
                                        <th class="wd-lg-20p"><span>created at</span></th>
                                        <th class="wd-lg-20p"><span>updated at</span></th>
                                        <th class="wd-lg-20p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->grand_total }}</td>
                                            <td>{{ $order->item_count }}</td>
                                            <td>
                                                @if ($order->payment_status == 1)
                                                    Success
                                                @else
                                                    Failure
                                                @endif
                                            </td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('show_orders_details_user', $order->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="las la-search"></i>
                                                </a>
                                                <a href="{{ route('edit_orders_user', $order->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="las la-pen"></i>
                                                </a>
                                                <form action="{{ route('delete_orders_user', $order->id) }}" method="post"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $orders->links() }}
                        </div>

                    </div>
                @else
                    <br>
                    <h4>No Orders Found</h4>
                @endif
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
