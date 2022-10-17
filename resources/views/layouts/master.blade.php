<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Store</title>
    @include('layouts.css')
</head>
<body>
<!-- HEADER -->
@include('layouts.header')


<!-- /NEWSLETTER -->
@yield('content')
<!-- FOOTER -->

    <!-- bottom footer -->
    @include('layouts.footer')
    <!-- /bottom footer -->

<!-- /FOOTER -->

<!-- jQuery Plugins -->
@include('layouts.js')

</body>
</html>
