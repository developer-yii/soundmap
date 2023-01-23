<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App css -->
    <link href="{{asset('/')}}theme/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}theme/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />

</head>

<body class="pb-0">
    <div class="">
        
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">
                   
                    
                    
                    @yield('content')
                </div> 
            </div> 
        </div>
        
    </div>
    <script src="{{asset('/')}}theme/js/vendor.min.js"></script>
    <script src="{{asset('/')}}theme/js/app.min.js"></script>
    {{-- <script src="{{asset('/')}}theme/js/OpenLayers.js"></script> --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.11/lib/OpenLayers.js"></script> 
   @yield('modal')
   @yield('js')
   @yield('pagejs')
</body>

</html>