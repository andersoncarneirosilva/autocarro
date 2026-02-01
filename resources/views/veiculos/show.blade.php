@extends('layouts.app')

@section('title', 'Detalhes do Veículo - ' . $veiculo->placa)

@section('content')

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


{{-- <div class="row mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 class="text-muted fw-bold mt-0 small text-uppercase">Valor de Compra</h5>
                    <i class="mdi mdi-currency-usd font-22 text-primary"></i>
                </div>
                
                <div class="d-flex align-items-baseline mb-2">
                    <h3 class="my-0">R$ {{ number_format($veiculo->valor_compra, 2, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
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

    <div class="col-md-3">
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

    <div class="col-md-3">
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
</div> --}}

<div class="row mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm mb-0">
            <div class="card-body p-2 px-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <p class="text-muted fw-bold m-0 text-uppercase font-10">Compra</p>
                    <i class="mdi mdi-cash-register text-primary font-14"></i>
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="m-0 fw-bold">R$ {{ number_format($veiculo->valor_compra, 0, ',', '.') }}</h4>
                    @if($veiculo->valor > 0 && $veiculo->valor_compra > 0)
                        @php $margemInicial = (($veiculo->valor - $veiculo->valor_compra) / $veiculo->valor_compra) * 100; @endphp
                        <span class="ms-1 badge bg-soft-primary text-primary font-10" style="padding: 1px 4px;" title="Margem sobre compra">
                            +{{ number_format($margemInicial, 0) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm mb-0">
            <div class="card-body p-2 px-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="d-flex align-items-center">
                        <p class="text-muted fw-bold m-0 text-uppercase font-10">Venda</p>
                        <i class="mdi mdi-tag-text-outline text-success ms-1 font-14"></i>
                    </div>
                    <a href="#" class="font-10 fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">EDITAR</a>
                </div>
                <h4 class="m-0 fw-bold">R$ {{ number_format($veiculo->valor, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm mb-0">
            <div class="card-body p-2 px-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <p class="text-muted fw-bold m-0 text-uppercase font-10">Oferta</p>
                    <i class="mdi mdi-fire text-warning font-14"></i>
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="m-0 fw-bold text-warning">R$ {{ $veiculo->valor_oferta > 0 ? number_format($veiculo->valor_oferta, 0, ',', '.') : '---' }}</h4>
                    @if($veiculo->valor_oferta > 0 && $veiculo->valor > 0)
                        <span class="ms-1 badge bg-soft-danger text-danger font-10" style="padding: 1px 4px;">
                            desconto de {{ number_format((($veiculo->valor - $veiculo->valor_oferta) / $veiculo->valor) * 100, 0) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm mb-0">
            <div class="card-body p-2 px-3">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <p class="text-muted fw-bold m-0 text-uppercase font-10">Fipe</p>
                    <i class="mdi mdi-table-search text-info font-14"></i>
                </div>
                <div class="d-flex align-items-center">
                    <h4 class="m-0 fw-bold text-info" id="fipe-price">---</h4>
                    <span id="fipe-badge-placeholder"></span> {{-- O JS preencherá aqui o "desconto de X% vs Fipe" --}}
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
        <a href="#gastos" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-wrench-outline me-1"></i>
            <span class="d-none d-md-inline-block">Gastos</span>
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

                    <div class="tab-pane" id="gastos">
                        @include('veiculos._tabs.tab-gastos')
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
        min-height: 550px; /* Ajuste este valor conforme a sua maior aba */
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

@include('veiculos._modals.cadastro-multa')

@include('components.toast')

@include('veiculos._modals.cadastro-gasto')

@include('veiculos._modals.upload-crlv')

@endsection