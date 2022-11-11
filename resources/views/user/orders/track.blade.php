@extends('layouts.master')
@section('content')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        ol.progtrckr {
            margin: 0;
            padding: 0;
            list-style-type none;
        }

        ol.progtrckr li {
            display: inline-block;
            text-align: center;
            line-height: 3.5em;
        }

        ol.progtrckr[data-progtrckr-steps="2"] li {
            width: 49%;
        }

        ol.progtrckr[data-progtrckr-steps="3"] li {
            width: 33%;
        }

        ol.progtrckr[data-progtrckr-steps="4"] li {
            width: 24%;
        }

        ol.progtrckr[data-progtrckr-steps="5"] li {
            width: 19%;
        }

        ol.progtrckr[data-progtrckr-steps="6"] li {
            width: 16%;
        }

        ol.progtrckr[data-progtrckr-steps="7"] li {
            width: 14%;
        }

        ol.progtrckr[data-progtrckr-steps="8"] li {
            width: 12%;
        }

        ol.progtrckr[data-progtrckr-steps="9"] li {
            width: 11%;
        }

        ol.progtrckr li.progtrckr-done {
            color: black;
            border-bottom: 4px solid yellowgreen;
        }

        ol.progtrckr li.progtrckr-cancel {
            color: black;
            border-bottom: 4px solid red;
        }

        ol.progtrckr li.progtrckr-todo {
            color: silver;
            border-bottom: 4px solid silver;
        }

        ol.progtrckr li:after {
            content: "\00a0\00a0";
        }

        ol.progtrckr li:before {
            position: relative;
            bottom: -2.5em;
            float: left;
            left: 50%;
            line-height: 1em;
        }

        ol.progtrckr li.progtrckr-done:before {
            content: "\2713";
            color: white;
            background-color: yellowgreen;
            height: 2.2em;
            width: 2.2em;
            line-height: 2.2em;
            border: none;
            border-radius: 2.2em;
        }

        ol.progtrckr li.progtrckr-todo:before {
            content: "\039F";
            color: silver;
            background-color: white;
            font-size: 2.2em;
            bottom: -1.2em;
        }
    </style>
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <article class="card">
                <header class="card-header"> My Orders / Tracking </header>
                <div class="card-body">
                    <h6>Order ID: {{ $order->id }}</h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Order Number #:</strong> <br> {{ $order->order_number }} </div>
                            <div class="col"> <strong>Status:</strong> <br>
                                @if ($order->status == '1')
                                    canceled
                                @elseif ($order->status == '2')
                                    new order
                                @elseif ($order->status == '3')
                                    pending
                                @elseif ($order->status == '4')
                                    being bagged
                                @elseif ($order->status == '5')
                                    on the way
                                @elseif ($order->status == '6')
                                    delivered
                                @endif

                            </div>
                            <div class="col"> <strong>Address:</strong> <br>
                                {{ \App\Models\Address::find($order->address_id)->area }}, | <i class="fa fa-phone"></i>
                                {{ \App\Models\User::find($user->id)->mobile }} </div>
                        </div>
                    </article>
                    <br>
                    <div class="track">
                        <ol class="progtrckr" data-progtrckr-steps="5">
                            @if ($order->status == '2')
                                <li class="progtrckr-done">New Order</li>
                                <li class="progtrckr-todo">Pending</li>
                                <li class="progtrckr-todo">Being bagged</li>
                                <li class="progtrckr-todo">on the way</li>
                                <li class="progtrckr-todo">Delivered</li>
                            @elseif($order->status == '3')
                                <li class="progtrckr-done">New Order</li>
                                <li class="progtrckr-done">Pending</li>
                                <li class="progtrckr-todo">Being bagged</li>
                                <li class="progtrckr-todo">on the way</li>
                                <li class="progtrckr-todo">Delivered</li>
                            @elseif($order->status == '4')
                                <li class="progtrckr-done">New Order</li>
                                <li class="progtrckr-done">Pending</li>
                                <li class="progtrckr-done">Being bagged</li>
                                <li class="progtrckr-todo">on the way</li>
                                <li class="progtrckr-todo">Delivered</li>
                            @elseif($order->status == '5')
                                <li class="progtrckr-done">New Order</li>
                                <li class="progtrckr-done">Pending</li>
                                <li class="progtrckr-done">Being bagged</li>
                                <li class="progtrckr-done">on the way</li>
                                <li class="progtrckr-todo">Delivered</li>
                            @elseif($order->status == '6')
                                <li class="progtrckr-done">New Order</li>
                                <li class="progtrckr-done">Pending</li>
                                <li class="progtrckr-done">Being bagged</li>
                                <li class="progtrckr-done">on the way</li>
                                <li class="progtrckr-done">Delivered</li>
                            @else
                                <li class="progtrckr-cancel">Canceled</li>
                                <li class="progtrckr-todo">Pending</li>
                                <li class="progtrckr-todo">Being bagged</li>
                                <li class="progtrckr-todo">on the way</li>
                                <li class="progtrckr-todo">Delivered</li>
                            @endif

                        </ol>
                    </div>
                    <br>

                    <hr>

                    <a href="{{ route('orders.index') }}" class="btn btn-warning" data-abc="true"> <i
                            class="fa fa-chevron-left"></i> Back to
                        orders</a>
                    @if ($order->status == '2' || $order->status == '3')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="get"
                            style="display: inline-block;">
                            @csrf
                            @method('post')
                            <a href="{{ route('orders.cancel', $order->id) }}" type="submit" class="btn btn-danger"
                                data-abc="true"> <i class="fa-solid fa-xmark"></i> Cancel
                                Order</a>
                        </form>
                    @endif
                    @if ($order->status == '5')
                        <form action="{{ route('orders.complete', $order->id) }}" method="get"
                            style="display: inline-block;">
                            @csrf
                            @method('post')
                            <a class="btn btn-success" href="{{ route('orders.complete', $order->id) }}"
                                type="submit">Complete
                                Order</a>
                        </form>
                    @endif
                </div>
            </article>
        </div>
    </div>
@endsection
