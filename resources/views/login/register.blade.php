
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
                        <!-- Logo-->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="index.html">
                                <span><img src="assets/images/logo.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">
							<x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Cadastre-se</h4>
                                <p class="text-muted mb-4">Crie sua conta, leva menos de um minuto.</p>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
								@csrf

                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Nome</label>
                                    <input type="text" class="form-control rounded-left" name="name" placeholder="Nome" required>
                                </div>

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input type="text" class="form-control rounded-left" name="email" placeholder="Email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control rounded-left" name="password" placeholder="Senha" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

								<div class="mb-3">
                                    <label for="password" class="form-label">Confirme a Senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control rounded-left" name="password_confirmation" placeholder="Confirme a Senha" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                        <label class="form-check-label" for="checkbox-signup">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                                    </div>
                                </div> --}}
								@if ($errors->has('email'))
									<div class="alert alert-danger">
										{{ $errors->first('email') }}
									</div>
								@endif
								@if ($errors->has('password'))
									<div class="alert alert-danger">
										{{ $errors->first('password') }}
									</div>
								@endif
								@if ($errors->has('password_confirmation'))
									<div class="alert alert-danger">
										{{ $errors->first('password_confirmation') }}
									</div>
								@endif
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit"> Cadastrar </button>
                                </div>


                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Já tem uma conta?<a href="{{ url('login') }}" class="text-muted ms-1"><b>Acesse</b></a></p>
                        </div> <!-- end col-->
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