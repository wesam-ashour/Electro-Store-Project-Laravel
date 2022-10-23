<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
          content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,
          admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,
          bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,
          bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,
          dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,
          envato templates,flat ui,html,html and css templates,html dashboard template,html5,
          jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

    <!-- Title -->
    <title> Store - Celebrity </title>

    @include('celebrity.layouts.css')

</head>

<body class="main-body app sidebar-mini dark-theme">

<!-- Loader -->
<div id="global-loader">
    <img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<!-- Page -->
<div class="page">

    <!-- main-sidebar -->
    @include('celebrity.layouts.sidebar')
    <!-- /main-sidebar -->

    <!-- main-content -->
    <div class="main-content app-content">

        <!-- main-header -->
        @include('celebrity.layouts.header')
        <!-- /main-header -->

        <!-- container -->
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /Container -->

    </div>
    <!-- /main-content -->

    <!-- Footer opened -->
    @include('celebrity.layouts.footer')
    <!-- Footer closed -->

</div>
<!-- End Page -->

@include('celebrity.layouts.js')
</body>
</html>
