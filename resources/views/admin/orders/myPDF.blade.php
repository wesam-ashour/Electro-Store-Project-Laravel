<!DOCTYPE html>

<html>

<head>

    <title>PDF</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>



    <p>Data Table</p>



    <table class="table table-bordered">

        <tr>

            <th>#</th>
            <th class="wd-lg-20p"><span>order number</span></th>
            <th class="wd-lg-20p"><span>created at</span></th>
            <th class="wd-lg-20p"><span>total</span></th>
            <th class="wd-lg-20p"><span>payment method</span></th>
            <th class="wd-lg-20p"><span>payment status</span></th>
            <th class="wd-lg-20p"><span>status</span></th>


        </tr>

        @foreach ($orders as $order)
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $order->order_number }}
                </td>

                <td>{{ $order->created_at }}</td>
                <td>{{ $order->grand_total }}</td>
                <td>{{ $order->payment_method }}</td>

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


            </tr>
        @endforeach

    </table>



</body>

</html>
