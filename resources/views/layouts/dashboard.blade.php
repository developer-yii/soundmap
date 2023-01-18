<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="{{asset('/')}}theme/images/favicon.ico">

        <!-- <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css"> -->

        <!-- Datatables css -->
        <link href="{{asset('/')}}theme/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}theme/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{asset('/')}}theme/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('/')}}theme/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />

        <link href="{{asset('/')}}css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />

        <link href="{{asset('/')}}css/select2.min.css" rel="stylesheet" type="text/css" />

        <link href="{{asset('/')}}css/custom.css?{{cacheclear()}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('/')}}theme/css/quill.snow.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
        <!-- Begin page -->
        <div class="wrapper">
            @include('partial.sidemenu')

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    @include('partial.header')
                    <!-- Start Content-->
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> ©sound map
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- Right Sidebar -->
        <div class="end-bar">

            <div class="rightbar-title">
                <a href="javascript:void(0);" class="end-bar-toggle float-end">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <div class="rightbar-content h-100" data-simplebar>

                <div class="p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                    </div>

                    <!-- Settings -->
                    <h5 class="mt-3">Color Scheme</h5>
                    <hr class="mt-1" />

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light" id="light-mode-check" checked>
                        <label class="form-check-label" for="light-mode-check">Light Mode</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark" id="dark-mode-check">
                        <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                    </div>


                    <!-- Width -->
                    <h5 class="mt-4">Width</h5>
                    <hr class="mt-1" />
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check" checked>
                        <label class="form-check-label" for="fluid-check">Fluid</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                        <label class="form-check-label" for="boxed-check">Boxed</label>
                    </div>


                    <!-- Left Sidebar-->
                    <h5 class="mt-4">Left Sidebar</h5>
                    <hr class="mt-1" />
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="theme" value="default" id="default-check">
                        <label class="form-check-label" for="default-check">Default</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="theme" value="light" id="light-check" checked>
                        <label class="form-check-label" for="light-check">Light</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="theme" value="dark" id="dark-check">
                        <label class="form-check-label" for="dark-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="fixed" id="fixed-check" checked>
                        <label class="form-check-label" for="fixed-check">Fixed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="condensed" id="condensed-check">
                        <label class="form-check-label" for="condensed-check">Condensed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" name="compact" value="scrollable" id="scrollable-check">
                        <label class="form-check-label" for="scrollable-check">Scrollable</label>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" id="resetBtn">Reset to Default</button>

                        <!-- <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/" class="btn btn-danger mt-3" target="_blank"><i class="mdi mdi-basket me-1"></i> Purchase Now</a> -->
                    </div>
                </div> <!-- end padding-->

            </div>
        </div>

        <div class="rightbar-overlay"></div>
        <!-- /End-bar -->

        @include('partial.fix-modal')

        @yield('modal')
        
        <script src="{{asset('/')}}theme/js/vendor.min.js"></script>
        <script src="{{asset('/')}}theme/js/app.min.js"></script>

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
        <script src="{{asset('/')}}js/vendor.js"></script>
        <script src="{{asset('/')}}js/form-builder.min.js"></script>
        <script src="{{asset('/')}}js/form-render.min.js"></script>
        <script src="{{asset('/')}}js/typeahead.bundle.min.js"></script>
        <script src="{{asset('/')}}js/bootstrap-tagsinput.min.js"></script>

        <!-- Datatables js -->
        <script src="{{asset('/')}}theme/js/vendor/jquery.dataTables.min.js"></script>
        <script src="{{asset('/')}}theme/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="{{asset('/')}}theme/js/vendor/dataTables.responsive.min.js"></script>
        <script src="{{asset('/')}}theme/js/vendor/responsive.bootstrap5.min.js"></script>

        <script src="{{asset('/')}}js/select2.min.js"></script>
        <script src="{{asset('/')}}js/custom.js?{{cacheclear()}}"></script>
        <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor.js') }}"></script>

        <script>
            $(document).ready(function(){
                setTimeout(function(){
                    $('.alert').fadeOut()
                },3000);
            })
        </script>
        @yield('js')
        @yield('pagejs')
    </body>

    </html>