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
            <th>Name</th>
            <th>username</th>
            <th>Status</th>
            <th>Created at</th>


        </tr>

        @foreach ($celebrities as $celebritt)
            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $celebritt->first_name . ' ' . $celebritt->last_name }}</td>

                <td>{{ $celebritt->username }}</td>
                <td>
                    @if ($celebritt->status == 1)
                        Active
                    @else
                        Inactive
                    @endif
                </td>
                <td>{{ $celebritt->created_at }}</td>

            </tr>
        @endforeach

    </table>



</body>

</html>
