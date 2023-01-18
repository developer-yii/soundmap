<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('/')}}theme/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('/')}}theme/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}theme/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />

</head>

<body class="pb-0">
    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <a href="#" class="logo-dark">
                            <span><img src="#" alt="" height="30"></span>
                        </a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->
    </div>
    <!-- end auth-fluid-->

    <script src="{{asset('/')}}theme/js/vendor.min.js"></script>
    <script src="{{asset('/')}}theme/js/app.min.js"></script>
</body>

</html>