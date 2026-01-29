<!doctype html>
<html lang="pt-br">
<head>
    <title>Alcecar | Redefinir Senha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('sitelogin/css/style.css') }}">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .wrap { border-radius: 12px; overflow: hidden; box-shadow: 0px 20px 40px -15px rgba(0,0,0,0.15); border: none; }
        .text-wrap { background: linear-gradient(135deg, #727cf5 0%, #712FC9 100%) !important; display: flex; align-items: center; }
        .sitename img { max-width: 120px; margin-bottom: 20px; }
        .form-control { height: 50px; background: #fff; color: #495057; font-size: 15px; border-radius: 8px; border: 1px solid #dee2e6; padding-left: 20px; transition: all 0.3s ease; }
        .form-control:focus { border-color: #727cf5; box-shadow: 0 0 0 0.2rem rgba(115, 0, 0, 0.1); }
        .label { font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: #6c757d; margin-bottom: 8px; }
        .btn-primary { background: #727cf5 !important; border:none; height: 50px; border-radius: 8px; font-weight: 600; letter-spacing: 0.5px; transition: 0.3s; }
        .btn-primary:hover { transform: translateY(-1px); background: #4a52ac !important; }
        .error-message { color: #d9534f; font-size: 13px; margin-top: 6px; font-weight: 500; display: block; }
        .ftco-section { padding: 5em 0; }
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
                                <img src="{{ url('frontend/images/logo_alcecar.png') }}" alt="Alcecar Logo">
                            </div>
                            <h2 style="color: white; font-weight: 700;">Segurança em Primeiro Lugar</h2>
                            <p style="color: rgba(255,255,255,0.8);">Escolha uma senha forte para garantir que sua conta no Alcecar esteja sempre protegida.</p>
                        </div>
                    </div>

                    <div class="login-wrap p-4 p-lg-5">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h3 style="font-weight: 700; color: #333; margin: 0;">Nova Senha</h3>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}" class="signin-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="form-group mb-3">
                                <label class="label" for="email">E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $request->email) }}" required readonly>
                                @error('email')
                                    <span class="error-message"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="label" for="password">Crie sua Nova Senha</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" id="password" placeholder="••••••••" required autofocus>
                                @error('password')
                                    <span class="error-message"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="label" for="password_confirmation">Confirme a Nova Senha</label>
                                <input type="password" class="form-control" 
                                       name="password_confirmation" id="password_confirmation" placeholder="••••••••" required>
                                @error('password_confirmation')
                                    <span class="error-message"><i class="fa fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">
                                    Atualizar e Acessar Sistema
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ url('sitelogin/js/jquery.min.js') }}"></script>
<script src="{{ url('sitelogin/js/bootstrap.min.js') }}"></script>

</body>
</html>