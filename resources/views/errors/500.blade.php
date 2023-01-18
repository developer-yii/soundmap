<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Error 500</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('/')}}theme/images/favicon.ico">

        <!-- App css -->
        <link href="{{asset('/')}}theme/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}theme/css/app-creative.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="{{asset('/')}}theme/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body class="authentication-bg" data-layout-config='{"darkMode":false}'>

        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <a href="{{route('home')}}">
                                    <span><img src="{{asset('/')}}theme/images/logo.png" alt="" height="18"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                <div class="text-center">
                                    <img src="{{asset('/')}}theme/images/startman.svg" height="120" alt="File not found Image">

                                    <h1 class="text-error mt-4">500</h1>
                                    <h4 class="text-uppercase text-danger mt-3">Internal Server Error</h4>
                                    <p class="text-muted mt-3">Why not try refreshing your page? or you can contact <a href="" class="text-muted"><b>Support</b></a></p>

                                    <a class="btn btn-info mt-3" href="{{route('home')}}"><i class="mdi mdi-reply"></i> Return Home</a>
                                </div>
                            </div> <!-- end card-body-->
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        
        <!-- bundle -->
        <script src="{{asset('/')}}theme/js/vendor.min.js"></script>
        <script src="{{asset('/')}}theme/js/app.min.js"></script>
        
    </body>
</html>
