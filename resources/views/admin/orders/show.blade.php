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
                    </div>
                    <div class="table-responsive border-top userlist-table">
                        <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-lg-20p"><span>name</span></th>
                                    <th class="wd-lg-20p"><span>size</span></th>
                                    <th class="wd-lg-20p"><span>color</span></th>
                                    <th class="wd-lg-20p"><span>quantity</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $key => $orderItem)
                                    <tr>
                                        <td>
                                            <a>{{ \App\Models\Product::find($orderItem->product_id)->title }}</a>
                                        </td>
                                        <td>
                                            <a>{{ \App\Models\Size::find($orderItem->size_id)->name }}</a>
                                        </td>
                                        <td>
                                            <a>{{ \App\Models\Color::find($orderItem->color_id)->name }}</a>
                                        </td>
                                        <td>
                                            <a>{{ $orderItem->quantity }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        {{ $orderItems->links() }}
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
