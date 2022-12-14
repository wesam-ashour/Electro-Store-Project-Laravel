@extends('admin.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">transactions Sections</h4><span
                    class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Transactionslist</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Transactions Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all transactions</p>
                </div>
                <div class="card-body">
                    @if (count($transactions) > 0)
                        <div style="display: inline-block;">
                            <form method="GET">
                                <div class="input-group mb-5">
                                    <form action="{{ route('transactions.index') }}">

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
                                        <button type="submit" class="btn btn-warning">Filter</button>
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
                                        <th class="wd-lg-20p"><span>User</span></th>
                                        <th class="wd-lg-20p"><span>Order item id</span></th>
                                        <th class="wd-lg-20p"><span>Order amount</span></th>
                                        <th class="wd-lg-20p"><span>Total paid amount</span></th>
                                        <th class="wd-lg-20p"><span>Payment method</span></th>
                                        <th class="wd-lg-20p"><span>Status</span></th>
                                        <th class="wd-lg-20p"><span>Created at</span></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $key => $transaction)
                                        <tr>
                                            <td><a
                                                    href="{{ route('users.show', $transaction->user_id) }}">{{ \App\Models\User::find($transaction->user_id)->first_name . ' ' . \App\Models\User::find($transaction->user_id)->last_name }}</a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('show_orders_all_details', $transaction->order_id) }}">{{ \App\Models\Order::find($transaction->order_id)->order_number }}</a>
                                            </td>
                                            <td>
                                                <a>{{ \App\Models\Order::find($transaction->order_id)->item_count }}</a>
                                            </td>
                                            <td>
                                                <a>{{ \App\Models\Order::find($transaction->order_id)->grand_total }}</a>
                                            </td>
                                            <td>
                                                <a>{{ $transaction->payment_method }}</a>
                                            </td>
                                            <td class="text-center">
                                                @if ($transaction->status == '1')
                                                    <span class="label text-success d-flex">
                                                        <div class="dot-label bg-success mr-1"></div> success
                                                    @elseif($transaction->status == '2')
                                                        <span class="label text-muted d-flex">
                                                            <div class="dot-label bg-gray-300 mr-1"></div>failed
                                                        @else
                                                            <span class="label text-muted d-flex">
                                                                <div class="dot-label bg-gray-300 mr-1"></div>refunded
                                                @endif
                                            </td>
                                            <td>
                                                <a>{{ $transaction->created_at }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $transactions->links() }}
                        </div>
                    @else
                        No Transactions Found!
                    @endif
                </div>

            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
