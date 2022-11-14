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

            <th>ID</th>
            <th>Product Title</th>
            <th>Quantity</th>
            <th>Created at</th>

        </tr>

        @foreach ($orders as $order)
            <tr>

                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ \App\Models\Product::find($order->product_id)->title }}
                </td>
                <td>
                    {{ $order->quantity }}
                </td>
                <td>
                    {{ $order->created_at }}
                </td>

            </tr>
        @endforeach

    </table>



</body>

</html>
