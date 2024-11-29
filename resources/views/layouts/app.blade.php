
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url('images/favicon.png') }}">
        <!-- Daterangepicker css -->
        <link rel="stylesheet" href="{{ url('assets/vendor/daterangepicker/daterangepicker.css') }}">
        <!-- Vector Map css -->
        <link rel="stylesheet" href="{{ url('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
        <!-- Theme Config Js -->
        <script src="{{ url('assets/js/hyper-config.js') }}"></script>
        <!-- App css -->
        <link href="{{ url('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <!-- Icons css -->
        <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Script -->
        <script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="{{ url('js/mask-cep.js') }}"></script>
        <script src="{{ url('js/mask-phone.js') }}"></script>
        
        <!-- Select2 css -->
        <link href="{{ url('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

        <!--  Select2 Js -->
        <script src="{{ url('assets/vendor/select2/js/select2.min.js')}}"></script>
        
        <style>
            
            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }
        
            .filter-select {
                background-color: transparent;
                border: none;
                padding: 0 1em 0 0;
                margin: 0;
                font-family: inherit;
                font-size: inherit;
                cursor: inherit;
                width: auto;
                line-height: inherit;
                outline: none;
                color: var(--ct-body-color);
            }
        
            .filter-btn {
                padding: 0.25em 0.5em;
                font-size: inherit;
                cursor: pointer;
                border-radius: 4px;
                color: var(--ct-body-color);
                border: none;
                color: #333;
            }
        
            .card {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                border: none;
            }
        
            .card-body {
                padding: 0.5rem;
            }
        
            .filter-select-container {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
    
        </style>

    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            @include('components.navbar')
            <!-- ========== Topbar End ========== -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('components.sidebar')
            <!-- ========== Left Sidebar End ========== -->

            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    @include('sweetalert::alert')
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Start -->
                @include('components.footer')
                <!-- end Footer -->

            </div>
        </div> 

        <!-- Chart js --> 
        <script src="{{ url('assets/vendor/chart.js/chart.min.js') }}"></script>
        <!-- Vendor js -->
        <script src="{{ url('assets/js/vendor.min.js') }}"></script>   
        <!-- Bootstrap Wizard Form js -->
        <script src="{{ url('assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
        <!-- Wizard Form Demo js -->
        <script src="{{ url('assets/js/pages/demo.form-wizard.js') }}"></script>
        <!-- Input Mask js -->
<script src="{{ url('assets/vendor/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
        <!-- plugin js -->
        <script src="{{ url('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>
        <!-- init js -->
        <script src="{{ url('assets/js/ui/component.fileupload.js') }}"></script>
        <!-- App js -->
        <script src="{{ url('assets/js/app.min.js') }}"></script>
        
    </body>
</html> 