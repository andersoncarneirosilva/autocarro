@extends('layouts.app')

@section('title', 'Detalhes do Veículo - ' . $veiculo->placa)

@section('content')

@include('anuncios._partials.editar-info-basicas')

@include('anuncios._partials.editar-precos')

@include('anuncios._partials.editar-opcionais')

@include('anuncios._partials.editar-modificacoes')

@include('anuncios._partials.editar-adicionais')

@include('anuncios._partials.editar-descricao')

@include('anuncios._partials.editar-fotos')

@include('anuncios._partials.gerar-documentos')

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
                <i class="mdi mdi-car-info d-md-none d-block"></i>
                <span class="d-none d-md-block">Dados do Veículo</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#opcionais-tab" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                <i class="mdi mdi-star-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Opcionais e Modificações</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#fotos-desc" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                <i class="mdi mdi-image-multiple d-md-none d-block"></i>
                <span class="d-none d-md-block">Descrição</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#proprietario" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                <span class="d-none d-md-block">Documentos</span>
            </a>
        </li>
    </ul>

    <div class="d-flex align-items-center gap-2 pb-1">
    @if($veiculo->status_anuncio == 'Publicado')
        <span class="badge badge-success-lighten p-1 px-2">
            <i class="mdi mdi-check-decagram me-1"></i> Anúncio Publicado
        </span>

        <form action="{{ route('anuncios.remover', $veiculo->id) }}" method="POST" class="d-inline form-remover">
            @csrf
            @method('PATCH')
            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 btn-remover">
                <i class="mdi mdi-eye-off-outline me-1"></i> Remover do Site
            </button>
        </form>
    @else
        <span class="badge badge-outline-warning p-1 px-2">
            <i class="mdi mdi-clock-outline me-1"></i> Aguardando
        </span>

        <form action="{{ route('anuncios.publicar', $veiculo->id) }}" method="POST" class="d-inline form-publicar">
            @csrf
            @method('PATCH')
            <button type="button" class="btn btn-success btn-sm rounded-pill px-3 btn-publicar">
                <i class="mdi mdi-rocket-launch me-1"></i> Publicar
            </button>
        </form>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Captura o clique no botão de publicar
    $('.btn-publicar').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Publicar Anúncio?',
            text: "O veículo ficará visível para todos os clientes no site!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10c469', // Cor success do seu tema
            cancelButtonColor: '#f05050', // Cor danger do seu tema
            confirmButtonText: 'Sim, publicar agora!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.btn-remover').on('click', function(e) {
    e.preventDefault();
    let form = $(this).closest('form');

        Swal.fire({
            title: 'Remover Publicação?',
            text: "O veículo deixará de ser exibido no site imediatamente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f05050', // Danger
            cancelButtonColor: '#98a6ad', // Muted
            confirmButtonText: 'Sim, remover!',
            cancelButtonText: 'Manter online',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>
</div>

                <div class="tab-content">
                    
                    <div class="tab-pane show active" id="info-geral">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="header-title mb-3 text-primary"><i class="mdi mdi-card-account-details-outline me-1"></i> Informações do Proprietário</h4>
                                    
                                </div>
                                
            <div class="row mb-3">
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Nome do Proprietário</p>
                    <h5 class="mt-0">{{ $veiculo->nome }}</h5>
                </div>  
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Cidade/UF</p>
                    <h5 class="mt-0">{{ $veiculo->cidade }}</h5>
                </div>  
                 <div class="col-md-4">
                    <p class="mb-1 text-muted">CPF</p>
                    <h5 class="mt-0">{{ $veiculo->cpf }}</h5>
                </div>
            </div>  
            <hr>
            <h4 class="header-title mb-3 text-primary"><i class="mdi mdi-card-account-details-outline me-1"></i> Informações do veículo</h4>
            <div class="row mb-3">
                <div class="col-md-4"> 
                    <p class="mb-1 text-muted">Placa / Anterior</p>
                    <h5 class="mt-0">{{ $veiculo->placa }} <small class="text-muted">({{ $veiculo->placaAnterior }})</small></h5>
                    <p class="mb-1 text-muted">Cor</p>
                    <h5 class="mt-0">{{ $veiculo->cor }}</h5>
                    <p class="mb-1 text-muted">Motor</p>
                    <h5 class="mt-0">{{ $veiculo->motor }}</h5>
                    {{-- <p class="mb-1 text-muted">Chassi</p>
                    <h5 class="mt-0">{{ $veiculo->chassi }}</h5> --}}
                </div>
                <div class="col-md-4"> 
                    <p class="mb-1 text-muted">Marca/Modelo</p>
                    <h5 class="mt-0">{{ $veiculo->marca }}</h5>
                    <p class="mb-1 text-muted">Combustível</p>
                    <h5 class="mt-0">{{ $veiculo->combustivel }}</h5>
                    <p class="mb-1 text-muted">Renavam</p>
                    <h5 class="mt-0">{{ $veiculo->renavam }}</h5>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Ano</p>
                    <h5 class="mt-0">{{ $veiculo->ano }}</h5>
                    <p class="mb-1 text-muted">Tipo / Categoria</p>
                    <h5 class="mt-0">{{ $veiculo->tipo }} / {{ $veiculo->categoria }}</h5>
                    <p class="mb-1 text-muted">Número do CRV</p>
                    <h5 class="mt-0">{{ $veiculo->crv }}</h5>
                </div>
            </div>
            <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0">
                    <i class="mdi mdi-car-info me-1"></i> Informações básicas
                </h4>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEditarInfoBasica">
                    <i class="mdi mdi-sync me-1"></i> Atualizar Dados
                </button>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Câmbio</p>
                    <h5 class="mt-0">{{ $veiculo->cambio ?? 'N/A' }}</h5>
                    
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Kilometragem</p>
                    <h5 class="mt-0">{{ $veiculo->kilometragem ?? '0' }} KM</h5>
                </div>
                <div class="col-md-4">
                     
                    <p class="mb-1 text-muted">Portas</p>
                        @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA')
                            <small>(Não aplicável)</small> 
                            @else
                            <h5 class="mt-0">{{ $veiculo->portas }}</h5>
                            @endif
                </div>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Estado</p>
                    <h5 class="mt-0">{{ $veiculo->estado ?? 'Não informado' }}</h5>
                    
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Especial</p>
                    <h5 class="mt-0">{{ $veiculo->especiais ?? 'Não informado' }}</h5>
                </div>
                <div class="col-md-4">

                </div>
                
            </div>
                            </div>

                            <div class="col-md-4 border-start">
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="header-title text-primary mb-0">Foto Principal</h4>
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUploadFotos">
                <i class="mdi mdi-camera-plus me-1"></i> Fotos
            </button>
        </div>
        
        @php $imagens = json_decode($veiculo->images); @endphp
                            
        
        <div class="position-relative border rounded p-1 bg-white shadow-sm">
            @if(!empty($imagens))
                                <div id="carouselVeiculo" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($imagens as $key => $img)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 rounded" style="max-height: 400px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <i class="mdi mdi-image-off text-muted font-24"></i>
                                </div>
                            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="header-title text-primary mb-0">Valor e oferta</h4>
    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">
        <i class="mdi mdi-currency-usd"></i> Atualizar preço
    </button>
</div>

<div class="row g-2"> 
    <div class="col-6">
        <div class="card mb-0 border shadow-none bg-light-lighten h-100">
            <div class="card-body p-2 text-center">
                <h6 class="text-muted text-uppercase font-11 mt-0 text-truncate">Valor de Venda</h6>
                <h3 class="text-success mb-0">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card mb-0 border shadow-none bg-light-lighten h-100">
            <div class="card-body p-2 text-center">
                <h6 class="text-muted text-uppercase font-11 mt-0 text-truncate">Oferta Mínima</h6>
                <h3 class="text-primary mb-0">R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    @if($veiculo->exibir_parcelamento == 1 && $veiculo->qtd_parcelas > 1)
        @php
            $totalFinanciado = $veiculo->qtd_parcelas * $veiculo->valor_parcela;
            $diferencaJuros = $totalFinanciado - $veiculo->valor;
        @endphp

        <div class="col-12 mt-2">
    <div class="card mb-0 border shadow-none" style="background-color: #f8f9fa; border-style: dashed !important;">
        <div class="card-body p-2 text-center">
            @php
                $totalFinanciado = $veiculo->qtd_parcelas * $veiculo->valor_parcela;
                $custoJuros = $totalFinanciado - $veiculo->valor;
            @endphp

            <p class="mb-0 text-dark fw-bold" style="font-size: 15px;">
                {{ $veiculo->qtd_parcelas }}x de 
                <span class="text-primary">R$ {{ number_format($veiculo->valor_parcela, 2, ',', '.') }}</span>
            </p>
            
            <div class="mt-1 pt-1 border-top border-light">
                <small class="text-muted d-block" style="font-size: 11px;">
                    @if($veiculo->taxa_juros > 0)
                        <i class="mdi mdi-trending-up me-1 text-danger"></i>
                        Total: <strong>R$ {{ number_format($totalFinanciado, 2, ',', '.') }}</strong> 
                        <span class="mx-1">|</span> 
                        Juros: <strong class="text-danger">+ R$ {{ number_format($custoJuros, 2, ',', '.') }}</strong>
                    @else
                        <i class="mdi mdi-check-circle-outline me-1 text-success"></i>
                        <strong>Total: R$ {{ number_format($totalFinanciado, 2, ',', '.') }}</strong>
                        <span class="badge bg-soft-success text-success ms-1">TAXA ZERO</span>
                    @endif
                </small>
                
                <small class="text-muted d-block mt-1" style="font-size: 10px;">
                    Custo do financiamento calculado com taxa de {{ number_format($veiculo->taxa_juros, 2, ',', '.') }}% a.m.
                </small>
            </div>
        </div>
    </div>
</div>
    @endif
</div>
</div>


                        </div>
                    </div>

                    <div class="tab-pane" id="fotos-desc">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0 text-uppercase" style="letter-spacing: 1px;">
                    Descrição do Anúncio
                </h4>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDescricao">
                    <i class="mdi mdi-pencil me-1"></i> Atualizar descrição
                </button>
            </div>
            
            <div class="border p-4 rounded bg-white shadow-none" style="min-height: 250px;">
                <div class="text-muted" style="white-space: pre-wrap; line-height: 1.6; font-size: 14px;">{{ trim($veiculo->observacoes) ?: 'Nenhuma observação cadastrada.' }}</div>
            </div>
        </div>
    </div>
</div>

                    <div class="tab-pane" id="opcionais-tab">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-primary"><i class="mdi mdi-plus-box-outline me-1"></i> Adicionais</h5>
                                    <button class="btn btn-xs btn-light" data-bs-toggle="modal" data-bs-target="#modalAdicionais"><i class="mdi mdi-pencil"></i></button>
                                </div>
                                <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
    @php $adicionais = json_decode($veiculo->adicionais) ?? []; @endphp

    @forelse($adicionais as $ad)
        <span class="badge badge-outline-secondary px-2 py-1 fw-normal" style="font-size: 13px;">
            {{ $ad }}
        </span>
    @empty
        <span class="text-muted small p-1">Nenhum adicional selecionado.</span>
    @endforelse
</div>
                            </div>
                            <div class="col-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="text-primary mb-0"><i class="mdi mdi-check-all me-1"></i> Opcionais</h5>
        <button class="btn btn-xs btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalOpcionais">
            <i class="mdi mdi-pencil"></i>
        </button>
    </div>
    <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
        @forelse(json_decode($veiculo->opcionais) ?? [] as $opt)
            <span class="badge badge-outline-secondary px-2 py-1 fw-normal" style="font-size: 13px;">
                {{ $opt }}
            </span>
        @empty
            <span class="text-muted small p-1">Nenhum opcional selecionado.</span>
        @endforelse
    </div>
</div>

<div class="col-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="text-primary mb-0"><i class="mdi mdi-auto-fix me-1"></i> Modificações</h5>
        <button class="btn btn-xs btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalModificacoes">
            <i class="mdi mdi-pencil"></i>
        </button>
    </div>
    <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
        @forelse(json_decode($veiculo->modificacoes) ?? [] as $mod)
            <span class="badge bg-info-lighten text-info border border-info px-2 py-1 fw-normal" style="font-size: 13px;">
                {{ $mod }}
            </span>
        @empty
            <span class="text-muted small p-1">Nenhuma modificação.</span>
        @endforelse
    </div>
</div>
                        </div>
                    </div>

                    <div class="tab-pane" id="proprietario">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-primary mb-0"><i class="mdi mdi-file me-1"></i> Documentos</h5>
                
                <button type="button" class="btn btn-outline-primary btn-xs rounded-pill" data-bs-toggle="modal" data-bs-target="#modalGerarDocs">
                    <i class="mdi mdi-pencil"></i> Gerar documentos
                </button>
            </div>
            
            <ul class="list-group list-group-flush border rounded bg-light-lighten">


    <li class="list-group-item bg-transparent py-3">
    <div class="d-flex align-items-center mb-2">
        <i class="mdi mdi-file-document-outline me-2 font-18 text-muted"></i>
        <div>
            <span class="fw-medium d-block">CRLV</span>
            <small class="text-muted">Certificado de Registro e Licenciamento de Veículo</small>
        </div>
    </div>

    @if($veiculo->arquivo_doc)
        <div class="shadow-none border rounded p-2 bg-white">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light bg-soft-danger text-danger rounded">
                            <i class="mdi mdi-file-pdf-box font-24"></i>
                        </span>
                    </div>
                </div>
                <div class="col ps-0 text-start">
                    {{-- O link usa o campo direto do veículo --}}
                    <a href="{{ $veiculo->arquivo_doc }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->arquivo_doc) }}">
                        {{ basename($veiculo->arquivo_doc) }}
                    </a>
                    <p class="mb-0 font-12 text-muted">
                        {{-- Caso você tenha o tamanho salvo no banco, senão pode exibir 'Documento PDF' --}}
                        {{ isset($veiculo->size_doc) ? number_format($veiculo->size_doc / 1024, 2, ',', '.') . ' KB' : 'Documento Digital' }}
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ $veiculo->arquivo_doc }}" download class="btn btn-link btn-sm text-muted">
                        <i class="mdi mdi-download font-18"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center bg-light-lighten border border-dashed rounded p-2">
            <span class="text-muted font-12 italic">Documento não anexado</span>
            <span class="badge bg-soft-warning text-warning border border-warning">Pendente</span>
        </div>
    @endif
</li>

    <li class="list-group-item bg-transparent py-3">
    <div class="d-flex align-items-center mb-2">
        <i class="mdi mdi-file-certificate-outline me-2 font-18 text-muted"></i>
        <div>
            <span class="fw-medium d-block">Procuração</span>
            <small class="text-muted">Documento de representação jurídica</small>
        </div>
    </div>

    @if($veiculo->documentos && $veiculo->documentos->arquivo_proc)
        <div class="shadow-none border rounded p-2 bg-white">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light bg-soft-danger text-danger rounded">
                            <i class="mdi mdi-file-pdf-box font-24"></i>
                        </span>
                    </div>
                </div>
                <div class="col ps-0 text-start">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_proc) }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->documentos->arquivo_proc) }}">
                        {{ basename($veiculo->documentos->arquivo_proc) }}
                    </a>
                    <p class="mb-0 font-12 text-muted">
                        {{ number_format($veiculo->documentos->size_proc / 1024, 2, ',', '.') }} KB
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_proc) }}" download class="btn btn-link btn-sm text-muted">
                        <i class="mdi mdi-download font-18"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center bg-light-lighten border border-dashed rounded p-2">
            <span class="text-muted font-12 italic">Arquivo não gerado</span>
            <span class="badge bg-soft-secondary text-secondary border border-secondary">N/A</span>
        </div>
    @endif
</li>

    <li class="list-group-item bg-transparent py-3">
    <div class="d-flex align-items-center mb-2">
        <i class="mdi mdi-file-send-outline me-2 font-18 text-muted"></i>
        <div>
            <span class="fw-medium d-block">Solicitação ATPVe</span>
            <small class="text-muted">Intenção de venda e transferência</small>
        </div>
    </div>

    @if($veiculo->documentos && $veiculo->documentos->arquivo_atpve)
        <div class="shadow-none border rounded p-2 bg-white">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light bg-soft-danger text-danger rounded">
                            <i class="mdi mdi-file-pdf-box font-24"></i>
                        </span>
                    </div>
                </div>
                <div class="col ps-0 text-start">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_atpve) }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->documentos->arquivo_atpve) }}">
                        {{ basename($veiculo->documentos->arquivo_atpve) }}
                    </a>
                    <p class="mb-0 font-12 text-muted">
                        {{ number_format($veiculo->documentos->size_atpve / 1024, 2, ',', '.') }} KB
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ asset('storage/' . $veiculo->documentos->arquivo_atpve) }}" download class="btn btn-link btn-sm text-muted">
                        <i class="mdi mdi-download font-18"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between align-items-center bg-light-lighten border border-dashed rounded p-2">
            <span class="text-muted font-12 italic">Documento não gerado</span>
            <span class="badge bg-soft-secondary text-secondary border border-secondary">N/A</span>
        </div>
    @endif
</li>
</ul>
        </div>
    </div>
</div>

                </div> </div> </div> </div> </div>
@endsection