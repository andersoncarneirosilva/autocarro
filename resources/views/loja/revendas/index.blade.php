@extends('loja.layout.app')

@section('content')


<div class="revendas-page" style="margin-top: 100px;">
    <div class="container mb-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold display-6">Revendas Parceiras</h2>
            <p class="text-muted">Conheça as lojas que são parceiras da <strong>Alcecar</strong>.</p>
        </div>

        <div class="row g-4">
            @forelse($revendas as $revenda)
    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
        <a href="{{ route('revenda.publica', $revenda->slug) }}" class="text-decoration-none">
            <div class="card-revenda-premium">
                {{-- Área da Logo --}}
                <div class="logo-container">
                    @if($revenda->logo)
                        <img src="{{ asset('storage/' . $revenda->logo) }}" alt="{{ $revenda->nome }}">
                    @else
                        <div class="placeholder-logo">{{ substr($revenda->nome, 0, 1) }}</div>
                    @endif
                </div>

                {{-- Informações Detalhadas --}}
                <div class="info-container p-4 text-center">
                    <h4 class="store-title mb-1">{{ $revenda->nome }}</h4>
                    
                    <div class="location-details mb-3">
                        {{-- Endereço e Bairro --}}
                        <p class="address-text mb-1">
                            {{ $revenda->rua }},{{ $revenda->numero }}{{ $revenda->bairro ? ', ' . $revenda->bairro : '' }}
                        </p>
                        {{-- Cidade e Estado --}}
                        <p class="city-text text-muted small">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                            {{ $revenda->cidade }} - {{ $revenda->estado }}
                        </p>
                    </div>

                    <div class="d-grid">
                        <span class="btn-ver-estoque">Ver Estoque Completo</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <div class="empty-state-card p-5">
            <i class="bi bi-shop fs-1 text-muted opacity-50"></i>
            <p class="text-muted mt-3">Nenhuma revenda cadastrada no momento.</p>
        </div>
    </div>
@endforelse
        </div>
    </div>
</div>
<style>
    .card-revenda-premium {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 4px;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-revenda-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.07);
        border-color: #b32d2d;
    }

    .logo-container {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        padding: 25px;
        border-bottom: 1px solid #f8f8f8;
    }

    .logo-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .store-title {
        font-family: 'Raleway', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.5px;
    }

    .address-text {
        font-size: 0.85rem;
        color: #555;
        font-weight: 500;
        line-height: 1.3;
    }

    .city-text {
        letter-spacing: 0.5px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem !important;
    }

    .btn-ver-estoque {
        display: block;
        padding: 10px;
        border: 1.5px solid #111;
        color: #111;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: 0.3s;
    }

    .card-revenda-premium:hover .btn-ver-estoque {
        background: #111;
        color: #fff;
    }

    .placeholder-logo {
        width: 70px;
        height: 70px;
        background: #111;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        border-radius: 50%;
    }
</style>
@endsection