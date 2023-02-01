<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="{{asset('/')}}theme/images/favicon.ico">

        <!--BOOTSTRAP-CSS-->
        <link href="{{asset('/')}}css/frontend/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}css/frontend/responsive.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}css/frontend/style.css" rel="stylesheet" type="text/css" />

        <!--SOCIAL-ICON-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>        

        <script type="text/javascript">
            var _token = "{{ csrf_token() }}";
            var urlHome = "{{route('home')}}";
            var baseUrl = "{{asset('/')}}";
        </script>
        <style>
            .kbw-signature { width: 100%; height: 200px;}
            #sig canvas{
                width: 100% !important;
                height: auto;
            }
            .daterangepicker {
                z-index: 1100;
            }
            
        </style>

        @yield('css')

    </head>

    <body>        
        <div class="main-wrapper">
            <div class="container">
                <div class="nation-main">            
                    @yield('content')                    
                </div> 
            </div>
        </div>        

        <div class="rightbar-overlay"></div>
        

        @include('partial.fix-modal')

        @yield('modal')
        <script type="text/javascript">
            function showFlash(element, msg, type) {
                $('.error-message').html(msg)
                if (type == 'error') {
                    $('#danger-alert-modal').modal('show');
                } else {
                    $('#success-alert-modal').modal('show');
                }               
            }
            
        </script>

        <!--CUSTOM-JQUERY-->
        <script src="{{asset('/')}}js/frontend/jquery-3.4.1.min.js"></script>

        <!--BOOTSTRAP-JS-->
        <script src="{{asset('/')}}js/frontend/bootstrap.bundle.min.js"></script>

        <!--MAIN-JQUERY-->
        <script src="{{asset('/')}}js/frontend/custom.js"></script>

        <!--Open Layers-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.11/lib/OpenLayers.js"></script>

        <script>
            $(document).ready(function(){
                setTimeout(function(){
                    $('.alert').fadeOut()
                },3000);
            })
        </script>
        @yield('js')
        @yield('pagejs')
        
        <!--SCROLL-TOP  -->
        <a href="#" class="scrolltotop"><i class="fa-solid fa-angle-up"></i></a>
    </body>

    </html>