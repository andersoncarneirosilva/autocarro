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

<div id="alerta-fipe-erro" class="alert alert-danger alert-dismissible bg-transparent d-none" role="alert">
     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    <i class="ri-error-warning-line me-2"></i>
    <strong>Atenção!</strong> O serviço da tabela FIPE está instável no momento. Estamos trabalhando no momento.
</div>

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
                    <span id="fipe-badge-placeholder"></span>
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