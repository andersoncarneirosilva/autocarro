@extends('loja.layout.app')

@section('title', $veiculo->marca_exibicao . ' ' . $veiculo->modelo_exibicao)

@section('content')
<style>
    :root {
        --nc-accent: #ff4a17;
        --nc-bg-light: #f8f9fa;
    }

    /* Galeria */
/* Container geral */
.carousel-main-container {
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

/* Apenas o carousel deve cortar */
#carouselDetalhes {
    overflow: hidden;
    border-radius: 15px;
}


/* Miniaturas */
.img-thumbnail-nav {
    width: 100px;
    aspect-ratio: 4 / 3;
    object-fit: cover;
    cursor: pointer;
    border-radius: 10px;
    border: 2px solid transparent;
    transition: transform 0.2s ease, opacity 0.2s ease;
    opacity: 0.7;
    flex-shrink: 0;

    /* 🔥 garante que o scale seja centrado */
    transform-origin: center;
}


.img-thumbnail-nav.active,
.img-thumbnail-nav:hover {
    border-color: var(--nc-accent);
    opacity: 1;
    transform: scale(1.05);
}

/* Container das miniaturas */
.thumb-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    min-height: 80px;
    gap: 8px;
    padding: 6px 10px;
}




.thumb-container::-webkit-scrollbar {
    display: none;
}

/* Contador de fotos */
.photo-counter {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(0,0,0,0.6);
    color: white;
    padding: 2px 12px;
    border-radius: 20px;
    font-size: 12px;
    z-index: 10;
}



    /* Sidebar */
    .sticky-sidebar { position: sticky; top: 100px; }
    .card-contato { border-radius: 15px !important; border: 1px solid #e9ecef !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; }
    .btn-whatsapp-detail { background-color: var(--nc-accent); color: white; border: none; font-weight: 600; padding: 12px; transition: 0.3s; }
    .btn-whatsapp-detail:hover { background-color: #e63e0d; color: white; }
    .btn-outline-location { border: 1px solid #dee2e6; color: #333; font-weight: 600; padding: 12px; transition: 0.3s; }
    .btn-outline-location:hover { background-color: #f8f9fa; color: var(--nc-accent); border-color: var(--nc-accent); }

    /* Container da Ficha Técnica */
.specs-container {
    border: 1px solid #eee !important;
    border-radius: 12px !important;
    transition: all 0.3s ease;
}

/* Título da Seção */
.text-red {
    color: #ff4a17; /* Cor padrão que usamos anteriormente */
}

.specs-title {
    font-size: 0.9rem;
    letter-spacing: 1px;
    color: #333;
    position: relative;
}
/* Pequenos Cards Internos */
.spec-item {
    background-color: #ffffff;
    border: 1px solid #f0f0f0; /* Borda sutil para o card interno */
    border-radius: 10px;
    padding: 12px;
    height: 100%; /* Garante que todos tenham a mesma altura na linha */
    transition: all 0.2s ease-in-out;
}

.spec-item:hover {
    border-color: #ff4a17; /* Destaca com a cor principal no hover */
    background-color: #fffaf9;
    transform: translateY(-2px); /* Pequeno efeito de levitação */
}

/* Ajuste dos ícones dentro dos mini cards */
.spec-item i {
    width: 42px;
    height: 42px;
    min-width: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: #ff4a17 !important;
    font-size: 1.2rem !important;
}

/* Tipografia */
.spec-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #888;
    display: block;
    line-height: 1;
    margin-bottom: 4px;
}

.spec-value {
    font-size: 0.85rem;
    color: #333;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsividade: ajuste para telas muito pequenas */
@media (max-width: 576px) {
    .spec-item i {
        font-size: 1.2rem !important;
        margin-right: 10px !important;
    }
    .spec-value {
        font-size: 0.85rem;
    }
}

/* Estilo para os Containers de Listas */
.info-card-custom {
    border: none !important;
    border-radius: 12px !important;
    background-color: #ffffff;
    transition: transform 0.2s;
}

.info-card-custom h5 {
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
}

/* Estilo dos Itens das Listas */
.list-item-custom {
    font-size: 0.85rem;
    color: #495057;
    padding: 4px 8px;
    display: flex;
    align-items: flex-start;
}

.list-item-custom i {
    color: #ff4a17; /* Laranja/Vermelho NetCarros */
    margin-right: 8px;
    font-size: 0.7rem;
    margin-top: 4px;
}

/* Borda lateral colorida suave */
.border-left-accent { border-left: 5px solid #ff4a17 !important; }
.border-left-blue   { border-left: 5px solid #0d6efd !important; }
.border-left-green  { border-left: 5px solid #198754 !important; }

/* Descrição */
.description-text {
    font-size: 0.95rem;
    color: #555;
    text-align: justify;
}

/* Reaproveitando o estilo da Ficha Técnica para as outras listas */
.spec-item.list-style i {
    background: #f1f3f5; /* Fundo cinza suave para opcionais */
    color: #6c757d !important;
    font-size: 1.1rem !important;
}

/* Cores específicas para os ícones de cada categoria */
.icon-adicionais i { background: #e7f1ff; color: #0d6efd !important; }
.icon-opcionais i { background: #eaf7ed; color: #198754 !important; }
.icon-upgrades i { background: #fff0eb; color: #ff4a17 !important; }

.spec-value-list {
    font-size: 0.85rem;
    font-weight: 600;
    color: #444;
}
.more-photos {
    display: flex;
    align-items: center;
    justify-content: center;

    background: rgba(0,0,0,0.6);
    color: #fff;
    font-weight: 600;
    font-size: 18px;

    /* 🔥 NÃO escala o card */
    transform: none !important;
}

.more-photos:hover {
    background: rgba(0,0,0,0.75);
}


</style>

<section class="container py-5 mt-5">
    <nav class="d-flex gap-2 small text-muted mt-4 mb-4 overflow-x-auto text-nowrap">
        <a href="/" class="text-decoration-none text-muted">Início</a> / 
        <a href="/comprar" class="text-decoration-none text-muted">Comprar</a> / 
        <span class="text-dark fw-medium">{{ $veiculo->marca_exibicao }} {{ $veiculo->modelo_exibicao }}</span>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            @php
    $maxThumbs = 7; // quantidade de miniaturas visíveis
    $totalImages = count($veiculo->images);
@endphp

            <div class="position-relative carousel-main-container mb-3">
                <div id="carouselDetalhes" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($veiculo->images as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100" style="height: 480px; object-fit: cover;" alt="Foto do veículo">
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="photo-counter">
                        <span id="current-photo">1</span> / {{ count($veiculo->images) }}
                    </div>

                    @if(count($veiculo->images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetalhes" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselDetalhes" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            </div>

            @if($totalImages > 1)
                <div class="thumb-container d-flex gap-2 py-2">

                    @foreach($veiculo->images as $index => $img)

                        {{-- Mostra apenas até o limite --}}
                        @if($index < $maxThumbs - 1)
                            <img src="{{ asset('storage/' . $img) }}"
                                class="img-thumbnail-nav {{ $index === 0 ? 'active' : '' }}"
                                onclick="bootstrap.Carousel.getOrCreateInstance(document.getElementById('carouselDetalhes')).to({{ $index }})"
                                alt="Miniatura {{ $index + 1 }}">

                        {{-- Último card com +N --}}
                        @elseif($index === $maxThumbs - 1)
                            <div class="img-thumbnail-nav more-photos"
                                onclick="bootstrap.Carousel.getOrCreateInstance(document.getElementById('carouselDetalhes')).to({{ $index }})">
                                +{{ $totalImages - ($maxThumbs - 1) }}
                            </div>
                            @break
                        @endif

                    @endforeach

                </div>
            @endif

            
            <div class="mt-4 p-4 bg-white specs-container shadow-sm border rounded-4">
    <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2 text-red specs-title" style="font-size: 0.9rem;">
        Ficha Técnica
    </h5>
    
    <div class="row g-3"> {{-- Espaçamento entre os pequenos cards --}}
        
        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-speedometer2 me-2"></i>
                <div>
                    <span class="spec-label">KM</span>
                    <span class="fw-bold spec-value">{{ number_format($veiculo->kilometragem, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-calendar3 me-2"></i>
                <div>
                    <span class="spec-label">Ano</span>
                    <span class="fw-bold spec-value">{{ $veiculo->ano }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-card-text me-2"></i>
                <div>
                    <span class="spec-label">Placa</span>
                    <span class="fw-bold spec-value">Final {{ substr($veiculo->placa, -1) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-door-closed me-2"></i>
                <div>
                    <span class="spec-label">Portas</span>
                    <span class="fw-bold spec-value">
                        @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA' || empty($veiculo->portas))
                            N/A
                        @else
                            {{ $veiculo->portas }} Portas
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-fuel-pump me-2"></i>
                <div>
                    <span class="spec-label">Combustível</span>
                    <span class="fw-bold spec-value text-capitalize">{{ strtolower($veiculo->combustivel) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-palette me-2"></i>
                <div>
                    <span class="spec-label">Cor</span>
                    <span class="fw-bold spec-value text-capitalize">{{ strtolower($veiculo->cor) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-gear-wide-connected me-2"></i>
                <div>
                    <span class="spec-label">Câmbio</span>
                    <span class="fw-bold spec-value">{{ $veiculo->cambio }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="d-flex align-items-center spec-item shadow-none">
                <i class="bi bi-car-front me-2"></i>
                <div>
                    <span class="spec-label">Tipo</span>
                    <span class="fw-bold spec-value text-capitalize">{{ strtolower($veiculo->tipo) }}</span>
                </div>
            </div>
        </div>

    </div>
</div>


            @php 
                $adicionais = collect(is_string($veiculo->adicionais) ? json_decode($veiculo->adicionais, true) : $veiculo->adicionais)->filter();
                $opcionais = collect(is_string($veiculo->opcionais) ? json_decode($veiculo->opcionais, true) : $veiculo->opcionais)->filter();
                $modificacoes = collect(is_string($veiculo->modificacoes) ? json_decode($veiculo->modificacoes, true) : $veiculo->modificacoes)->filter();
            @endphp

            {{-- Card: Adicionais --}}
            @if($adicionais->isNotEmpty())
            <div class="mt-4 p-4 bg-white specs-container shadow-sm border">
                <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2 specs-title">
                    <i class="bi bi-info-circle me-2"></i> Adicionais
                </h5>
                <div class="row g-3">
                    @foreach($adicionais as $item)
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center spec-item list-style icon-adicionais">
                                <i class="bi bi-patch-check me-2"></i>
                                <span class="spec-value-list">{{ $item }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Card: Opcionais e Equipamentos --}}
            @if($opcionais->isNotEmpty())
            <div class="mt-4 p-4 bg-white specs-container shadow-sm border">
                <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2 specs-title">
                    <i class="bi bi-plus-circle me-2"></i> Opcionais e Equipamentos
                </h5>
                <div class="row g-3">
                    @foreach($opcionais as $item)
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center spec-item list-style icon-opcionais">
                                <i class="bi bi-check2-all me-2"></i>
                                <span class="spec-value-list">{{ $item }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Card: Modificações / Upgrades --}}
            @if($modificacoes->isNotEmpty())
            <div class="mt-4 p-4 bg-white specs-container shadow-sm border">
                <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2 text-red specs-title">
                    <i class="bi bi-tools me-2"></i> Modificações e Upgrades
                </h5>
                <div class="row g-3">
                    @foreach($modificacoes as $item)
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center spec-item list-style icon-upgrades">
                                <i class="bi bi-lightning-charge me-2"></i>
                                <span class="spec-value-list">{{ $item }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Descrição Detalhada --}}
            <div class="mt-4 p-4 bg-white specs-container shadow-sm border">
                <h4 class="fw-bold border-bottom pb-2 specs-title text-uppercase">Descrição Detalhada</h4>
                <div class="mt-3 description-text" style="white-space: pre-line; line-height: 1.8;">
                    {!! nl2br(e($veiculo->observacoes ?? $veiculo->descricao ?? 'Nenhuma informação adicional fornecida.')) !!}
                </div>
            </div>



        </div>

        <div class="col-lg-5">
            <div class="sticky-sidebar">
                <div class="card card-contato p-4 bg-white">
                    <h1 class="h3 mb-2 text-dark fw-bold">{{ $veiculo->marca_exibicao }} {{ $veiculo->modelo_exibicao }}</h1>

                    <div class="d-flex align-items-center gap-3 text-secondary mb-4 pb-3 border-bottom">
                        @if($veiculo->ano)
                            <span class="small border-end pe-3 text-uppercase fw-medium"><i class="bi bi-calendar3 me-2"></i>{{ $veiculo->ano }}</span>
                        @endif
                        @if($veiculo->kilometragem !== null)
                            <span class="small border-end pe-3 fw-medium"><i class="bi bi-speedometer2 me-2"></i>{{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM</span>
                        @endif
                        @if($veiculo->cambio)
                            <span class="small text-uppercase fw-medium"><i class="bi bi-gear-wide-connected me-2"></i>{{ $veiculo->cambio }}</span>
                        @endif
                    </div>

                    <div class="price-section mb-4">
                        @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
                            <small class="text-muted text-decoration-line-through d-block">De: R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</small>
                            <h2 class="h1 fw-bold text-success mb-0">R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}</h2>
                        @else
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1px;">Preço de Venda</small>
                            <h2 class="h1 fw-bold text-dark mb-0">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h2>
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
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="https://wa.me/55{{ $veiculo->whatsapp }}" target="_blank" class="btn btn-whatsapp-detail w-100 rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-whatsapp me-2"></i> Proposta
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="https://maps.google.com/?q={{ urlencode($veiculo->unidade->endereco ?? 'Sua Loja Aqui') }}" target="_blank" class="btn btn-outline-location w-100 rounded-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-geo-alt me-2"></i> Onde Estamos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carouselEl = document.getElementById('carouselDetalhes');
        if (carouselEl) {
            const thumbnails = document.querySelectorAll('.img-thumbnail-nav');
            const counter = document.getElementById('current-photo');

            carouselEl.addEventListener('slide.bs.carousel', event => {
                thumbnails.forEach(t => t.classList.remove('active'));
                if(thumbnails[event.to]) thumbnails[event.to].classList.add('active');
                counter.innerText = event.to + 1;
            });
        }
    });
</script>
@endsection