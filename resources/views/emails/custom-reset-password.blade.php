<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha - Alcecar</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f9; color: #4a5568; margin: 0; padding: 0; line-height: 1.6; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #ffffff; padding: 30px; text-align: center; border-bottom: 1px solid #f0f0f0; }
        .content { padding: 40px; text-align: center; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #a0aec0; }
        .logo { max-height: 50px; width: auto; }
        h1 { color: #2d3748; font-size: 22px; margin-bottom: 20px; }
        p { margin-bottom: 25px; }
        .button { display: inline-block; padding: 14px 30px; background-color: #4f46e5; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; transition: background-color 0.3s; }
        .divider { height: 1px; background-color: #e2e8f0; margin: 30px 0; }
        .link-alternativo { font-size: 12px; color: #718096; word-break: break-all; }
        @media (max-width: 600px) { .container { margin: 0; border-radius: 0; width: 100%; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="https://alcecar.com.br">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Alcecar" class="logo">
            </a>
        </div>

        <div class="content">
            <h1>Olá!</h1>
            <p>Você recebeu este e-mail porque solicitou a redefinição de senha da sua conta no <strong>Alcecar</strong>.</p>
            
            <a href="{{ $url }}" class="button">Redefinir Senha</a>

            <div class="divider"></div>

            <p style="font-size: 14px;">Este link de redefinição de senha expira em <strong>60 minutos</strong>.</p>
            <p style="font-size: 14px; margin-bottom: 0;">Se você não solicitou esta alteração, ignore este e-mail.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Alcecar. Todos os direitos reservados.</p>
            <p class="link-alternativo">
                Se o botão não funcionar, copie e cole este link no navegador:<br>
                <a href="{{ $url }}" style="color: #4f46e5;">{{ $url }}</a>
            </p>
        </div>
    </div>
</body>
</html>