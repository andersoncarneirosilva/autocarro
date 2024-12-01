
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Proc Online</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Theme Config Js -->
        <script src="assets/js/hyper-config.js"></script>

        <!-- App css -->
        <link href="assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
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

                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- ========== Left Sidebar End ========== -->
            

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class="uil uil-file-alt float-end"></i>
                                        <h2 class="my-2" id="active-users-count">{{ $countDocs }}</h2>
                                        <p class="mb-0 text-muted">
                                            <span class="text-nowrap">Documentos</span>
                                        </p>
                                    </div> <!-- end card-body-->
                                </div>
                            </div> <!-- end col -->
    
                            <div class="col-md-6 col-xl-3">
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class="uil uil-file float-end"></i>
                                        <h2 class="my-2" id="active-users-count">{{ $countProcs }}</h2>
                                        <p class="mb-0 text-muted">
                                            <span class="text-nowrap">Procurações</span>
                                        </p>
                                    </div> <!-- end card-body-->
                                </div>
                            </div> <!-- end col -->
    
                            <div class="col-md-6 col-xl-3">
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class="uil uil-postcard float-end"></i>
                                        <h2 class="my-2" id="active-users-count">{{ $countProcs }}</h2>
                                        <p class="mb-0 text-muted">
                                            <span class="text-nowrap">CNH</span>
                                        </p>
                                    </div> <!-- end card-body-->
                                </div>
                            </div> <!-- end col -->
    
                            <div class="col-md-6 col-xl-3">
                                <div class="card tilebox-one">
                                    <div class="card-body">
                                        <i class="uil uil-users-alt float-end"></i>
                                        <h2 class="my-2" id="active-users-count">{{ $countProcs }}</h2>
                                        <p class="mb-0 text-muted">
                                            <span class="text-nowrap">Clientes</span>
                                        </p>
                                    </div> <!-- end card-body-->
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        {{-- <div class="row">
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="header-title">Campaigns</h4>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Today</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Yesterday</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Last Week</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">Last Month</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div id="dash-campaigns-chart" class="apex-charts" data-colors="#ffbc00,#727cf5,#0acf97"></div>

                                        <div class="row text-center mt-3">
                                            <div class="col-sm-4">
                                                <i class="mdi mdi-send widget-icon rounded-circle bg-warning-lighten text-warning"></i>
                                                <h3 class="fw-normal mt-3">
                                                    <span>6,510</span>
                                                </h3>
                                                <p class="text-muted mb-0 mb-2"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Total Sent</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <i class="mdi mdi-flag-variant widget-icon rounded-circle bg-primary-lighten text-primary"></i>
                                                <h3 class="fw-normal mt-3">
                                                    <span>3,487</span>
                                                </h3>
                                                <p class="text-muted mb-0 mb-2"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> Reached</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <i class="mdi mdi-email-open widget-icon rounded-circle bg-success-lighten text-success"></i>
                                                <h3 class="fw-normal mt-3">
                                                    <span>1,568</span>
                                                </h3>
                                                <p class="text-muted mb-0 mb-2"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Opened</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body-->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col-->
    
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="header-title">Últimos emprestimos</h4>
                                    </div>
                                    @if ($emprestimos)
                                    <div class="card-body pt-2">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-hover mb-0">
                                                <tbody>
                                                    @foreach ($emprestimos as $emp)
                                                    <tr>
                                                        <td>
                                                            <h5 class="font-14 my-1"><a href="#" class="text-body">{{ $emp->colaborador }}</a></h5>
                                                            <span class="text-muted font-13">{{ $emp->motivo }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Status</span> <br>
                                                            <span class="{{ $emp->class_status }}">{{ $emp->status }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Parcela</span>
                                                            <h5 class="font-14 mt-1 fw-normal">R${{ $emp->parcela }}</h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Total</span>
                                                            <h5 class="font-14 mt-1 fw-normal">R${{ $emp->total }}</h5>
                                                        </td>
                                                        <td class="table-action" style="width: 90px;">
                                                            <a href="{{ route('parcelas.show', $emp->id) }}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card body-->
                                    
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            NENHUM RESULTADO ENCONTRADO!
                                        </div>
                                    @endif
                                </div> <!-- end card -->
                                <!-- end card -->
                            </div>
                            <!-- end col-->
                        </div>
                        <!-- end row--> --}}


                        
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                @include('components.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        

        <!-- Vendor js -->
        <script src="{{ url('assets/js/vendor.min.js') }}"></script>
        <!-- Apex  Charts js -->
        <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
        <!-- Todo js -->
        <script src="{{ url('assets/js/ui/component.todo.js') }}"></script>
        <!-- CRM Dashboard Demo App Js -->
        <script src="{{ url('assets/js/pages/demo.crm-dashboard.js') }}"></script>
        <!-- App js -->
        <script src="{{ url('assets/js/app.min.js') }}"></script>
    </body>
</html>
