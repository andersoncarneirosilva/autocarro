@extends('layouts.app')

@section('title', 'Detalhes do Veículo - ' . $veiculo->placa)

@section('content')

@include('veiculos._modals.editar-info-veiculo')

@include('veiculos._modals.editar-info-registro')

@include('veiculos._modals.editar-precos')

@include('veiculos._modals.editar-opcionais')

@include('veiculos._modals.editar-modificacoes')

@include('veiculos._modals.editar-adicionais')

@include('veiculos._modals.editar-descricao')

@include('veiculos._modals.editar-fotos')

@include('veiculos._modals.gerar-documentos')

@include('veiculos._modals.vender-veiculo')

{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fff',
        color: '#313a46',
    });

    @if (session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    @if (session('error'))
        Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
    @endif
});
</script>
@endif

<div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('veiculos.index') }}">Veículos</a></li>
                        <li class="breadcrumb-item active">Detalhes</li>
                    </ol>
                </div>
                <h3 class="page-title">Detalhes do veículo</h3>
            </div>
        </div>
    </div>

<div class="row mb-3">
    <div class="col-md-4">
    <div class="card border-0 shadow-sm mb-0 h-100">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="text-muted fw-bold mt-0 small text-uppercase">Valor de Venda</h5>
                <i class="mdi mdi-currency-usd font-22 text-primary"></i>
            </div>
            
            <div class="d-flex align-items-baseline mb-2">
                <h3 class="my-0">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h3>
            </div>

            @if($veiculo->exibir_parcelamento == '1' && $veiculo->valor_parcela > 0)
                <div class="p-2 bg-primary-lighten rounded-pill border-primary border border-opacity-10 d-flex align-items-center justify-content-between px-3">
                    <p class="m-0 text-primary font-12 fw-bold">
                        <i class="mdi mdi-finance me-1"></i>
                        {{ $veiculo->qtd_parcelas }}x de R$ {{ number_format($veiculo->valor_parcela, 2, ',', '.') }}
                    </p>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-bold font-12" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">
                        <i class="mdi mdi-pencil me-1"></i>EDITAR VALOR
                    </button>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-between mt-2 pt-1">
                    <p class="text-muted font-12 mb-0 italic">Sem parcelamento ativo</p>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-bold font-12" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">
                        <i class="mdi mdi-pencil me-1"></i>EDITAR VALOR
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 class="text-muted fw-bold mt-0 small text-uppercase">Valor de Oferta</h5>
                    <i class="mdi mdi-tag-outline font-22 text-warning"></i>
                </div>
                <h3 class="my-0 text-warning">
                    {{ $veiculo->valor_oferta > 0 ? 'R$ ' . number_format($veiculo->valor_oferta, 2, ',', '.') : '---' }}
                </h3>
                <div class="mt-2">
                    @if($veiculo->valor_oferta > 0)
                        <span class="badge bg-soft-danger text-danger px-2 py-1">
                            <i class="mdi mdi-trending-down"></i> Econ. R$ {{ number_format($veiculo->valor - $veiculo->valor_oferta, 2, ',', '.') }}
                        </span>
                    @else
                        <span class="text-muted font-12">Sem oferta ativa</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 class="text-muted fw-bold mt-0 small text-uppercase">Tabela FIPE</h5>
                    <i class="mdi mdi-calculator font-22 text-success"></i>
                </div>
                <h3 class="my-0 text-success" id="fipe-price">---</h3>
                <div class="mt-2 text-truncate">
                    <span id="fipe-comparison"></span>
                    <small class="text-muted d-block" id="fipe-info">Carregando...</small>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .bg-primary-lighten { background-color: rgba(114, 124, 245, 0.12); }
    .bg-soft-danger { background-color: rgba(250, 92, 124, 0.12); }
    .font-12 { font-size: 12px; }
    .italic { font-style: italic; }
    .nav-tabs .nav-link { color: #6c757d; border: none; padding: 10px 20px; font-weight: 500; }
    .nav-tabs .nav-link.active { color: #727cf5; border-bottom: 2px solid #727cf5; }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom">
    <ul class="nav nav-tabs nav-bordered border-0 mb-0">
    <li class="nav-item">
        <a href="#info-geral" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
            <i class="mdi mdi-car-info me-1"></i>
            <span class="d-none d-md-inline-block">Dados do Veículo</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#info-registro" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-car-cog me-1"></i>
            <span class="d-none d-md-inline-block">Informações de Registro</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#opcionais" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-check-all me-1"></i>
            <span class="d-none d-md-inline-block">Opcionais</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#descricao" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
            <i class="mdi mdi-text-box-outline me-1"></i>
            <span class="d-none d-md-inline-block">Descrição</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#documentos" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-file-document-outline me-1"></i>
            <span class="d-none d-md-inline-block">Documentos</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#multas" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-file-document-outline me-1"></i>
            <span class="d-none d-md-inline-block">Multas</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#venda" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-cash-register me-1"></i>
            <span class="d-none d-md-inline-block">Venda / Checkout</span>
        </a>
    </li>
</ul>
</div>

                <div class="tab-content tab-veiculo-container">
                    
                    <div class="tab-pane show active" id="info-geral">
                        @include('veiculos._tabs.tab-info-veiculo')
                    </div>

                    <div class="tab-pane" id="info-registro">
                        @include('veiculos._tabs.tab-info-registro')
                    </div>

                    <div class="tab-pane" id="descricao">
                        @include('veiculos._tabs.tab-descricao')
                    </div>

                    <div class="tab-pane" id="opcionais">
                        @include('veiculos._tabs.tab-opcionais')
                    </div>

                    <div class="tab-pane" id="documentos">
                        @include('veiculos._tabs.tab-documentos')
                    </div>

                    <div class="tab-pane" id="multas">
                        @include('veiculos._tabs.tab-multas')
                    </div>

                    <div class="tab-pane" id="venda">
                        @include('veiculos._tabs.tab-venda')
                    </div>

                </div>
            
                       



            </div> 
            
            </div> 

            

</div> </div>
                <style>
    /* Define uma altura mínima para evitar que o card "encolha" demais */
    .tab-veiculo-container {
        min-height: 650px; /* Ajuste este valor conforme a sua maior aba */
        transition: min-height 0.3s ease; /* Transição suave opcional */
        padding: 15px 0;
    }

    /* Opcional: Adicionar uma transição de fade suave ao trocar de abas */
    .tab-pane.active {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputTipo = document.getElementById('veiculo_tipo');
    const selectMarca = document.getElementById('marca');
    const selectModelo = document.getElementById('modelo_carro');
    const selectVersao = document.getElementById('versao');
    const inputAno = document.getElementById('input-ano');
    const selectCombustivel = document.querySelector('select[name="combustivel"]');

    const BASE_URL = 'https://parallelum.com.br/fipe/api/v1';
    const TOKEN = window.AppConfig.fipeToken;

    // Objeto de configuração para os headers (centralizado)
    const requestOptions = {
        method: 'GET',
        headers: {
            'X-Subscription-Token': TOKEN,
            'Accept': 'application/json'
        }
    };

    const tipoRota = getTipoRota();
    const marcaSalva = "{{ $veiculo->marca }}";
    const modeloSalvo = "{{ $veiculo->modelo }}";
    const versaoSalva = "{{ $veiculo->versao }}";

    // 1. DECLARE AS VARIÁVEIS APENAS UMA VEZ NO TOPO
    const dbMarcaId = document.getElementById('db_fipe_marca_id')?.value;
    const dbModeloId = document.getElementById('db_fipe_modelo_id')?.value;
    const dbVersaoId = document.getElementById('db_fipe_versao_id')?.value;

    // 2. Defina a função ANTES de usá-la
    function getTipoRota() {
        const valor = inputTipo ? inputTipo.value.toUpperCase() : 'AUTOMOVEL';
        if (valor === 'MOTOCICLETA' || valor === 'MOTO') return 'motos';
        if (valor === 'CAMINHAO' || valor === 'CAMINHÃO') return 'caminhoes';
        return 'carros';
    }
    
    // --- CARREGAMENTO INICIAL DE MARCAS ---
    // Removi a linha duplicada que estava causando o erro de Syntax
    fetch(`${BASE_URL}/${tipoRota}/marcas`, requestOptions)
        .then(response => {
            if (!response.ok) throw new Error('Erro na API');
            return response.json();
        })
        .then(marcas => {
            if (!Array.isArray(marcas)) return;

            selectMarca.innerHTML = '<option value="">Selecione a Marca</option>';
            
            marcas.forEach(marca => {
                const opt = document.createElement('option');
                opt.value = marca.codigo;
                opt.textContent = marca.nome;
                
                // Comparação com o ID vindo do banco
                if (dbMarcaId && marca.codigo == dbMarcaId) {
                    opt.selected = true;
                } else if (!dbMarcaId && marcaSalva && marca.nome.toUpperCase().includes(marcaSalva.toUpperCase())) {
                    opt.selected = true;
                }
                
                selectMarca.appendChild(opt);
            });

            if (selectMarca.value) {
                // Atualiza o hidden name="marca_nome"
                const inputMarcaNome = document.getElementById('marca_nome');
                if (inputMarcaNome) inputMarcaNome.value = selectMarca.options[selectMarca.selectedIndex].text;
                
                // Passa o ID do modelo salvo para a próxima função
                carregarModelos(selectMarca.value, dbModeloId);
            }
        })
        .catch(error => console.error('Erro ao carregar marcas:', error));

    function carregarModelos(marcaId, modeloIdParaSelecionar) {
    // Limpa o select e desativa para evitar seleção errada enquanto carrega
    selectModelo.innerHTML = '<option value="">Carregando...</option>';
    selectModelo.disabled = true;
    
    fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos`, requestOptions)
        .then(res => res.json())
        .then(data => {
            selectModelo.innerHTML = '<option value="">Selecione o Modelo</option>';
            
            if (data.modelos && Array.isArray(data.modelos)) {
                data.modelos.forEach(m => {
                    const opt = new Option(m.nome, m.codigo);
                    
                    // PRIORIDADE MÁXIMA: Comparação por ID numérico
                    if (modeloIdParaSelecionar && String(m.codigo) === String(modeloIdParaSelecionar)) {
                        opt.selected = true;
                    } 
                    // SEGUNDA OPÇÃO: Se não tiver ID no banco, tenta o nome exato
                    else if (!modeloIdParaSelecionar && modeloSalvo && m.nome.toUpperCase() === modeloSalvo.toUpperCase()) {
                        opt.selected = true;
                    }
                    
                    selectModelo.add(opt);
                });
            }

            selectModelo.disabled = false;

            if (selectModelo.value) {
                // Atualiza o nome real para o input hidden
                const inputModNome = document.getElementById('modelo_nome');
                if (inputModNome) inputModNome.value = selectModelo.options[selectModelo.selectedIndex].text;
                
                // Dispara o carregamento da versão usando o ID do banco
                carregarVersoes(marcaId, selectModelo.value, dbVersaoId);
            }
        });
}

    function carregarVersoes(marcaId, modeloId, versaoIdParaSelecionar) {
    selectVersao.innerHTML = '<option value="">Carregando...</option>';
    
    // Limpamos o ID de espaços para evitar erros de comparação
    const idBusca = versaoIdParaSelecionar ? String(versaoIdParaSelecionar).trim() : null;

    fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos`, requestOptions)
        .then(res => res.json())
        .then(anos => {
            selectVersao.innerHTML = '<option value="">Selecione a Versão</option>';
            
            anos.forEach(a => {
                const opt = new Option(a.nome, a.codigo);
                
                // PRIORIDADE: ID salvo no banco (2015-1)
                if (idBusca && a.codigo == idBusca) {
                    opt.selected = true;
                } 
                // FALLBACK: Caso o ID falhe, tenta pelo Ano salvo na variável versaoSalva
                else if (!idBusca && versaoSalva && a.nome.includes(versaoSalva)) {
                    opt.selected = true;
                }
                
                selectVersao.add(opt);
            });

            // Se selecionou algo, atualiza o nome e dispara o card da FIPE
            if (selectVersao.value) {
                const inputVerNome = document.getElementById('versao_nome');
                if (inputVerNome) {
                    inputVerNome.value = selectVersao.options[selectVersao.selectedIndex].text;
                }
                
                // Isso vai fazer o card da FIPE aparecer automaticamente
                selectVersao.dispatchEvent(new Event('change'));
            }
        })
        .catch(err => {
            console.error("Erro ao carregar versões:", err);
            selectVersao.innerHTML = '<option value="">Erro ao carregar</option>';
        });
}

    // --- EVENTOS ---

    selectMarca.addEventListener('change', function() {
        const marcaId = this.value;
        const marcaNome = this.options[this.selectedIndex].text;
        if(document.getElementById('marca_nome')) document.getElementById('marca_nome').value = marcaNome;
        carregarModelos(marcaId);
    });

    selectModelo.addEventListener('change', function() {
        const marcaId = selectMarca.value;
        const modeloId = this.value;
        if(document.getElementById('modelo_nome')) document.getElementById('modelo_nome').value = this.options[this.selectedIndex].text;
        carregarVersoes(marcaId, modeloId);
    });

    selectVersao.addEventListener('change', function() {
    const marcaId = selectMarca.value;
    const modeloId = selectModelo.value;
    const anoId = this.value;

    // CAPTURA O TEXTO DA VERSÃO (O que o usuário lê no select)
    if (this.selectedIndex !== -1) {
        const nomeVersao = this.options[this.selectedIndex].text;
        document.getElementById('versao_nome').value = nomeVersao;
        //console.log("📝 Nome da versão definido para:", nomeVersao);
    }
    
    if (marcaId && modeloId && anoId) {
        //console.log("🚀 Alcecar: Iniciando busca de valores...");
        //console.log(`Parâmetros: Marca ${marcaId}, Modelo ${modeloId}, Ano ${anoId}`);

        const elPrice = document.getElementById('fipe-price');
        if(elPrice) elPrice.innerText = "Consultando...";

        fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos/${anoId}`, requestOptions)
    .then(response => {
        //console.log("Status da Resposta:", response.status);
        return response.json();
    })
    .then(veiculo => {
        // EXIBE OS DADOS NO CONSOLE EM FORMATO DE TABELA
        //console.log("✅ Dados FIPE recebidos:");
        //console.table(veiculo);

        // BUSCA OS ELEMENTOS NOVAMENTE PARA GARANTIR A INJEÇÃO NO CARD
        const cardPrice = document.getElementById('fipe-price');
        const cardInfo = document.getElementById('fipe-info');
        const cardComparison = document.getElementById('fipe-comparison');

        if (cardPrice) {
            cardPrice.innerText = veiculo.Valor;
            //console.log("Injetado no card -> Valor:", veiculo.Valor);
        } else {
            //console.error("❌ Erro: Elemento #fipe-price não encontrado no DOM!");
        }

        if (cardInfo) {
            cardInfo.innerText = `Ref: ${veiculo.MesReferencia}`;
            //console.log("Injetado no card -> Referência:", veiculo.MesReferencia);
        }

        if (cardComparison) {
            const valorVendaRaw = "{{ $veiculo->valor_oferta > 0 ? $veiculo->valor_oferta : $veiculo->valor }}";
            const valorVenda = parseFloat(valorVendaRaw);
            // Tratamento do valor FIPE (remove R$, pontos e troca vírgula por ponto)
            const valorFipe = parseFloat(veiculo.Valor.replace(/[R$\s.]/g, '').replace(',', '.'));

            //console.log("📊 Comparativo de Preços:");
            //console.log(`Valor Venda: R$ ${valorVenda}`);
            //console.log(`Valor FIPE: R$ ${valorFipe}`);

            // Verifica se ambos os valores são números válidos e maiores que zero
if (!isNaN(valorFipe) && valorFipe > 0 && !isNaN(valorVenda) && valorVenda > 0) {
    const diff = valorVenda - valorFipe;
    const percent = ((diff / valorFipe) * 100).toFixed(1);
    
    cardComparison.className = (diff > 0 ? 'text-danger' : 'text-success') + ' me-2 fw-bold';
    cardComparison.innerHTML = `
        <i class="mdi ${diff > 0 ? 'mdi-arrow-up' : 'mdi-arrow-down'}"></i> 
        ${Math.abs(percent)}% vs FIPE
    `;
} else {
    // Caso o valor de venda seja 0 ou não exista, limpamos o comparativo ou exibimos algo neutro
    cardComparison.innerHTML = `<span class="text-muted small">Aguardando valor</span>`;
    cardComparison.className = 'me-2 fw-bold';
}
        }
    })
    .catch(err => {
        console.error("❌ Erro na consulta FIPE:", err);
        const errorPrice = document.getElementById('fipe-price');
        if(errorPrice) errorPrice.innerText = "Erro ao buscar";
    });
    }
});
});
</script>

@endsection