<!doctype html>
<html lang="pt-br">
<head>
    <title>Alcecar | Referência em Compra e Venda de Veículos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('sitelogin/css/style.css') }}">
<script src="https://unpkg.com/imask"></script>
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
        .error-message { color: #4a52ac; font-size: 13px; margin-top: 6px; font-weight: 500; }
        .btn-outline-white { border: 2px solid rgba(255,255,255,0.8); border-radius: 8px; padding: 10px 30px; color: #fff; font-weight: 600; }
        .ftco-section { padding: 5em 0; }

        /* Estilo dos Botões de Seleção (igual ao Register) */
        .btn-group-toggle .btn { font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 5px 15px; border: 1px solid #727cf5; color: #727cf5; }
        .btn-group-toggle .btn.active { background-color: #727cf5; color: #fff; }

        /* Container dos botões */
.gap-2 { gap: 0.5rem !important; }

/* Esconde o rádio original */
.btn-check {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none;
}

/* Estilo base do botão (Label) */
.btn-check + .btn-outline-primary {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #fff;
    color: #6c757d;
    transition: all 0.3s ease;
    width: 100%;
}

/* Ícones dentro do botão */
.btn-check + .btn-outline-primary i {
    font-size: 24px;
    margin-bottom: 4px;
}

/* Quando selecionado (Checked) */
.btn-check:checked + .btn-outline-primary {
    background: #727cf5 !important;
    border-color: #727cf5 !important;
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(114, 124, 245, 0.3);
}

/* Hover no não selecionado */
.btn-check:not(:checked) + .btn-outline-primary:hover {
    border-color: #727cf5;
    color: #727cf5;
    background: rgba(114, 124, 245, 0.05);
}
        
    </style>
</head>
<body>

    <section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-11">
                <div class="wrap d-md-flex">
                    <div class="text-wrap p-4 p-lg-5 text-center order-md-first d-flex align-items-center">
                        <div class="text w-100">
                            <div class="sitename mb-4">
                                <img src="{{ url('frontend/images/logo_alcecar.png') }}" alt="Alcecar Logo" style="max-width: 180px;">
                            </div>
                            <h2 style="color: white; font-weight: 700;">Já tem conta?</h2>
                            <p style="color: rgba(255,255,255,0.8);">Se você já é cadastrado, basta acessar sua conta agora mesmo.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-white mt-3">Fazer Login</a>
                        </div>
                    </div>

                    <div class="login-wrap p-4 p-lg-5" style="flex: 1;">
                        <h3 class="mb-4" style="font-weight: 700; color: #333;">Criar Conta</h3>

                        @if($errors->any())
    <div class="alert alert-danger" role="alert">

        <ul class="mt-2 mb-0">
            @foreach($errors->all() as $error)
                <li>
                    @if(is_array($error))
                        {{ json_encode($error) }}
                    @else
                        {{ $error }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif

                        

<form method="POST" action="{{ route('register') }}" class="signin-form">
    @csrf
    
    <div class="form-group mb-4">
        <label class="label">Nome (Responsável)</label>
        <input type="text" class="form-control" name="nome_responsavel" placeholder="Seu nome" value="{{ old('nome_responsavel') }}" required>
    </div>

    <div class="form-group mb-4">
        <label class="label">Nome do Salão / Empresa</label>
        <input type="text" class="form-control" name="razao_social" placeholder="Nome do seu negócio" value="{{ old('razao_social') }}" required>
    </div>
    <div class="form-group mb-4">
    <label class="label">Segmento do Negócio</label>
    <div class="d-flex gap-2">
        <div class="flex-fill" style="flex: 1;">
            <input type="radio" class="btn-check" name="segmento" id="seg_salao" value="salao" autocomplete="off" checked>
            <label class="btn-outline-primary" for="seg_salao">
                <i class="mdi mdi-content-cut"></i>
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase;">Salão</span>
            </label>
        </div>

        <div class="flex-fill" style="flex: 1;">
            <input type="radio" class="btn-check" name="segmento" id="seg_barbearia" value="barbearia" autocomplete="off">
            <label class="btn-outline-primary" for="seg_barbearia">
                <i class="mdi mdi-mustache"></i>
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase;">Barbearia</span>
            </label>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-6 form-group mb-4">
            <label class="label">Tipo de Cadastro</label>
            <select class="form-control" id="tipo_doc" name="tipo_doc">
                <option value="cpf">Pessoa Física (CPF)</option>
                <option value="cnpj">Pessoa Jurídica (CNPJ)</option>
            </select>
        </div>
        <div class="col-md-6 form-group mb-4">
            <label class="label" id="label_doc">CPF</label>
            <input type="text" class="form-control" name="documento" id="documento" value="{{ old('documento') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group mb-4">
            <label class="label">WhatsApp</label>
            <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="(00) 00000-0000" required>
        </div>
        <div class="col-md-6 form-group mb-4">
            <label class="label">E-mail de Acesso</label>
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

    <button type="submit" class="form-control btn btn-primary px-3 shadow-sm">Finalizar Cadastro</button>
</form>

<script>
    // 1. Configuração da Máscara do WhatsApp
    const whatsappMask = IMask(document.getElementById('whatsapp'), {
        mask: '(00) 00000-0000'
    });

    // 2. Configuração Dinâmica CPF/CNPJ
    const docInput = document.getElementById('documento');
    const tipoDocSelect = document.getElementById('tipo_doc');
    const labelDoc = document.getElementById('label_doc');

    // Opções de máscaras
    const maskOptions = {
        cpf: { mask: '000.000.000-00' },
        cnpj: { mask: '00.000.000/0000-00' }
    };

    // Inicializa a máscara como CPF
    let docMask = IMask(docInput, maskOptions.cpf);

    // Listener para trocar a máscara ao mudar o Select
    tipoDocSelect.addEventListener('change', function() {
        // Destrói a máscara anterior para aplicar a nova
        docMask.destroy();
        
        if (this.value === 'cpf') {
            labelDoc.innerText = 'CPF';
            docMask = IMask(docInput, maskOptions.cpf);
        } else {
            labelDoc.innerText = 'CNPJ';
            docMask = IMask(docInput, maskOptions.cnpj);
        }
        
        docInput.value = ''; // Limpa o campo para evitar conflitos de máscara
    });
</script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ url('sitelogin/js/jquery.min.js') }}"></script>

<script>
// 1. MÁSCARAS NATIVAS (CPF e WhatsApp)
// Substitui a necessidade do jquery.mask.min.js
document.addEventListener('input', function (e) {
    if (e.target.id === 'cpf') {
        let v = e.target.value.replace(/\D/g, '');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = v.substring(0, 14);
    }
    if (e.target.id === 'whatsapp') {
        let v = e.target.value.replace(/\D/g, '');
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
        v = v.replace(/(\d{5})(\d)/, "$1-$2");
        e.target.value = v.substring(0, 15);
    }
});

// 2. CARREGAMENTO DE ESTADOS E CIDADES (IBGE)
document.addEventListener('DOMContentLoaded', function() {
    const selectEstado = document.getElementById('estado');
    const selectCidade = document.getElementById('cidade');

    if (selectEstado) {
        // Carregar Estados
        fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
            .then(response => response.json())
            .then(estados => {
                estados.forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado.sigla;
                    option.textContent = estado.nome;
                    selectEstado.appendChild(option);
                });
            });

        // Escutar mudança no Estado para carregar Cidades
        selectEstado.addEventListener('change', function() {
            const estadoSigla = this.value;
            
            selectCidade.innerHTML = '<option value="">Carregando cidades...</option>';
            selectCidade.disabled = true;

            if (estadoSigla) {
                fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoSigla}/municipios?orderBy=nome`)
                    .then(response => response.json())
                    .then(cidades => {
                        selectCidade.innerHTML = '<option value="">Selecione a Cidade</option>';
                        cidades.forEach(cidade => {
                            const option = document.createElement('option');
                            option.value = cidade.nome.toUpperCase(); 
                            option.textContent = cidade.nome.toUpperCase();
                            selectCidade.appendChild(option);
                        });
                        selectCidade.disabled = false;
                    });
            } else {
                selectCidade.innerHTML = '<option value="">Selecione um Estado primeiro</option>';
            }
        });
    }
});
</script>

</body>
</html>