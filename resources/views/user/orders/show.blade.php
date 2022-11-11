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
                        <th scope="col">product name</th>
                        <th scope="col">quantity</th>
                        <th scope="col">price</th>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
@endsection
