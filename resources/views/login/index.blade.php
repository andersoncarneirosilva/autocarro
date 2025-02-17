
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
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="{{ url('/') }}">
                                <span><img src="{{ url('assets/images/logo.png') }}" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Acesso</h4>
                                <p class="text-muted mb-4">Digite seu endereço de e-mail e senha para acessar o painel de administração.</p>
                            </div>

                            <x-auth-session-status class="mb-4" :status="session('status')" />
							<form method="POST" action="{{ route('login') }}">
								@csrf

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email" placeholder="Digite seu email" required>
                                </div>

                                <div class="mb-3">
                                    <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Esqueceu a senha?</small></a>
                                    <label for="password" class="form-label">Senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" placeholder="Digite sua senha" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-3">
									<x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    <div class="form-check">
										
                                        {{-- <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label> --}}
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-sm" type="submit"> Acessar </button>
                                </div>
								
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Não tem uma conta? <a href="{{ route('register') }}" class="text-muted ms-1"><b>Cadastre-se</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

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
