<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/loginUser/images/favicon.ico') }}">

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

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <a href="index.html" class="logo-dark">
                            <span><img src="{{ asset('assets/loginUser/images/logo-dark.png') }}" alt=""
                                    height="18"></span>
                        </a>
                        <a href="index.html" class="logo-light">
                            <span><img src="{{ asset('assets/loginUser/images/logo.png') }}" alt=""
                                    height="25"></span>
                        </a>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access account.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" name="email" id="emailaddress" required=""
                                placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Forgot your
                                    password?</small></a>
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" required="" id="password"
                                placeholder="Enter your password">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In</button>
                        </div>
                        <!-- social-->
                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">Don't have an account? <a href="{{ asset('register') }}"
                                class="text-muted ms-1"><b>Sign Up</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Try our service online!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> Will your payment very easily with us. <i
                        class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Ecommerce store
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

{{-- <x-guest-layout> --}}
{{--    <x-auth-card> --}}
{{--        <x-slot name="logo"> --}}
{{--            <a href="/"> --}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
{{--            </a> --}}
{{--        </x-slot> --}}

{{--        <!-- Session Status --> --}}
{{--        <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

{{--        <!-- Validation Errors --> --}}
{{--        <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

{{--        <form method="POST" action="{{ route('login') }}"> --}}
{{--            @csrf --}}

{{--            <!-- Email Address --> --}}
{{--            <div> --}}
{{--                <x-input-label for="email" :value="__('Email')" /> --}}

{{--                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus /> --}}
{{--            </div> --}}

{{--            <!-- Password --> --}}
{{--            <div class="mt-4"> --}}
{{--                <x-input-label for="password" :value="__('Password')" /> --}}

{{--                <x-text-input id="password" class="block mt-1 w-full" --}}
{{--                                type="password" --}}
{{--                                name="password" --}}
{{--                                required autocomplete="current-password" /> --}}
{{--            </div> --}}

{{--            <!-- Remember Me --> --}}
{{--            <div class="block mt-4"> --}}
{{--                <label for="remember_me" class="inline-flex items-center"> --}}
{{--                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember"> --}}
{{--                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span> --}}
{{--                </label> --}}
{{--            </div> --}}

{{--            <div class="flex items-center justify-end mt-4"> --}}
{{--                @if (Route::has('password.request')) --}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}"> --}}
{{--                        {{ __('Forgot your password?') }} --}}
{{--                    </a> --}}
{{--                @endif --}}

{{--                <x-primary-button class="ml-3"> --}}
{{--                    {{ __('Log in') }} --}}
{{--                </x-primary-button> --}}
{{--            </div> --}}
{{--        </form> --}}
{{--    </x-auth-card> --}}
{{-- </x-guest-layout> --}}
