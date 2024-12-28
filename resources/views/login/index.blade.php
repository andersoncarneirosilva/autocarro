
<!doctype html>
<html lang="pt-BR">
  <head>
  	<title>ProcOnline</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="{{ url('assets/style.css') }}" rel="stylesheet" type="text/css" id="app-style" />
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
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
		      		<div class="form-group">
		      			<input type="text" class="form-control rounded-left" name="email" placeholder="Email" required>
		      		</div>
	            <div class="form-group d-flex">
	              <input type="password" class="form-control rounded-left" name="password" placeholder="Senha" required>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
	            		<label class="checkbox-wrap checkbox-primary">Lembrar-me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#">Esqueceu a senha</a>
								</div>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Acessar</button>
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

