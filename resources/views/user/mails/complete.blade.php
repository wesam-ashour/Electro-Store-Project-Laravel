<!DOCTYPE html>

<html>

<head>

    <title>Store.com</title>

</head>

<body>

    <h1>{{ $mailData['title'] }}</h1>

    <p>{{ $mailData['body'] }}</p>

    <p>Your order {{ $mailData['order_number'] }} has been completed</p>

    <p>Thank you</p>

</body>

</html>