
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">
        <!-- Daterangepicker css -->
        <link href="{{ url('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ url('assets/vendor/daterangepicker/daterangepicker.css') }}">

        <!-- Vector Map css -->
        <link rel="stylesheet" href="{{ url('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
        <!-- Theme Config Js -->
        <script src="{{ url('assets/js/hyper-config.js') }}"></script>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        
        <!-- App css -->
        <link href="{{ url('assets/css/app-saas.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0"></script>

        <!-- Icons css -->
        <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>

        <script src="{{ url('js/mask-cep.js') }}"></script>
        <script src="{{ url('js/mask-phone.js') }}"></script>

        
        
        <!-- Select2 css -->
        

        <!--  Select2 Js -->
        
        
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
            .select2-container {
    z-index: 1055 !important; /* Certifique-se de que o z-index é maior que o do modal */
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
        <script src="{{ url('assets/vendor/select2/js/select2.min.js')}}"></script>
        <!-- Bootstrap Wizard Form js -->
        <script src="{{ url('assets/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ url('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
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

        
        <script src="{{ url('assets/vendor/handlebars/handlebars.min.js') }}"></script>
        <script src="{{ url('assets/vendor/typeahead.js/typeahead.bundle.min.js') }}"></script>
        <!-- Script do Select2 -->

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="{{ url('assets/js/calendar.js') }}"></script>
    </body>
</html> 