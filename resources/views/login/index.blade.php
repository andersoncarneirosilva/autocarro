<!doctype html>
<html lang="pt-br">
<head>
    <title>Autocar - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="{{ url('layoutlogin/css/style.css') }}">

    <style>
        .sitename {
            font-weight: 700;
            font-size: 30px;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #730000; /* Cor vinho do layout antigo */
        }
        .btn-primary {
            background: #730000 !important;
            border-color: #730000 !important;
        }
        .text-wrap {
            background: #730000 !important;
        }
        .error-message {
            color: #ff0000;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                        <div class="text w-100">
                            <h1 class="sitename" style="color: #fff;">Autocar</h1>
                            <p>Ainda não tem uma conta no painel administrativo?</p>
                            <a href="{{ route('register') }}" class="btn btn-white btn-outline-white">Cadastre-se</a>
                        </div>
                    </div>

                    <div class="login-wrap p-4 p-lg-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Acessar</h3>
                            </div>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="signin-form">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label class="label" for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Digite seu email" value="{{ old('email') }}" required autofocus>
                                @if($errors->has('email'))
                                    <span class="error-message">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label class="label" for="password">Senha</label>
                                <input type="password" class="form-control" name="password" placeholder="Digite sua senha" required>
                                @if($errors->has('password'))
                                    <span class="error-message">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Acessar</button>
                            </div>

                            <div class="form-group d-md-flex">
                                <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary mb-0">Lembrar-me
                                        <input type="checkbox" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ url('layoutlogin/js/jquery.min.js') }}"></script>
<script src="{{ url('layoutlogin/js/popper.js') }}"></script>
<script src="{{ url('layoutlogin/js/bootstrap.min.js') }}"></script>
<script src="{{ url('layoutlogin/js/main.js') }}"></script>

</body>
</html>