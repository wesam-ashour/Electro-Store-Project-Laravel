@extends('layouts.master')
@section('content')
    <!-- BREADCRUMB -->
    <div class="section">
        <!-- container -->
        <div class="container">
            @if (count($orders))
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('welcome.order_number') }}</th>
                            <th scope="col">{{ __('welcome.total') }}</th>
                            <th scope="col">{{ __('welcome.item_count') }}</th>
                            <th scope="col">{{ __('welcome.payment_method') }}</th>
                            <th scope="col">{{ __('welcome.payment_status') }}</th>
                            <th scope="col">{{ __('welcome.Action') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $order->order_number }}</td>

                                <td>{{ '$' . $order->grand_total }}</td>
                                <td>{{ __('welcome.items') }}:{{' '. $order->item_count }} 
                                    <a style="color:blue; padding-left:7px;"
                                        href="{{ route('orders.show', $order->id) }}">
                                        ({{ __('welcome.Details') }})
                                    </a>
                                </td>
                                <td>
                                    @if ($order->payment_method == 'COD')
                                        {{ __('welcome.Cash_on_delivery') }}
                                    @else
                                        {{ $order->payment_method }}
                                    @endif
                                </td>
                                <td>
                                    @if ($order->payment_status == 1)
                                        {{ __('welcome.Success') }}
                                    @elseif ($order->payment_status == 0)
                                        {{ __('welcome.Pending') }}
                                    @elseif ($order->payment_status == 4)
                                        {{ __('welcome.Refunded') }}
                                    @else
                                        {{ __('welcome.canceled') }}
                                    @endif
                                </td>
                                <td>
                                    <a style="color: red;"
                                        href="{{ route('orders.trackOrder', $order->id) }}">{{ __('welcome.Track_Order') }}
                                    </a>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
                {{ $orders->links() }}
            @else
                <strong>{{ __('welcome.No_orders_found') }}</strong>
            @endif
        </div>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script> --}}

@endsection
