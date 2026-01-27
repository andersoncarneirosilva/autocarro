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
</div>

                <div class="tab-content">
                    
                    <div class="tab-pane show active" id="info-geral">
                        <div class="row">
                            <div class="col-md-8 px-md-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0">
                    <i class="mdi mdi-car-info me-1"></i> Informações do veículo
                </h4>
                <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#modalEditarInfoVeiculo">
                    <i class="mdi mdi-sync me-1"></i> Atualizar Dados
                </button>
            </div>

                                <div class="row g-0">
    <div class="col-md-5 pe-md-4">
        <div class="mb-3">
            <small class="text-muted fw-bold text-uppercase font-11 tracking-wider">Veículo</small>
            <h4 class="mt-1 mb-0 text-primary">{{ $veiculo->marca }}</h4>
            <h5 class="mt-1 mb-1 text-dark">{{ $veiculo->modelo }}</h5>
            <p class="text-muted font-14 mb-0">{{ $veiculo->versao }}</p>
        </div>
        
        <div class="d-flex gap-2 mt-3">
            <span class="badge bg-primary-lighten text-primary px-2 py-1">
                <i class="mdi mdi-calendar me-1"></i>{{ $veiculo->ano }}
            </span>
            <span class="badge bg-light text-secondary px-2 py-1 border">
                <i class="mdi mdi-gas-station me-1"></i>{{ $veiculo->combustivel }}
            </span>
        </div>
    </div>

    <div class="col-md-7 border-start-md ps-md-4">
        <div class="row row-cols-2 g-3">
            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Placa</small>
                <span class="font-15 fw-semibold text-dark">{{ $veiculo->placa }}</span>
                @if($veiculo->placaAnterior)
                    <div class="text-muted font-11">Ant: {{ $veiculo->placaAnterior }}</div>
                @endif
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Cor</small>
                <span class="font-15 fw-semibold text-dark">
                    <i class="mdi mdi-palette-outline me-1 text-muted"></i>{{ $veiculo->cor }}
                </span>
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Renavam</small>
                <span class="font-14 text-dark">{{ $veiculo->renavam ?? '---' }}</span>
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Motor</small>
                <span class="font-14 text-dark text-truncate d-block">{{ $veiculo->motor ?? '---' }}</span>
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Tipo / Categoria</small>
                <span class="font-14 text-dark">{{ $veiculo->tipo }} / {{ $veiculo->categoria }}</span>
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Número CRV</small>
                <span class="font-14 text-dark">{{ $veiculo->crv ?? '---' }}</span>
            </div>
        </div>
    </div>
</div>

<style>
    .font-11 { font-size: 11px; }
    .font-14 { font-size: 14px; }
    .font-15 { font-size: 15px; }
    .tracking-wider { letter-spacing: 0.05em; }
    
    .border-start-md {
        border-left: 1px solid #f1f3fa;
    }

    .bg-primary-lighten {
        background-color: rgba(114, 124, 245, 0.1);
    }

    @media (max-width: 767.98px) {
        .border-start-md {
            border-left: none;
            border-top: 1px solid #f1f3fa;
            margin-top: 20px;
            padding-top: 20px;
        }
    }
</style>
                                <hr>

                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0">
                    <i class="mdi mdi-car-info me-1"></i> Informações básicas
                </h4>
                <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#modalEditarInfoBasica">
                    <i class="mdi mdi-sync me-1"></i> Atualizar Dados
                </button>
            </div>
            <div class="row g-0">
    <div class="col-md-5 pe-md-4">
        <div class="mb-3">
            <small class="text-muted fw-bold text-uppercase font-11 tracking-wider">Uso e Transmissão</small>
            <div class="d-flex align-items-center mt-2">
                <div class="me-3">
                    <small class="text-muted d-block font-11 text-uppercase">Câmbio</small>
                    <h5 class="m-0 text-dark font-15">
                        <i class="mdi mdi-car-shift-lever me-1 text-primary"></i>{{ $veiculo->cambio ?? 'N/A' }}
                    </h5>
                </div>
                <div>
                    <small class="text-muted d-block font-11 text-uppercase">Kilometragem</small>
                    <h5 class="m-0 text-dark font-15">
                        <i class="mdi mdi-speedometer me-1 text-primary"></i>{{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7 border-start-md ps-md-4">
        <div class="row row-cols-2 g-3">
            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Estrutura</small>
                @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA' || strtoupper($veiculo->tipo) == 'MOTO')
                    <span class="badge bg-light text-muted border font-11">Não aplicável (Moto)</span>
                @else
                    <span class="font-15 fw-semibold text-dark">
                        <i class="mdi mdi-car-door me-1 text-muted"></i>{{ $veiculo->portas ?? '---' }} Portas
                    </span>
                @endif
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Condição Especial</small>
                @if($veiculo->especiais)
                    <span class="badge badge-soft-warning font-12 text-uppercase">{{ $veiculo->especiais }}</span>
                @else
                    <span class="font-14 text-muted italic">Nenhuma informada</span>
                @endif
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Opcionais</small>
                <span class="font-14 text-dark">{{ $veiculo->opcionais_count ?? 0 }} itens</span>
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Status</small>
                <span class="badge bg-success-lighten text-success">{{ $veiculo->status }}</span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reaproveitando os estilos para manter consistência no Alcecar */
    .font-11 { font-size: 11px; }
    .font-12 { font-size: 12px; }
    .font-14 { font-size: 14px; }
    .font-15 { font-size: 15px; }
    .tracking-wider { letter-spacing: 0.05em; }
    
    .border-start-md {
        border-left: 1px solid #f1f3fa;
    }

    .badge-soft-warning {
        background-color: rgba(249, 188, 80, 0.15);
        color: #f9bc50;
    }
    
    .bg-success-lighten {
        background-color: rgba(10, 207, 151, 0.1);
    }

    @media (max-width: 767.98px) {
        .border-start-md {
            border-left: none;
            border-top: 1px solid #f1f3fa;
            margin-top: 20px;
            padding-top: 20px;
        }
    }
</style>
            <hr>

            @if($veiculo->nome)
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
            @endif
                            </div>

                            <div class="col-md-4 border-start">
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="header-title text-primary mb-0">Foto Principal</h4>
            <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#modalUploadFotos">
                <i class="mdi mdi-camera-plus me-1"></i> Fotos
            </button>
        </div>
        
        @php $imagens = json_decode($veiculo->images); @endphp
                            
        <div class="position-relative border rounded p-1 bg-white shadow-sm">
            @if(!empty($imagens))
                <div id="carouselVeiculo" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
                    <div class="carousel-inner">
                        @foreach($imagens as $key => $img)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 rounded" style="max-height: 400px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Mostra setas do carrossel apenas se houver mais de uma foto --}}
                    @if(count($imagens) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="mdi mdi-image-off text-muted font-24"></i>
                </div>
            @endif
        </div>
    </div>

    {{-- Galeria de Miniaturas --}}
    <div class="mt-3">
        <h5 class="font-14 mb-2 text-muted">Galeria de Imagens</h5>
        
        <div class="position-relative d-flex align-items-center">
            {{-- Seta Esquerda da Galeria --}}
            @if(!empty($imagens) && count($imagens) > 1)
                <button class="btn btn-sm btn-light shadow-sm position-absolute start-0 z-index-1 d-none d-md-block" 
                        onclick="document.getElementById('thumb-scroll').scrollBy({left: -100, behavior: 'smooth'})"
                        style="left: -10px !important; border-radius: 50%; width: 30px; height: 30px; padding: 0;">
                    <i class="mdi mdi-chevron-left"></i>
                </button>
            @endif

            <div id="thumb-scroll" class="d-flex flex-nowrap g-2 overflow-hidden px-1" 
                 style="overflow-x: auto; scroll-behavior: smooth; gap: 8px; -ms-overflow-style: none; scrollbar-width: none;">
                
                @if(!empty($imagens))
                    @foreach($imagens as $key => $img)
                        <div style="min-width: 80px; flex: 0 0 auto;">
                            <div class="border rounded p-1 cursor-pointer thumbnail-wrapper" 
                                 onclick="$('#carouselVeiculo').carousel({{ $key }})"
                                 style="cursor: pointer; transition: all 0.2s ease;">
                                <img src="{{ asset('storage/' . $img) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="height: 50px; width: 100%; object-fit: cover;"
                                     alt="Miniatura {{ $key + 1 }}">
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted font-13 italic mb-0">Nenhuma miniatura.</p>
                @endif
            </div>

            {{-- Seta Direita da Galeria --}}
            @if(!empty($imagens) && count($imagens) > 1)
                <button class="btn btn-sm btn-light shadow-sm position-absolute end-0 z-index-1 d-none d-md-block" 
                        onclick="document.getElementById('thumb-scroll').scrollBy({left: 100, behavior: 'smooth'})"
                        style="right: -10px !important; border-radius: 50%; width: 30px; height: 30px; padding: 0;">
                    <i class="mdi mdi-chevron-right"></i>
                </button>
            @endif
        </div>
    </div>
</div>
<style>
    /* Esconde a barra de rolagem mas mantém a funcionalidade */
    #thumb-scroll::-webkit-scrollbar {
        display: none;
    }

    .thumbnail-wrapper:hover {
        border-color: #727cf5 !important;
        transform: scale(1.05);
    }

    .z-index-1 {
        z-index: 10;
    }
</style>




                        </div>
                    </div>

                    <div class="tab-pane" id="fotos-desc">
    <div class="row">
        <div class="col-md-12 px-md-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0 text-uppercase" style="letter-spacing: 1px;">
                    Descrição do Anúncio
                </h4>
                <button type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#modalDescricao">
                    <i class="mdi mdi-pencil me-1"></i> Atualizar descrição
                </button>
            </div>
            
            <div class="border p-4 rounded bg-white shadow-none" style="min-height: 150px;">
                <div class="text-muted" style="white-space: pre-wrap; line-height: 1.6; font-size: 14px;">{{ trim($veiculo->observacoes) ?: 'Nenhuma observação cadastrada.' }}</div>
            </div>
        </div>
    </div>
</div>

                    <div class="tab-pane" id="opcionais-tab">
                        <div class="row">
                            <div class="col-md-4 px-md-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-primary"><i class="mdi mdi-plus-box-outline me-1"></i> Adicionais</h5>
                                    @php
                                        $listaAdicionais = is_array($veiculo->adicionais) ? $veiculo->adicionais : json_decode($veiculo->adicionais, true);
                                    @endphp

                                    @if(is_array($listaAdicionais) && count($listaAdicionais) > 0)
                                        {{-- Caso já existam itens cadastrados --}}
                                        <button class="btn btn-xs btn-outline-primary  px-3" data-bs-toggle="modal" data-bs-target="#modalAdicionais">
                                            <i class="mdi mdi-pencil me-1"></i> Atualizar adicionais
                                        </button>
                                    @else
                                        {{-- Caso esteja vazio [], null ou string vazia --}}
                                        <button class="btn btn-xs btn-primary  px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionais">
                                            <i class="mdi mdi-plus me-1"></i> Adicionar adicionais
                                        </button>
                                    @endif
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
                                    
                                @php
                                    $listaOpcionais = is_array($veiculo->opcionais) ? $veiculo->opcionais : json_decode($veiculo->opcionais, true);
                                @endphp

                                    @if(is_array($listaOpcionais) && count($listaOpcionais) > 0)
                                        {{-- Se o array tem itens, o botão é de ATUALIZAR --}}
                                        <button class="btn btn-xs btn-outline-primary  px-3" data-bs-toggle="modal" data-bs-target="#modalOpcionais">
                                            <i class="mdi mdi-pencil me-1"></i> Atualizar opcionais
                                        </button>
                                    @else
                                        {{-- Se for vazio [], null ou string vazia, o botão é de ADICIONAR --}}
                                        <button class="btn btn-xs btn-primary  px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalOpcionais">
                                            <i class="mdi mdi-plus me-1"></i> Adicionar opcionais
                                        </button>
                                    @endif

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
        @php
            $listaModificacoes = is_array($veiculo->modificacoes) ? $veiculo->modificacoes : json_decode($veiculo->modificacoes, true);
        @endphp

        @if(is_array($listaModificacoes) && count($listaModificacoes) > 0)
            {{-- Se já existem modificações registradas --}}
            <button class="btn btn-xs btn-outline-primary  px-3" data-bs-toggle="modal" data-bs-target="#modalModificacoes">
                <i class="mdi mdi-pencil me-1"></i> Atualizar modificações
            </button>
        @else
            {{-- Se estiver vazio [], null ou string vazia --}}
            <button class="btn btn-xs btn-primary  px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalModificacoes">
                <i class="mdi mdi-plus me-1"></i> Adicionar modificações
            </button>
        @endif
    </div>
    <div class="d-flex flex-wrap gap-2 p-2 border rounded min-height-100 bg-light-lighten">
        @forelse(json_decode($veiculo->modificacoes) ?? [] as $mod)
            <span class="badge badge-outline-secondary px-2 py-1 fw-normal" style="font-size: 13px;">
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
        <div class="col-md-12 px-md-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-primary mb-0"><i class="mdi mdi-file me-1"></i> Documentos</h5>
                
                <button type="button" class="btn btn-outline-primary btn-xs " data-bs-toggle="modal" data-bs-target="#modalGerarDocs">
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
                    <a href="{{ asset('storage/' . $veiculo->arquivo_doc) }}" target="_blank" class="text-muted fw-bold d-block text-truncate font-13" title="{{ basename($veiculo->arquivo_doc) }}">
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

                </div> </div> </div> 
                
            <div class="row">
    <div class="col-md-4">
    <div class="card widget-flat border-primary border">
        <div class="card-body">
            <div class="float-end">
                <i class="mdi mdi-currency-usd widget-icon bg-primary-lighten text-primary"></i>
            </div>
            
            <h5 class="text-muted fw-normal mt-0" title="Preço base de venda">Valor de Venda</h5>
            <h3 class="mt-3 mb-2">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h3>
            
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0 text-muted">
                    <span class="text-nowrap">Preço de vitrine</span>
                </p>
                <button type="button" class="btn btn-link btn-sm text-primary p-0" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">
                    <i class="mdi mdi-pencil"></i> Atualizar
                </button>
            </div>
        </div>
    </div>
</div>

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
        @if($dadosFipe)
            <div class="card widget-flat border-success border">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-calculator widget-icon bg-success-lighten text-success"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="{{ $dadosFipe['referenceMonth'] }}">Tabela FIPE</h5>
                    <h3 class="mt-3 mb-2 text-success">{{ $dadosFipe['price'] }}</h3>
                    <p class="mb-0 text-muted">
                        @php
                            $valorVenda = $veiculo->valor_oferta > 0 ? $veiculo->valor_oferta : $veiculo->valor;
                            $valorFipe = (float) str_replace(['R$', '.', ','], ['', '', '.'], $dadosFipe['price']);
                            $diff = $valorVenda - $valorFipe;
                            $percent = ($diff / $valorFipe) * 100;
                        @endphp
                        <span class="{{ $diff > 0 ? 'text-danger' : 'text-success' }} me-2">
                            <i class="mdi {{ $diff > 0 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i> 
                            {{ number_format(abs($percent), 1) }}% vs FIPE
                        </span>
                    </p>
                </div>
            </div>
        @else
            <div class="card widget-flat border-secondary border">
                <div class="card-body">
                    <div class="float-end">
                        <i class="mdi mdi-alert-circle-outline widget-icon bg-secondary-lighten text-secondary"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0">Tabela FIPE</h5>
                    <h3 class="mt-3 mb-2 text-muted">FIPE não encontrada</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap">Atualize a Marca, Modelo e versão do veículo</span>
                    </p>
                </div>
            </div>
        @endif
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

</div> </div>
@endsection