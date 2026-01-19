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
            background: linear-gradient(135deg, #FF4A17 0%, #ac2500 100%) !important;
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
            border-color: #FF4A17;
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
            background: #FF4A17 !important;
            border-color: #FF4A17 !important;
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

        /* Estilo para os botões de seleção */
.btn-group-toggle .btn {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 5px 15px;
}
.btn-outline-danger {
    color: #FF4A17;
    border-color: #FF4A17;
}
.btn-outline-danger:not(:disabled):not(.disabled).active, 
.btn-outline-danger:hover {
    background-color: #FF4A17;
    border-color: #FF4A17;
}
    </style>
    <style>
    .modern-alert-container {
        animation: slideInRight 0.5s ease-out;
    }

    .modern-alert {
        background: #fff;
        border-left: 5px solid #FF4A17;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 15px 20px;
        position: relative;
        overflow: hidden;
    }

    .alert-icon {
        color: #FF4A17;
        font-size: 22px;
        margin-right: 15px;
        margin-top: 2px;
    }

    .alert-title {
        color: #333;
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .alert-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .alert-list li {
        color: #666;
        font-size: 13px;
        line-height: 1.6;
        position: relative;
        padding-left: 15px;
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
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
    

   <form method="POST" action="{{ route('register') }}" class="signin-form">
    @csrf
    
    <input type="hidden" name="account_type" id="account_type" value="{{ old('account_type', 'user') }}">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 style="font-weight: 700; color: #333; margin: 0;">Criar Conta</h3>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label id="btn-user" class="btn btn-outline-danger btn-sm {{ old('account_type', 'user') == 'user' ? 'active' : '' }}" onclick="toggleForm('user')">
                Particular
            </label>
            <label id="btn-dealer" class="btn btn-outline-danger btn-sm {{ old('account_type') == 'dealer' ? 'active' : '' }}" onclick="toggleForm('dealer')">
                Revenda
            </label>
        </div>
    </div>

    @if($errors->any())
    <div class="modern-alert-container mb-4">
        {{-- Mudança para align-items-center para centralizar verticalmente o ícone e a lista --}}
        <div class="modern-alert d-flex align-items-center">
            <div class="alert-icon">
                <i class="fa fa-exclamation-circle"></i>
            </div>
            <div class="alert-content">
                <ul class="alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ is_array($error) ? implode(', ', $error) : $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
    <div id="dealer-fields" style="{{ old('account_type') == 'dealer' ? 'display: block;' : 'display: none;' }}">
        <div class="row">
            <div class="col-md-7 form-group mb-4">
                <label class="label">CNPJ da Revenda</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="cnpj" id="cnpj" value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00" style="border-right: none;">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="btn-consulta-cnpj" style="border: 1px solid #dee2e6; border-left: none; border-radius: 0 8px 8px 0; background: #fff;">
                            <i class="fa fa-search" style="color: #730000;"></i>
                        </button>
                    </div>
                </div>
                <small id="cnpj-loading" style="display:none; color: #730000;">Consultando Receita...</small>
            </div>
            <div class="col-md-5 form-group mb-4">
                <label class="label">CEP</label>
                <input type="text" class="form-control" name="cep" id="cep" value="{{ old('cep') }}" placeholder="00000-000">
            </div>
        </div>

        <div class="row">
            <div class="col-md-9 form-group mb-4">
                <label class="label">Rua / Logradouro</label>
                <input type="text" class="form-control" name="rua" value="{{ old('rua') }}" placeholder="Ex: Av. Principal">
            </div>
            <div class="col-md-3 form-group mb-4">
                <label class="label">Nº</label>
                <input type="text" class="form-control" name="numero" value="{{ old('numero') }}" placeholder="123">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group mb-4">
                <label class="label">Bairro</label>
                <input type="text" class="form-control" name="bairro" value="{{ old('bairro') }}" placeholder="Bairro">
            </div>
            <div class="col-md-6 form-group mb-4">
                <label class="label">Cidade</label>
                <input type="text" class="form-control" name="cidade" value="{{ old('cidade') }}" placeholder="Cidade">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group mb-4">
                <label class="label">UF</label>
                <input type="text" class="form-control" name="estado" value="{{ old('estado') }}" maxlength="2" placeholder="SP">
            </div>
        </div>
        <hr style="border-top: 1px solid #eee; margin-bottom: 25px;">
    </div>

    <div id="cpf-field" class="row" style="{{ old('account_type', 'user') == 'dealer' ? 'display: none;' : '' }}">
    <div class="col-md-12 form-group mb-4">
        <label class="label">CPF</label>
        <input type="text" class="form-control" name="cpf" id="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00">
    </div>
</div>

    <div class="row">
        <div class="col-md-12 form-group mb-4">
            <label class="label" id="label-nome">{{ old('account_type') == 'dealer' ? 'Nome da Revenda / Razão Social' : 'Nome Completo' }}</label>
            <input type="text" class="form-control" name="name" placeholder="Nome do responsável ou da loja" value="{{ old('name') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group mb-4">
            <label class="label">WhatsApp / Celular</label>
            <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="(00) 00000-0000" required>
        </div>
        <div class="col-md-6 form-group mb-4">
            <label class="label">E-mail Profissional</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="contato@email.com" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group mb-4">
            <label class="label">Criar Senha</label>
            <input type="password" class="form-control" name="password" placeholder="••••••••" required>
        </div>
        <div class="col-md-6 form-group mb-4">
            <label class="label">Confirmar Senha</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required>
        </div>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="form-control btn btn-primary px-3 shadow-sm">Finalizar Cadastro no Alcecar</button>
    </div>
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
    function toggleForm(type) {
    const labelNome = document.getElementById('label-nome');
    const inputType = document.getElementById('account_type');
    
    $('.btn-group-toggle .btn').removeClass('active');
    
    if (type === 'dealer') {
        $('#dealer-fields').slideDown(); 
        $('#cpf-field').slideUp(); // Esconde o CPF para Revendas
        labelNome.innerText = 'Nome da Revenda / Razão Social';
        $('#btn-dealer').addClass('active');
        inputType.value = 'dealer';
        
        $('#dealer-fields').find('input').prop('required', true);
        $('#cpf').prop('required', false);
    } else {
        $('#dealer-fields').slideUp();
        $('#cpf-field').slideDown(); // Mostra o CPF para Particulares
        labelNome.innerText = 'Nome Completo';
        $('#btn-user').addClass('active');
        inputType.value = 'user';
        
        $('#dealer-fields').find('input').prop('required', false);
        $('#cpf').prop('required', true);
    }
}

    $(document).ready(function(){
        // Máscaras
        $('#whatsapp').mask('(00) 00000-0000');
        $('#cnpj').mask('00.000.000/0000-00');
        $('#cpf').mask('000.000.000-00');
        $('#cep').mask('00000-000');

        /**
         * LÓGICA DE PERSISTÊNCIA:
         * Verifica se o Laravel retornou erro de validação para uma Revenda
         * Se sim, abre a aba automaticamente ao carregar a página
         */
        @if(old('account_type') == 'dealer' || $errors->has('cnpj'))
            toggleForm('dealer');
        @endif

        // Consulta de CNPJ
        function consultarCNPJ(cnpj) {
            cnpj = cnpj.replace(/\D/g, '');
            if (cnpj.length !== 14) return;

            $('#btn-consulta-cnpj').html('<i class="fa fa-spinner fa-spin"></i>');

            $.getJSON(`https://brasilapi.com.br/api/cnpj/v1/${cnpj}`, function(dados) {
                if (dados.razao_social) {
                    $("[name='name']").val(dados.razao_social);
                    $("[name='rua']").val(dados.logradouro);
                    $("[name='bairro']").val(dados.bairro);
                    $("[name='cidade']").val(dados.municipio);
                    $("[name='estado']").val(dados.uf);
                    $("[name='cep']").val(dados.cep).trigger('input');
                    $("[name='numero']").focus();
                }
            })
            .always(function() {
                $('#btn-consulta-cnpj').html('<i class="fa fa-search" style="color: #730000;"></i>');
            });
        }

        $('#btn-consulta-cnpj').click(function() {
            consultarCNPJ($('#cnpj').val());
        });

        $('#cnpj').blur(function() {
            consultarCNPJ($(this).val());
        });

        // Consulta de CEP
        $('#cep').blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/", function(dados) {
                    if (!("erro" in dados)) {
                        $("[name='rua']").val(dados.logradouro);
                        $("[name='bairro']").val(dados.bairro);
                        $("[name='cidade']").val(dados.localidade);
                        $("[name='estado']").val(dados.uf);
                        $("[name='numero']").focus();
                    }
                });
            }
        });

        if($('#account_type').val() === 'dealer') {
        $('#dealer-fields').find('input').prop('required', true);
    }
    });
</script>

</body>
</html>