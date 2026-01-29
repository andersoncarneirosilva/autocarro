<!doctype html>
<html lang="pt-br">
<head>
    <title>Alcecar | Confirmar E-mail</title>
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
        .label { font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: #6c757d; margin-bottom: 8px; }
        .btn-primary { background: #727cf5 !important; border:none; height: 50px; border-radius: 8px; font-weight: 600; letter-spacing: 0.5px; transition: 0.3s; display: flex; align-items: center; justify-content: center; width: 100%; }
        .btn-primary:hover { transform: translateY(-1px); background: #4a52ac !important; color: #fff; }
        .btn-link { color: #727cf5; font-weight: 600; font-size: 13px; text-decoration: none; transition: 0.3s; }
        .btn-link:hover { color: #4a52ac; text-decoration: underline; }
        .ftco-section { padding: 5em 0; }
        .status-message { background: #e3f2fd; color: #0d47a1; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #bbdefb; }
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
                            <h2 style="color: white; font-weight: 700;">Quase lá!</h2>
                            <p style="color: rgba(255,255,255,0.8);">Verifique sua identidade para garantir a segurança da sua conta no Alcecar.</p>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-white mt-3" style="background: transparent;">Sair da Conta</button>
                            </form>
                        </div>
                    </div>

                    <div class="login-wrap p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <div style="font-size: 50px; color: #727cf5;">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <h3 style="font-weight: 700; color: #333;" class="mt-2">Verifique seu E-mail</h3>
                        </div>
                        
                        <p class="mb-4 text-muted" style="font-size: 14px; line-height: 1.6;">
                            Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos o prazer de enviar outro.
                        </p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="status-message">
                                <i class="fa fa-paper-plane me-2"></i> Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.
                            </div>
                        @endif

                        <div class="mt-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Reenviar E-mail de Verificação
                                </button>
                            </form>
                        </div>

                        <div class="text-center mt-4">
                            <p style="font-size: 12px; color: #999;">Não encontrou? Verifique sua pasta de <strong>Spam</strong>.</p>
                        </div>
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