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
            <th>user name</th>
            <th>order id</th>
            <th>order amount</th>
            <th>payment method</th>
            <th>status</th>
            <th>Created at</th>


        </tr>

        @foreach ($transactions as $transaction)
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ \App\Models\User::find($transaction->user_id)->first_name . ' ' . \App\Models\User::find($transaction->user_id)->last_name }}
                </td>

                <td>{{ \App\Models\Order::find($transaction->order_id)->order_number }}</td>
                <td>{{ \App\Models\Order::find($transaction->order_id)->item_count }}</td>
                <td>{{ $transaction->payment_method }}</td>

                <td>
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
                <td>{{ $transaction->created_at }}</td>

            </tr>
        @endforeach

    </table>



</body>

</html>
