<!doctype html>
<html lang="pt-br">
<head>
    <title>Autocar - Cadastro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('layoutlogin/css/style.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .wrap {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 20px 40px -15px rgba(0,0,0,0.15);
            border: none;
            background: #fff;
        }

        .text-wrap {
            background: linear-gradient(135deg, #730000 0%, #4d0000 100%) !important;
            display: flex;
            align-items: center;
            color: #fff;
        }

        .sitename img {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .form-control {
            height: 45px;
            background: #fff;
            color: #495057;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding-left: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #730000;
            box-shadow: 0 0 0 0.2rem rgba(115, 0, 0, 0.1);
        }

        .label {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .btn-primary {
            background: #730000 !important;
            border-color: #730000 !important;
            height: 45px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 10px;
        }

        .btn-outline-white {
            border: 2px solid rgba(255,255,255,0.8);
            border-radius: 8px;
            padding: 8px 25px;
            color: #fff;
            font-weight: 600;
        }

        .btn-outline-white:hover {
            border: 2px solid rgba(255,255,255,0.8);
            border-radius: 8px;
            padding: 8px 25px;
            color: #fff;
            font-weight: 600;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            font-weight: 500;
            display: block;
            margin-top: 4px;
        }

        .ftco-section {
            padding: 3em 0;
        }
    </style>
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-11">
                <div class="wrap d-md-flex">
                    <div class="text-wrap p-4 p-lg-5 text-center order-md-first">
                        <div class="text w-100">
                            <div class="sitename">
                                <img src="{{ url('layout/images/logo_carro.png') }}" alt="Autocar Logo">
                            </div>
                            <h2 style="color: white; font-weight: 700;">Já tem conta?</h2>
                            <p style="color: rgba(255,255,255,0.8);">Se você já é cadastrado, basta acessar sua conta agora mesmo.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-white mt-3">Fazer Login</a>
                        </div>
                    </div>

                    <div class="login-wrap p-4 p-lg-5" style="flex: 1;">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4" style="font-weight: 700; color: #333;">Criar Conta</h3>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="signin-form">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="label">Nome Completo</label>
                                    <input type="text" class="form-control" name="name" placeholder="Ex: João Silva" value="{{ old('name') }}" required>
                                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="label">WhatsApp / Celular</label>
                                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="(00) 00000-0000" value="{{ old('whatsapp') }}" required>
                                    @error('whatsapp') <span class="error-message">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="label">E-mail Profissional</label>
                                <input type="email" class="form-control" name="email" placeholder="email@exemplo.com" value="{{ old('email') }}" required>
                                @error('email') <span class="error-message">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="label">Senha</label>
                                    <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                                    @error('password') <span class="error-message">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label class="label">Confirmar Senha</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="form-control btn btn-primary px-3">Finalizar Cadastro</button>
                            </div>

                            <p class="text-center mt-3" style="font-size: 12px; color: #999;">
                                Ao se cadastrar, você concorda com nossos Termos de Uso.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ url('layoutlogin/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#whatsapp').mask('(00) 00000-0000');
    });
</script>

</body>
</html>