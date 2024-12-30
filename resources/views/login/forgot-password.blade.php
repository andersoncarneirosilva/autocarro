
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
		      	{{-- <h3 class="text-center mb-4">Have an account?</h3> --}}
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
</html>

