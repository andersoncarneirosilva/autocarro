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
                        <i class="mdi mdi-car-shift-pattern me-1 text-primary"></i>{{ $veiculo->cambio ?? 'N/A' }}
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
    @if(!empty($veiculo->portas))
        <span class="font-15 fw-semibold text-dark">
            <i class="mdi mdi-car-door me-1 text-primary"></i>{{ $veiculo->portas }} Portas
        </span>
    @else
        <span class="font-14 text-muted italic">Não informado</span>
    @endif
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
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="header-title mb-3 text-primary"><i class="mdi mdi-card-account-details-outline me-1"></i> Informações do Proprietário</h4>
                
            </div>
            
            <div class="row g-0">
    <div class="col-md-5 pe-md-4">
        <div class="mb-2">
            <small class="text-muted fw-bold text-uppercase font-11 tracking-wider">Proprietário Atual</small>
            <div class="d-flex align-items-center mt-2">
                <div class="bg-primary-lighten text-primary rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="mdi mdi-account font-18"></i>
                </div>
                <h5 class="m-0 text-dark font-15 fw-bold text-truncate" title="{{ $veiculo->nome ?? 'Não informado' }}">
                    {{ $veiculo->nome ?? 'Não informado' }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-7 border-start-md ps-md-4">
        <div class="row row-cols-2 g-3">
            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Cidade / UF</small>
                <span class="font-14 text-dark">
                    <i class="mdi mdi-map-marker-outline me-1 text-muted"></i>{{ $veiculo->cidade ?? 'Não informado' }}
                </span>
            </div>

            <div class="col">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">CPF / CNPJ</small>
                <span class="font-14 text-dark">
                    <i class="mdi mdi-card-account-details-outline me-1 text-muted"></i>{{ $veiculo->cpf ?? '---' }}
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos consistentes com os blocos anteriores */
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