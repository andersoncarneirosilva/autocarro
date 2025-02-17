
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ProcOnline</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

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
                            <a href="index.html">
                                <span><img src="assets/images/logo.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Redefinir senha</h4>
                                <p class="text-muted mb-4">Informe seu email que enviaremos um link para redefinir sua senha.</p>
                            </div>

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email" placeholder="Informe seu email">
                                </div>
                                <x-input-error class="alert alert-danger border border-danger text-danger bg-transparent" :messages="$errors->get('email')"/>
                                    <x-auth-session-status class="alert alert-success border border-success text-success bg-transparent" :status="session('status')" />
                                <div class="mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">Redefinir senha</button>
                                </div>
                            </form>
                        </div> <!-- end card-body-->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Voltar para o<a href="pages-login.html" class="text-muted ms-1"><b>login</b></a></p>
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
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
{{-- 
<!doctype html>
<html lang="pt-BR">
  <head>
  	<title>ProcOnline</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="{{ url('assets/style.css') }}" rel="stylesheet" type="text/css" id="app-style" />
	<link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">
<style>
    
</style>
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class="py-5 d-flex align-items-center justify-content-center">
                    <img src="{{ url('assets/images/logo-dark.png') }}" alt="">
		      	</div>
                  <form method="POST" action="{{ route('password.email') }}">
                    @csrf
		      		<div class="form-group">
						Informe seu email que enviaremos um link para redefinir sua senha.
		      		</div>
	            <div class="form-group d-flex">
	              <input type="email" class="form-control rounded-left" name="email" placeholder="Email" required autofocus>
	            </div>
                <x-input-error class="alert alert-danger border border-danger text-danger bg-transparent" :messages="$errors->get('email')"/>
				<x-auth-session-status class="alert alert-success border border-success text-success bg-transparent" :status="session('status')" />
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Enviar</button>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>

    <script src="{{ url('assets/jquery.min.js') }}"></script>
    <script src="{{ url('assets/popper.js') }}"></script>
    <script src="{{ url('assets/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/main.js') }}"></script>

</body>
</html> --}}

