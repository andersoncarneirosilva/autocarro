<!doctype html>
<html lang="pt-br">
<head>
    <title>Autocar - Acesso ao Sistema</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('login/css/style.css') }}">

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-02FMMXT79W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-02FMMXT79W');
</script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .wrap {
            border-radius: 12px;
            overflow: hidden;
            -webkit-box-shadow: 0px 20px 40px -15px rgba(0,0,0,0.15);
            -moz-box-shadow: 0px 20px 40px -15px rgba(0,0,0,0.15);
            box-shadow: 0px 20px 40px -15px rgba(0,0,0,0.15);
            border: none;
        }

        /* Branding e Cores */
        .text-wrap {
            background: linear-gradient(135deg, #ff4a17 0%, #790000 100%) !important;
            display: flex;
            align-items: center;
        }

        .sitename img {
            max-width: 120px;
            margin-bottom: 20px;
        }

        /* Inputs e Formulário */
        .form-control {
            height: 50px;
            background: #fff;
            color: #495057;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding-left: 20px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff4a17;
            box-shadow: 0 0 0 0.2rem rgba(115, 0, 0, 0.1);
        }

        .label {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: #ff4a17 !important;
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #ff4a17 !important;
            transform: translateY(-1px);
        }

        .error-message {
            color: #9e222e;
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }

        a {
            color: #ff4a17;
            font-weight: 500;
            transition: 0.3s;
        }

        a:hover {
            color: #4d0000;
            text-decoration: none;
        }

        .btn-outline-white {
            border: 2px solid rgba(255,255,255,0.8);
            border-radius: 8px;
            padding: 10px 30px;
        }

        /* Ajuste de espaçamento vertical */
        .ftco-section {
            padding: 5em 0;
        }
    </style>
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="text-wrap p-4 p-lg-5 text-center order-md-last">
                        <div class="text w-100">
                            <div class="sitename">
                                <img src="{{ url('frontend/images/logo_alcecar.png') }}" alt="Autocar Logo">
                            </div>
                            <h2 style="color: white; font-weight: 700;">Bem-vindo!</h2>
                            <p style="color: rgba(255,255,255,0.8);">Ainda não possui acesso à nossa plataforma de gestão?</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-white text-white mt-3">Criar Conta</a>
                        </div>
                    </div>

                    <div class="login-wrap p-4 p-lg-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4" style="font-weight: 700; color: #333;">Acessar</h3>
                            </div>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="signin-form">
                            @csrf
                            
                            <div class="form-group mb-4">
                                <label class="label" for="email">E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" placeholder="nome@exemplo.com" 
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="error-message"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="label" for="password">Senha de Acesso</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" placeholder="••••••••" required>
                                @error('password')
                                    <span class="error-message"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Entrar no Sistema</button>
                            </div>

                            <div class="form-group d-flex justify-content-end mt-4">
                                <div class="text-md-right">
                                    <a href="{{ route('password.request') }}" style="font-size: 14px;">Esqueceu sua senha?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ url('login/js/jquery.min.js') }}"></script>
<script src="{{ url('login/js/bootstrap.min.js') }}"></script>

</body>
</html>