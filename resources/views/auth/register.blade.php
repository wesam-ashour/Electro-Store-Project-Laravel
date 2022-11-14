<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ __('auth.Register') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->

    <!-- App css -->
    <link href="{{ asset('assets/loginUser/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/loginUser/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/loginUser/css/app-dark.min.css') }}" rel="stylesheet" type="text/css"
        id="dark-style" />

</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">
                    <!-- title-->
                    <h4 class="mt-0">{{ __('auth.Free') }}</h4>
                    <p class="text-muted mb-4">{{ __('auth.Donts') }}
                    </p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">{{ __('auth.FirstـName') }}</label>
                            <input class="form-control" name="first_name" type="text" id="first_name"
                                placeholder="{{ __('auth.Enterـyourـname') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">{{ __('auth.LastـName') }}</label>
                            <input class="form-control" name="last_name" type="text" id="last_name"
                                placeholder="{{ __('auth.Enterـyourـname') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">{{ __('auth.Emailـaddress') }}</label>
                            <input class="form-control" name="email" type="email" id="emailaddress" required
                                placeholder="{{ __('auth.Enter_your_email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">{{ __('auth.Mobile') }}</label>
                            <input class="form-control" name="mobile" type="text" id="mobile"
                                placeholder="{{ __('auth.Enter_your_mobile') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('auth.Password') }}</label>
                            <input class="form-control" name="password" type="password" required id="password"
                                placeholder="{{ __('auth.Enter_your_password') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('auth.Password_Confirm') }}</label>
                            <input class="form-control" name="password_confirmation" type="password" required
                                id="password" placeholder="{{ __('auth.Enter_your_password') }}">
                        </div>
                        
                        <div class="mb-0 d-grid text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-account-circle"></i> 
                                {{ __('auth.Sign_Up') }}</button>
                        </div>
                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">{{ __('auth.Already') }} <a href="{{ route('login') }}"
                                class="text-muted ms-1"><b>{{ __('auth.Log_In') }}</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">{{ __('auth.Try') }}</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i>{{ __('auth.will') }} <i
                        class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    {{ __('auth.Ecommerce') }}
                </p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- bundle -->
    <script src="{{ asset('assets/loginUser/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/loginUser/js/app.min.js') }}"></script>

</body>

</html>