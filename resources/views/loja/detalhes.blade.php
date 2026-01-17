@extends('loja.layout.app')

@section('title', 'Veículos')

@section('content')

    <div class="page-title" style="min-height: 320px; background-image: url('{{ $veiculo->background_image }}'); background-size: cover; background-position: center; position: relative;" data-aos="fade">
    
    <div class="heading-overlay" style="
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Ajuste o 0.6 para mais ou menos escuridão */
        z-index: 1;">
    </div>

    <div class="heading" style="position: relative; z-index: 2; padding-top: 80px;">
        <div class="container position-relative">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 text-white">
                    <h1 class="fw-bold">{{ $veiculo->marca_exibicao }}</h1>
                    <p class="lead">{{ $veiculo->modelo_exibicao }}</p>
                </div>
            </div>
        </div>
    </div>

    <nav class="breadcrumbs" style="position: relative; z-index: 2;">
    <div class="container">
        <ol>
            <li><a href="{{ route('loja.index') }}">Página Inicial</a></li>
            
            @php
                // Normaliza o estado para evitar erros de digitação (ex: "novo" vira "Novos")
                $estado = mb_strtolower($veiculo->estado);
                
                if (str_contains($estado, 'novo') && !str_contains($estado, 'semi')) {
                    $rota = route('veiculos.novos');
                    $label = 'Novos';
                } elseif (str_contains($estado, 'semi')) {
                    $rota = route('veiculos.semi-novos');
                    $label = 'Semi-novos';
                } else {
                    $rota = route('veiculos.usados');
                    $label = 'Usados';
                }
            @endphp

            <li><a href="{{ $rota }}">{{ $label }}</a></li>
            <li class="current">{{ $veiculo->modelo_exibicao }}</li>
        </ol>
    </div>
</nav>
</div>

{{-- {{ $veiculo->background_image }} --}}

<section class="container py-5 mt-5">
    
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $veiculo->marca_exibicao }}</h2>
        <p>{{ $veiculo->modelo_exibicao }}<br></p>
    </div>


    <div class="row g-4">
    <div class="col-lg-7">
        <div class="row g-2">
            <div class="{{ count($veiculo->images) > 1 ? 'col-lg-10 col-12' : 'col-12' }}">
                <div id="carouselDetalhes" class="carousel slide shadow-sm rounded-1 overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($veiculo->images as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100" style="height: 460px; object-fit: cover;" alt="{{ $veiculo->marca }}">
                            </div>
                        @endforeach
                    </div>
                    
                    @if(count($veiculo->images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetalhes" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" style="width: 2rem; height: 2rem;"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselDetalhes" data-bs-slide="next">
                            <span class="carousel-control-next-icon" style="width: 2rem; height: 2rem;"></span>
                        </button>
                    @endif
                </div>
            </div>

            @if(count($veiculo->images) > 1)
                <div class="col-2 d-none d-lg-block">
                    <div class="d-flex flex-column gap-2 overflow-auto hide-scrollbar" style="max-height: 460px;">
                        @foreach($veiculo->images as $index => $img)
                            <div class="position-relative overflow-hidden rounded-1" style="aspect-ratio: 1/1;">
                                <img src="{{ asset('storage/' . $img) }}" 
                                     class="w-100 h-100 border-0 img-thumbnail-custom" 
                                     style="object-fit: cover; cursor: pointer; filter: grayscale(20%);" 
                                     onclick="bootstrap.Carousel.getInstance(document.getElementById('carouselDetalhes')).to({{ $index }})"
                                     alt="Miniatura">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-5">
        <div class="p-4 p-xl-5 bg-white border rounded-1 h-100 d-flex flex-column shadow-sm">
            <header class="mb-auto">
    <nav aria-label="breadcrumb" class="mb-3">
        <span class="text-uppercase text-muted fw-semibold" style="font-size: 0.65rem; letter-spacing: 1.5px;">Estoque Disponível</span>
    </nav>

    <h1 class="h3 mb-1 text-dark fw-bold" style="letter-spacing: -0.02em;">
        {{ $veiculo->marca_exibicao }} {{ $veiculo->modelo_exibicao }}
    </h1>
    
    <div class="d-flex align-items-center gap-3 text-secondary mb-4 pb-2 border-bottom">
    @if($veiculo->ano)
        <span class="small {{ ($veiculo->kilometragem || $veiculo->cambio) ? 'border-end pe-3' : '' }} text-uppercase fw-medium">
            <i class="bi bi-calendar3 me-2"></i>{{ $veiculo->ano }}
        </span>
    @endif

    @if($veiculo->kilometragem !== null)
        <span class="small {{ $veiculo->cambio ? 'border-end pe-3' : '' }} fw-medium">
            <i class="bi bi-speedometer2 me-2"></i>
            {{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM
        </span>
    @endif

    @if($veiculo->cambio)
        <span class="small text-uppercase fw-medium">
            <i class="bi bi-gear-wide-connected me-2"></i>
            {{ $veiculo->cambio }}
        </span>
    @endif
</div>

    <div class="price-section my-4">
        @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
            <span class="text-muted text-decoration-line-through small d-block mb-1">Valor de tabela: R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</span>
            <h2 class="h1 fw-bold text-dark mb-0">
                R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}
            </h2>
        @else
            <span class="text-muted small d-block mb-1 text-uppercase fw-semibold" style="letter-spacing: 1px;">Preço de Venda</span>
            <h2 class="h1 fw-bold text-dark mb-0">
                R$ {{ number_format($veiculo->valor, 2, ',', '.') }}
            </h2>
        @endif
    </div>

    @if($veiculo->exibir_parcelamento && $veiculo->qtd_parcelas > 1)
        @php
            $totalFinanciado = (float)$veiculo->qtd_parcelas * (float)$veiculo->valor_parcela;
            $custoJuros = round($totalFinanciado - (float)$veiculo->valor, 2);
            $possuiJuros = $custoJuros > 0.05; // Margem de erro para arredondamento
        @endphp

        <div class="p-3 border rounded-1 bg-light-subtle shadow-sm mb-4" style="border-style: dashed !important; border-color: #dee2e6 !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-uppercase fw-bold text-muted" style="font-size: 0.6rem; letter-spacing: 0.5px;">Sugestão de Parcelamento</span>
                @if(!$possuiJuros)
                    <span class="badge bg-success-subtle text-success border border-success-subtle text-uppercase" style="font-size: 0.55rem;">Taxa Zero</span>
                @endif
            </div>

            <div class="d-flex align-items-baseline gap-2">
                <h4 class="fw-bold mb-0 text-dark">{{ $veiculo->qtd_parcelas }}x</h4>
                <span class="text-muted small">de</span>
                <h4 class="fw-bold mb-0 text-primary">R$ {{ number_format($veiculo->valor_parcela, 2, ',', '.') }}</h4>
            </div>

            <div class="mt-2 pt-2 border-top border-white-50">
                <div class="d-flex justify-content-between align-items-center" style="font-size: 0.72rem;">
                    <span class="text-muted">Total a prazo: <strong>R$ {{ number_format($totalFinanciado, 2, ',', '.') }}</strong></span>
                    @if($possuiJuros)
                        <span class="text-danger fw-medium">+ R$ {{ number_format($custoJuros, 2, ',', '.') }} juros</span>
                    @endif
                </div>
                <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">
                    Simulação baseada em taxa de {{ number_format($veiculo->taxa_juros, 2, ',', '.') }}% a.m.
                </small>
            </div>
        </div>
    @endif
</header>

            <footer class="mt-4 mt-lg-5">
                <div class="d-grid gap-2">
                    <a href="https://wa.me/5554997007847?text=Olá, tenho interesse no {{ $veiculo->marca }} {{ $veiculo->ano }}"
                    target="_blank"
                    class="btn btn-accent btn-lg py-3 fw-semibold shadow-none rounded-1 d-flex align-items-center justify-content-center">

                        <i class="bi bi-whatsapp me-2"></i>
                        Solicitar Proposta
                    </a>

                    
                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <button class="btn btn-outline-secondary btn-sm w-100 py-2 text-uppercase fw-bold rounded-1 border-light-subtle" style="font-size: 0.7rem;">
                                <i class="bi bi-geo-alt me-1"></i> Loja
                            </button>
                        </div>
                        <div class="col-6">
                            <a
    href="https://wa.me/?text={{ urlencode(
        'Olá! Confira este veículo: ' .
        $veiculo->marca_exibicao . ' ' .
        $veiculo->modelo_exibicao . ' - ' .
        url()->current()
    ) }}"
    target="_blank"
    class="btn btn-outline-secondary btn-sm w-100 py-2 text-uppercase fw-bold rounded-1 border-light-subtle"
    style="font-size: 0.7rem;"
>
    <i class="bi bi-whatsapp me-1"></i> Enviar
</a>

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .img-thumbnail-custom {
        transition: transform 0.4s ease, filter 0.4s ease;
    }
    
    .img-thumbnail-custom:hover {
        transform: scale(1.1);
        filter: grayscale(0%) !important;
    }

    .fw-bold { font-weight: 700 !important; }
    .fw-semibold { font-weight: 600 !important; }
    
    /* Botão preto sólido para um ar mais executivo */
    .btn-dark:hover {
        background-color: #333 !important;
        transform: none;
    }
</style>

    <div class="mt-4 p-4 bg-white shadow-sm rounded border">
        <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2 text-red">Ficha Técnica</h5>
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-speedometer2 fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Kilometragem</small><span class="fw-bold">{{ number_format($veiculo->kilometragem, 0, ',', '.') }} km</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar3 fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Ano/Modelo</small><span class="fw-bold">{{ $veiculo->ano }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-card-text fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Final da Placa</small><span class="fw-bold">{{ substr($veiculo->placa, -1) }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
    <i class="bi bi-door-closed fs-3 text-red me-3"></i>
    <div>
        <small class="text-muted d-block">Nº Portas</small>
        <span class="fw-bold">
            @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA' || empty($veiculo->portas))
                <span class="fw-bold text-capitalize">Não aplicável</span>
            @else
                {{ $veiculo->portas }} Portas
            @endif
        </span>
    </div>
</div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-fuel-pump fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Combustível</small><span class="fw-bold text-capitalize">{{ strtolower($veiculo->combustivel) }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-palette fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Cor</small><span class="fw-bold text-capitalize">{{ strtolower($veiculo->cor) }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-gear-wide-connected fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Câmbio</small><span class="fw-bold">{{ $veiculo->cambio }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-car-front fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Carroceria</small><span class="fw-bold text-capitalize">{{ strtolower($veiculo->tipo) }}</span></div>
                </div>
            </div>
        </div>
    </div>

    @php 
        $adicionais = is_array($veiculo->adicionais) ? $veiculo->adicionais : json_decode($veiculo->adicionais, true);
        if(is_string($adicionais)) $adicionais = json_decode($adicionais, true);
    @endphp
    @if(!empty($adicionais))
    <div class="mt-4 p-4 bg-white shadow-sm rounded border-start border-primary border-4">
        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-info-square fs-6"></i> Adicionais</h5>
        <div class="row">
            @foreach($adicionais as $item)
                <div class="col-md-3 col-6 mb-2">
                    <i class="bi bi-dot text-red fs-6"></i> {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @php 
        $opcionais = is_array($veiculo->opcionais) ? $veiculo->opcionais : json_decode($veiculo->opcionais, true);
        if(is_string($opcionais)) $opcionais = json_decode($opcionais, true);
    @endphp
    @if(!empty($opcionais))
    <div class="mt-4 p-4 bg-white shadow-sm rounded border-start border-success border-4">
        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-plus-circle fs-6"></i> Opcionais e Equipamentos</h5>
        <div class="row">
            @foreach($opcionais as $item)
                <div class="col-md-3 col-6 mb-2">
                    <i class="bi bi-dot text-red fs-6"></i> {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @php 
        $modificacoes = is_array($veiculo->modificacoes) ? $veiculo->modificacoes : json_decode($veiculo->modificacoes, true);
        if(is_string($modificacoes)) $modificacoes = json_decode($modificacoes, true);
    @endphp
    @if(!empty($modificacoes))
    <div class="mt-4 p-4 bg-white shadow-sm rounded border-start border-danger border-4">
        <h5 class="fw-bold mb-3 text-secondary">
    <i class="bi bi-tools fs-6"></i> Modificações / Upgrades
</h5>
        <div class="row">
            @foreach($modificacoes as $item)
                <div class="col-md-3 col-6 mb-2">
                    <i class="bi bi-dot text-red fs-6"></i> {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mt-4 p-4 bg-white shadow-sm rounded border">
        <h4 class="fw-bold border-bottom pb-2">Descrição Detalhada</h4>
        <p class="text-muted mt-3" style="white-space: pre-line; line-height: 1.8;">
            {{ $veiculo->observacoes ?? $veiculo->descricao ?? 'Nenhuma informação adicional fornecida.' }}
        </p>
    </div>

</section>

@endsection