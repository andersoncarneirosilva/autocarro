@extends('loja.layout.app')

@section('title', 'Veículos')

@section('content')


    <!-- Courses Section -->
    <section id="courses" class="courses section mt-5">
    <div class="container section-title mt-5">
        <h2>OFERTAS</h2>
        <p>Veículos Semi-novos</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">

                @include('loja.components.filter')

            </div>

            <div class="col-lg-9">
    <div class="row gy-4">
        
        {{-- SEÇÃO DE FILTROS ATIVOS --}}
@if(request()->anyFilled(['search', 'marca', 'tipo', 'cambio', 'min_price', 'max_price', 'ano_de', 'ano_ate', 'ano']))
    <div class="col-12">
        <div class="active-filters mb-2 d-flex flex-wrap align-items-center gap-2 shadow-sm p-3 bg-white rounded-3 border">
            <span class="small fw-bold text-dark text-uppercase me-2" style="font-size: 0.7rem; letter-spacing: 1px;">
                <i class="bi bi-funnel-fill text-muted me-1"></i> Filtrado por:
            </span>

            {{-- Filtro de Texto --}}
            @if(request('search'))
                <div class="filter-pill">
                    <span>Busca: <strong>"{{ request('search') }}"</strong></span>
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="remove-filter">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </div>
            @endif

            {{-- Filtro de Marca --}}
            @if(request('marca'))
                <div class="filter-pill">
                    <span>Marca: <strong>{{ request('marca') }}</strong></span>
                    <a href="{{ request()->fullUrlWithQuery(['marca' => null]) }}" class="remove-filter">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </div>
            @endif

            {{-- Filtro de Preço --}}
            @if(request('min_price') || request('max_price'))
                <div class="filter-pill">
                    <span>Preço: <strong>R$ {{ request('min_price', '0') }} - {{ request('max_price', '...') }}</strong></span>
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="remove-filter">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                </div>
            @endif

            {{-- Filtro de Ano (Hierarquia: Período tem prioridade sobre Ano único) --}}
@if(request('ano_de') || request('ano_ate'))
    {{-- Se houver qualquer campo de período, mostra APENAS esta pílula --}}
    <div class="filter-pill">
        <span>Período: <strong>{{ request('ano_de', 'Antigo') }} - {{ request('ano_ate', 'Fim') }}</strong></span>
        {{-- O link de remover aqui deve limpar TUDO de ano para evitar que o '&ano=...' volte --}}
        <a href="{{ request()->fullUrlWithQuery(['ano_de' => null, 'ano_ate' => null, 'ano' => null]) }}" class="remove-filter">
            <i class="bi bi-x-circle-fill"></i>
        </a>
    </div>
@elseif(request('ano'))
    {{-- Se NÃO houver período, mas houver um ano individual --}}
    <div class="filter-pill">
        <span>Ano: <strong>{{ request('ano') }}</strong></span>
        <a href="{{ request()->fullUrlWithQuery(['ano' => null]) }}" class="remove-filter">
            <i class="bi bi-x-circle-fill"></i>
        </a>
    </div>
@endif

            {{-- Botão Limpar Tudo --}}
            <a href="{{ route('veiculos.novos') }}" class="btn-clear-all ms-md-auto">
                Limpar Filtros
            </a>
        </div>
    </div>
@endif

        {{-- LISTAGEM DE VEÍCULOS --}}
        @forelse ($veiculos as $veiculo)
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-2" data-aos="zoom-in" data-aos-delay="100">
                <div class="course-item w-100 shadow-sm border-0 bg-white rounded-4 overflow-hidden">
                    
                    {{-- Cabeçalho do Card: Imagem/Carrossel --}}
                    @php $imagens = is_array($veiculo->images) ? $veiculo->images : json_decode($veiculo->images, true) ?? []; @endphp

                    <div class="position-relative">
                        @if (count($imagens) > 1)
                            <div id="carousel{{ $veiculo->id }}" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner">
                                    @foreach ($imagens as $index => $img)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $img) }}" class="d-block w-100" style="height: 220px; object-fit: cover;" alt="Veículo">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" style="width: 20px;"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" style="width: 20px;"></span>
                                </button>
                            </div>
                        @else
                            <img src="{{ count($imagens) ? asset('storage/' . $imagens[0]) : url('assets/img/default-car.png') }}" class="w-100" style="height: 220px; object-fit: cover;" alt="Veículo">
                        @endif
                        
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

                        {{-- Grid de Mini Cards (Estilo Ficha Técnica) --}}
                        <div class="card-spec-grid d-flex gap-2 mb-3">
                            <div class="mini-spec-card flex-fill text-center p-2 rounded-3 border bg-light">
                                <i class="bi bi-speedometer2 d-block mb-1" style="color: #ff4a17;"></i>
                                <span class="d-block fw-bold" style="font-size: 0.65rem;">{{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM</span>
                            </div>
                            <div class="mini-spec-card flex-fill text-center p-2 rounded-3 border bg-light">
                                <i class="bi bi-gear-wide-connected d-block mb-1" style="color: #ff4a17;"></i>
                                <span class="d-block fw-bold" style="font-size: 0.65rem;">{{ $veiculo->cambio }}</span>
                            </div>
                            <div class="mini-spec-card flex-fill text-center p-2 rounded-3 border bg-light">
                                <i class="bi bi-fuel-pump d-block mb-1" style="color: #ff4a17;"></i>
                                <span class="d-block fw-bold" style="font-size: 0.65rem;">{{ $veiculo->combustivel }}</span>
                            </div>
                        </div>
                        
                        {{-- Rodapé: Preço e Ação --}}
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
                            
                            <a href="{{ url('veiculo/' . $veiculo->slug) }}" class="btn btn-sm px-3 rounded-pill fw-bold text-white" style="background: #ff4a17; font-size: 0.75rem;">
                                VER MAIS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- ESTADO VAZIO --}}
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-4 border shadow-sm">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h4 class="mt-3 fw-bold">Nenhum veículo encontrado</h4>
                    <p class="text-muted">Não encontramos resultados para os filtros aplicados. Tente limpar os filtros ou mudar os termos da busca.</p>
                    <a href="{{ route('veiculos.novos') }}" class="btn btn-outline-dark rounded-pill px-4 mt-2">Ver todo o estoque</a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINAÇÃO --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $veiculos->appends(request()->query())->links() }}
    </div>
</div>

        </div>
    </div>
    
</section>

<style>
    .cursor-pointer { cursor: pointer; }
    .filter-sidebar { border: 1px solid #eee; }
    .filter-sidebar .list-group-item:hover { background-color: #f8f9fa; }
    .course-item { transition: transform 0.3s; background: #fff; border: 1px solid #eee; }
    .course-item:hover { transform: translateY(-5px); }
</style>

<script>
// Função para quando clica em um ano específico (ex: 2019)
function filterBySingleYear(year) {
    const form = document.getElementById('mainFilterForm');
    
    // Limpa os campos de período para não dar conflito
    document.getElementsByName('ano_de')[0].value = '';
    document.getElementsByName('ano_ate')[0].value = '';
    
    // Define o valor no hidden e envia
    document.getElementById('hidden_ano').value = year;
    form.submit();
}

// Função para limpar filtros conflitantes ao enviar o formulário geral
document.getElementById('mainFilterForm').addEventListener('submit', function(e) {
    const searchInput = document.getElementById('search-input-sidebar').value;
    const anoDe = document.getElementsByName('ano_de')[0].value;
    const anoAte = document.getElementsByName('ano_ate')[0].value;
    const hiddenAno = document.getElementById('hidden_ano');

    // REGRA: Se o usuário digitou algo na busca ou preencheu o período (De/Até),
    // nós removemos o filtro de "ano único" (o botão que estava selecionado)
    if (searchInput.trim() !== '' || anoDe !== '' || anoAte !== '') {
        hiddenAno.value = ''; 
    }
});

// Função auxiliar para os inputs de ano (De/Até)
function clearPeriodFilters() {
    document.getElementById('hidden_ano').value = '';
}
</script>

    @endsection