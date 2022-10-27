<!DOCTYPE html>

<html>

<head>

    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

    tempor incididunt ut labore et dolore magna aliqua.</p>

  

    <table class="table table-bordered">

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Created at</th>


        </tr>

        @foreach($users as $user)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $user->first_name . ' ' . $user->last_name}}</td>

            <td>{{ $user->email }}</td>
            <td>
                @if ($user->status == 1)
                    Active
                @else
                    Inactive
                @endif
            </td>
            <td>{{ $user->created_at }}</td>

        </tr>

        @endforeach

    </table>

  

</body>

</html>