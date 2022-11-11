@extends('admin.layouts.master')
@section('content')
    <style>
        .dott {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            margin: 10px;
            display: inline-block;
            justify-content: center;
            align-items: center;

        }
    </style>
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Coupons Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    CouponssList</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Coupons Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all coupons</p>
                    <div class="row row-xs wd-xl-80p">

                        <div class="pull-right">
                            <a class="btn btn-primary-gradient btn-block" href="{{ route('coupons.create') }}"> Create
                                New
                                Coupon</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (count($coupons))
                            <table class="table table-striped mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Code</th>
                                        <th>Value</th>
                                        <th>Type</th>
                                        <th>Min Order Amount</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $coupon->title }}</td>
                                            <td>{{ $coupon->code }}</td>

                                            <td>{{ $coupon->value }}</td>

                                            <td>{{ $coupon->type }}</td>

                                            <td>{{ $coupon->min_order_amt }}</td>

                                            <td>
                                                @if ($coupon->status == 1)
                                                    Active
                                                @else
                                                    In active
                                                @endif
                                            </td>
                                            <td>{{ $coupon->created_at }}</td>

                                            <td style="display: inline-block;">


                                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="las la-pen"></i>
                                                </a>
                                                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="post"
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
                        @else
                            No coupons found
                        @endif
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
@endsection
