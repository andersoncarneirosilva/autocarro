@forelse ($veiculos as $veiculo)
<div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
    <a class="premium-link-wrapper" href="{{ route('loja.veiculo.detalhes', ['slug_loja' => $veiculo->user->revenda->slug ?? 'particular', 'slug_veiculo' => $veiculo->slug]) }}">
        
        <div class="premium-vehicle-card">
            {{-- Header da Imagem --}}
            <div class="image-container">
                @php 
                    $imagens = is_array($veiculo->images) ? $veiculo->images : json_decode($veiculo->images, true) ?? [];
                    $imagemExibicao = count($imagens) ? asset('storage/' . $imagens[0]) : url('assets/img/default-car.png');
                @endphp
                <img src="{{ $imagemExibicao }}" alt="{{ $veiculo->modelo_exibicao }}" loading="lazy" class="card-img">
                
              
            </div>

            {{-- Corpo do Card --}}
            <div class="premium-body">
                <div class="brand-info">
                    <span class="brand-tag">{{ $veiculo->marca_real ?? $veiculo->marca }}</span>
                    <h3 class="model-name">{{ $veiculo->modelo_real ?? $veiculo->modelo }}</h3>
                    <p class="model-year">{{ $veiculo->ano }}</p>
                </div>

                {{-- Especificações Limpas --}}
                <div class="premium-specs">
                    <div class="spec-unit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg>
                        <span>{{ number_format($veiculo->kilometragem, 0, ',', '.') }} km</span>
                    </div>
                    <div class="spec-unit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 22V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v18"></path><path d="M14 13h2a2 2 0 0 1 2 2v2a2 2 0 0 0 2 2a2 2 0 0 0 2-2V9.83a2 2 0 0 0-.59-1.42L18 5"></path></svg>
                        <span>{{ $veiculo->combustivel }}</span>
                    </div>
                    <div class="spec-unit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path></svg>
                        <span>{{ $veiculo->cambio }}</span>
                    </div>
                </div>

                {{-- Footer do Card --}}
                <div class="premium-footer">
                    <div class="price-section">
                        @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
                            <span class="old-price-label">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</span>
                            <span class="current-price-label offer">R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}</span>
                        @else
                            <span class="current-price-label">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</span>
                        @endif
                    </div>
                    
                    <button class="premium-btn">Ver Detalhes</button>
                </div>
            </div>
        </div>
    </a>
</div>
@empty
    <div class="col-12 text-center py-5">
        <div class="bg-white p-5 rounded-4 border shadow-sm">
            <i class="bi bi-search fs-1 text-muted"></i>
            <h4 class="mt-3 fw-bold">Nenhum veículo cadastrado</h4>
            <p class="text-muted">Cadastre seu primeiro veículo.</p>
            <a href="{{ route('anuncios.index') }}" class="btn btn-outline-dark rounded-pill px-4 mt-2">Cadastrar veículo</a>
        </div>
    </div>
@endforelse

<style>
/* Reset e Base */
.premium-link-wrapper {
    text-decoration: none !important;
    display: block;
}

.premium-vehicle-card {
    background: #ffffff;
    border: 1px solid #f2f2f2;
    border-radius: 4px; /* Bordas retas transmitem seriedade */
    transition: all 0.4s ease;
    overflow: hidden;
    /* Força números alinhados e com a mesma largura (monoespaçados) */
    font-variant-numeric: lining-nums tabular-nums;
    -moz-font-feature-settings: "lnum", "tnum";
    -webkit-font-feature-settings: "lnum", "tnum";
    font-feature-settings: "lnum", "tnum";
}

.premium-vehicle-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.06);
    border-color: #e5e5e5;
}

/* Container de Imagem */
.image-container {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: #f9f9f9;
}

.card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 1s ease;
}

.premium-vehicle-card:hover .card-img {
    transform: scale(1.04);
}

.premium-badge-float {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #b32d2d;
    color: #fff;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 4px 12px;
    font-weight: 600;
}

/* Corpo do Texto */
.premium-body {
    padding: 24px;
}

.brand-tag {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #999;
    font-weight: 600;
    display: block;
    margin-bottom: 4px;
}

.model-name {
    font-size: 14px;
    color: #b32d2d;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.model-year {
    font-size: 14px;
    color: #666;
    margin-top: 4px;
}

/* Specs Grid */
.premium-specs {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    margin: 15px 0;
    border-top: 1px solid #f5f5f5;
    border-bottom: 1px solid #f5f5f5;
}

.spec-unit {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #777;
    font-size: 13px;
}

.spec-unit svg {
    stroke: #ccc;
}

/* Footer e Preço */
.premium-footer {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-top: 10px;
}

.price-section {
    display: flex;
    flex-direction: column;
}

.old-price-label {
    font-size: 12px;
    color: #bbb;
    text-decoration: line-through;
}

.current-price-label {
    font-size: 16px;
    font-weight: 800;
    color: #111;
    letter-spacing: -0.5px;
}

.current-price-label.offer {
    color: #b32d2d; /* Vermelho rubi (estilo carro esportivo) */
}

/* Botão Minimalista */
.premium-btn {
    background: #b32d2d;
    color: #fff;
    border: none;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 2px;
    transition: background 0.3s ease;
}

.premium-btn:hover {
    background: #333;
}

.empty-state {
    padding: 60px;
    background: #fbfbfb;
    border: 1px dashed #ddd;
}
</style>
