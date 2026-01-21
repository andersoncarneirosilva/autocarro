
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">
    <script src="{{ url('backend/js/hyper-config.js') }}"></script>

    <link href="{{ url('backend/css/app-saas.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ url('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg">

    <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 800 800'>
            <g fill-opacity='0.22'>
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.1);" cx='400' cy='400' r='600' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.2);" cx='400' cy='400' r='500' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.3);" cx='400' cy='400' r='300' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.4);" cx='400' cy='400' r='200' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.5);" cx='400' cy='400' r='100' />
            </g>
        </svg>
    </div>

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="/">
                                <span><img src="backend/images/logo_texto.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center">
                                <h1 class="text-error">4<i class="mdi mdi-emoticon-sad"></i>4</h1>
                                <h4 class="text-uppercase text-danger mt-3">Página não encontrada</h4>
                                <p class="text-muted mt-3">Parece que você pode ter tomado o caminho errado. Não se preocupe... acontece com os melhores de nós.</p>

                                <a class="btn btn-info mt-3" href="/"><i class="mdi mdi-reply"></i> Voltar</a>
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

    <footer class="footer footer-alt">
    2025 - <span id="current-year"></span> © Alcecar - alcecar.com.br
</footer>

<script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
</script>
    <!-- Vendor js -->
    <script src="{{ url('backend/js/vendor.min.js') }}"></script> 
    <script src="{{ url('backend/js/app.min.js') }}"></script>

</body>

</html>