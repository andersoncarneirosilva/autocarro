@forelse ($veiculos as $veiculo)
    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-4" data-aos="zoom-in" data-aos-delay="100">
        {{-- O link agora envolve todo o conteúdo do card --}}
        <a href="{{ route('loja.veiculo.detalhes', [
    'slug_loja' => $veiculo->user->revenda->slug ?? 'particular', 
    'slug_veiculo' => $veiculo->slug
]) }}" class="text-decoration-none w-100">
            
            <div class="course-item w-100 shadow-sm border-0 bg-white rounded-4 overflow-hidden h-100">
                
                {{-- Cabeçalho do Card: Apenas Imagem Principal --}}
                @php 
                    $imagens = is_array($veiculo->images) ? $veiculo->images : json_decode($veiculo->images, true) ?? []; 
                    $imagemExibicao = count($imagens) > 0 ? asset('storage/' . $imagens[0]) : url('assets/img/default-car.png');
                @endphp

                <div class="position-relative">
                    <img src="{{ $imagemExibicao }}" class="w-100" style="height: 220px; object-fit: cover;" alt="{{ $veiculo->modelo_exibicao }}">
                    
                    {{-- Badge de Ano sobre a imagem --}}
                    <span class="position-absolute top-0 end-0 m-3 category-badge">
                        {{ $veiculo->ano }}
                    </span>
                </div>

                {{-- Conteúdo do Card --}}
                <div class="course-content p-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <p class="mb-0 text-muted small fw-bold text-uppercase" style="font-size: 0.65rem;">{{ $veiculo->marca_exibicao ?? $veiculo->marca }}</p>
                        <span class="text-success small fw-bold" style="font-size: 0.7rem;"><i class="bi bi-check-circle-fill me-1"></i>{{ $veiculo->estado }}</span>
                    </div>
                    
                    <h3 class="h6 fw-bold text-dark mb-3 text-truncate">{{ $veiculo->modelo_exibicao ?? $veiculo->modelo }}</h3>

                    {{-- Grid de Mini Cards --}}
                    <div class="card-spec-grid d-flex gap-2 mb-3">
                        <div class="mini-spec-card flex-fill text-center p-2 rounded-3 border bg-light">
                            <i class="bi bi-speedometer2 d-block mb-1" style="color: #ff4a17;"></i>
                            <span class="d-block fw-bold text-dark" style="font-size: 0.65rem;">{{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM</span>
                        </div>
                        <div class="mini-spec-card flex-fill text-center p-2 rounded-3 border bg-light">
                            <i class="bi bi-gear-wide-connected d-block mb-1" style="color: #ff4a17;"></i>
                            <span class="d-block fw-bold text-dark" style="font-size: 0.65rem;">{{ $veiculo->cambio }}</span>
                        </div>
                        <div class="mini-spec-card flex-fill text-center p-2 rounded-3 border bg-light">
                            <i class="bi bi-fuel-pump d-block mb-1" style="color: #ff4a17;"></i>
                            <span class="d-block fw-bold text-dark" style="font-size: 0.65rem;">{{ $veiculo->combustivel }}</span>
                        </div>
                    </div>
                    
                    {{-- Rodapé: Preço e Botão Visual --}}
                    <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                        <div class="price-block">
                            @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
                                <p class="text-muted mb-0 small text-decoration-line-through" style="font-size: 11px;">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</p>
                                <div class="fw-bold text-success" style="font-size: 1.1rem;">R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}</div>
                            @else
                                <p class="text-muted mb-0 small opacity-0" style="font-size: 11px;">.</p>
                                <div class="fw-bold text-dark" style="font-size: 1.1rem;">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <div class="bg-white p-5 rounded-4 border shadow-sm">
            <i class="bi bi-search fs-1 text-muted"></i>
            <h4 class="mt-3 fw-bold">Nenhum veículo encontrado</h4>
            <p class="text-muted">Não encontramos resultados para os filtros aplicados.</p>
            <a href="{{ route('loja.index') }}" class="btn btn-outline-dark rounded-pill px-4 mt-2">Ver todo o estoque</a>
        </div>
    </div>
@endforelse