
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ProcOnline</title>
    <!-- App favicon -->
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
                                <span><img src="{{ url('assets/images/logo.png') }}" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            {{-- <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Free Sign Up</h4>
                                <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
                            </div> --}}

                            <form method="POST" action="{{ route('password.store') }}">
								@csrf
								<input type="hidden" name="token" value="{{ old('token', $request->token) }}">

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>

                                </div>
								

                                <div class="mb-3">
                                    <label for="password" class="form-label">Nova Senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha">
                                        
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

								<div class="mb-3">
                                    <label for="password" class="form-label">Confirme a Senha</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation"  placeholder="Confirme a senha" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
								<x-input-error :messages="$errors->get('email')" class="mt-2" /> 
								<x-input-error :messages="$errors->get('password')" class="mt-2" />
								<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary" type="submit"> Acessar </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

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