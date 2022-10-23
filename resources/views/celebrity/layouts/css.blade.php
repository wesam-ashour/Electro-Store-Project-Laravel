<!-- Favicon -->
<link rel="icon" href="{{asset('assets/img/brand/favicon.png')}}" type="image/x-icon"/>

@if (App::getLocale() == 'en')
    <!-- Icons css -->
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{asset('assets/css/sidemenu.css')}}">
    <!-- style css -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style-dark.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{asset('assets/css/skin-modes.css')}}" rel="stylesheet"/>
@else
    <!-- Icons css -->
    <link href="{{asset('assets/css-rtl/icons.css')}}" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{asset('assets/css-rtl/sidemenu.css')}}">
    <!-- style css -->
    <link href="{{asset('assets/css-rtl/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css-rtl/style-dark.css')}}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{asset('assets/css-rtl/skin-modes.css')}}" rel="stylesheet"/>
@endif

<!--  Owl-carousel css-->
<link href="{{asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet"/>

<!--  Custom Scroll bar-->
<link href="{{asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>

<!--  Right-sidemenu css -->
<link href="{{asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

<!-- Maps css -->
<link href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
