@extends('layouts.master')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('welcome.productـname') }}</th>
                        <th scope="col">{{ __('welcome.quantity') }}</th>
                        <th scope="col">{{ __('welcome.price') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderDetails as $order)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            @if (\App\Models\Product::withTrashed()->find($order->product_id))
                            <th>{{ \App\Models\Product::withTrashed()->find($order->product_id)->title}}</th>

                            @else
                            <th>{{ \App\Models\Product::find($order->product_id)->title}}</th>

                            @endif
                            <th>{{ $order->quantity }}</th>
                            <th>{{ $order->price }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
