@extends('layouts.app')

@section('title', 'Detalhes do Veículo - ' . $veiculo->placa)

@section('content')

@include('veiculos._modals.editar-info-veiculo')

@include('veiculos._modals.editar-info-basicas')

@include('veiculos._modals.editar-precos')

@include('veiculos._modals.editar-opcionais')

@include('veiculos._modals.editar-modificacoes')

@include('veiculos._modals.editar-adicionais')

@include('veiculos._modals.editar-descricao')

@include('veiculos._modals.editar-fotos')

@include('veiculos._modals.gerar-documentos')

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
</ul>
</div>

                <div class="tab-content tab-veiculo-container">
                    
                    <div class="tab-pane show active" id="info-geral">
                        @include('veiculos._tabs.tab-info-veiculo')
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

                </div> 
            
                        <div class="row">
    <div class="col-md-4">
    <div class="card widget-flat border-primary border">
        <div class="card-body">
            <div class="float-end">
                <i class="mdi mdi-currency-usd widget-icon bg-primary-lighten text-primary"></i>
            </div>
            
            <h5 class="text-muted fw-normal mt-0" title="Preço base de venda">Valor de Venda</h5>
            <h3 class="mt-3 mb-2">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h3>
            
            @if($veiculo->exibir_parcelamento == '1' && $veiculo->valor_parcela > 0)
                <div class="bg-primary-lighten rounded p-2 mb-2 border border-primary border-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-finance text-primary me-2 font-18"></i>
                        <div>
                            <p class="m-0 text-muted font-11 fw-bold text-uppercase">Entrada + Parcelas</p>
                            <h5 class="m-0 text-primary font-14">
                                {{ $veiculo->qtd_parcelas }}x de R$ {{ number_format($veiculo->valor_parcela, 2, ',', '.') }}
                            </h5>
                        </div>
                    </div>
                </div>
            @else
                <div style="height: 48px;" class="d-flex align-items-center">
                    <p class="text-muted font-12 mb-0 italic">Sem parcelamento ativo</p>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mt-2">
                <p class="mb-0 text-muted">
                    <span class="text-nowrap font-12">Preço de vitrine</span>
                </p>
                <button type="button" class="btn btn-link btn-sm text-primary p-0 text-decoration-none fw-bold font-12" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">
                    <i class="mdi mdi-pencil"></i> EDITAR
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-lighten { background-color: rgba(114, 124, 245, 0.1); }
    .font-11 { font-size: 11px; }
    .font-12 { font-size: 12px; }
    .font-14 { font-size: 14px; }
    .italic { font-style: italic; }
</style>

    <div class="col-md-4">
        <div class="card widget-flat border-warning border">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-tag-outline widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Preço promocional">Valor de Oferta</h5>
                <h3 class="mt-3 mb-2 text-warning">
                    {{ $veiculo->valor_oferta > 0 ? 'R$ ' . number_format($veiculo->valor_oferta, 2, ',', '.') : '---' }}
                </h3>
                <p class="mb-0 text-muted">
                    @if($veiculo->valor_oferta > 0)
                        <span class="text-danger me-2"><i class="mdi mdi-trending-down"></i> Econ. R$ {{ number_format($veiculo->valor - $veiculo->valor_oferta, 2, ',', '.') }}</span>
                    @else
                        <span class="text-nowrap">Sem oferta ativa</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
    <div class="card widget-flat border-success border">
        <div class="card-body">
            <div class="float-end">
                <i class="mdi mdi-calculator widget-icon bg-success-lighten text-success"></i>
            </div>
            <h5 class="text-muted fw-normal mt-0">Tabela FIPE</h5>
            <h3 class="mt-3 mb-2 text-success" id="fipe-price">---</h3>
            <p class="mb-0 text-muted">
                <span id="fipe-comparison"></span>
                <small class="d-block text-truncate" id="fipe-info">Carregando...</small>
            </p>
        </div>
    </div>
</div>
</div>

@if($dadosFipe)
<div class="row">
    <div class="col-12">
        <div class="alert alert-light border-0 py-1 px-2 font-12 text-muted">
            <i class="mdi mdi-information-outline"></i> 
            <b>Referência FIPE:</b> {{ $dadosFipe['model'] }} ({{ $dadosFipe['codeFipe'] }}) - {{ $dadosFipe['referenceMonth'] }}
        </div>
    </div>
</div>
@endif
            </div> 
            
            </div> 
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
            

</div> </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputTipo = document.getElementById('veiculo_tipo');
    const selectMarca = document.getElementById('marca');
    const selectModelo = document.getElementById('modelo_carro');
    const selectVersao = document.getElementById('versao');
    const inputAno = document.getElementById('input-ano');
    const selectCombustivel = document.querySelector('select[name="combustivel"]');

    const BASE_URL = 'https://parallelum.com.br/fipe/api/v1';
    const TOKEN = process.env.FIPE_TOKEN;

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

            if (!isNaN(valorFipe) && valorFipe > 0) {
                const diff = valorVenda - valorFipe;
                const percent = ((diff / valorFipe) * 100).toFixed(1);
                
                //console.log(`Diferença: ${diff.toFixed(2)} (${percent}%)`);

                cardComparison.className = (diff > 0 ? 'text-danger' : 'text-success') + ' me-2 fw-bold';
                cardComparison.innerHTML = `
                    <i class="mdi ${diff > 0 ? 'mdi-arrow-up' : 'mdi-arrow-down'}"></i> 
                    ${Math.abs(percent)}% vs FIPE
                `;
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