<!DOCTYPE html>

<html>

<head>

    <title>Store.com</title>

</head>

<body>

    <h1>{{ $mailData['title'] }}</h1>

    <p>{{ $mailData['body'] }}</p>

    <p>Your order {{ $mailData['order_number'] }} has been placed</p>
    <p>Dear customer
        We hope you will follow up on your email to get the latest updates on your order
    </p>
    <p>Thank you</p>

</body>

</html>