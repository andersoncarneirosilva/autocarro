<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ProcOnline</title>
    <!-- App favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}">

    <!-- Theme Config Js -->
    <script src="{{ url('assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ url('assets/css/app-saas.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ url('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="{{ url('/') }}">
                                <span><img src="{{ url('assets/images/logo.png') }}" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center m-auto">
                                <img src="{{ url('assets/images/svg/mail_sent.svg') }}" alt="mail sent image" height="64">
                                <h4 class="text-dark-50 text-center mt-4 fw-bold">Por favor, verifique seu e-mail</h4>
                                <p class="text-muted mb-2">
                                    Um e-mail foi enviado para <b>{{ $email }}</b>.
                                </p>
                                <p class="text-muted mb-4">
                                    Por favor, verifique sua caixa de entrada e clique no link recebido para redefinir sua senha. Caso não encontre, verifique a pasta de spam.
                                </p>
                            </div>

                            {{-- <form action="index.html">
                                <div class="mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-home me-1"></i> Back to Home</button>
                                </div>
                            </form> --}}

                        </div> <!-- end card-body-->
                    </div>
                    <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2024 -
        <script>document.write(new Date().getFullYear())</script> © Proconline - proconline.com.br
    </footer>
    <!-- Vendor js -->
    <script src="{{ url('assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ url('assets/js/app.min.js') }}"></script>

</body>

</html>
