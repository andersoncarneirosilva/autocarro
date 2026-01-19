@extends('loja.layout.app')

@section('title', 'Veículos')

@section('content')
<style>
  /* Estilização Geral do Card */
.course-item {
    background: #fff;
    border-radius: 15px;
    border: 1px solid #eee;
    overflow: hidden;
    transition: all 0.3s ease;
}

.course-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Mini Cards de Info dentro do Card de Listagem */
.card-spec-grid {
    display: flex;
    gap: 8px;
    margin-bottom: 15px;
}

.mini-spec-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 6px 10px;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid #f0f0f0;
}

.mini-spec-card i {
    color: #ff4a17;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.mini-spec-card span {
    font-size: 0.7rem;
    font-weight: 700;
    color: #444;
    text-transform: uppercase;
}

/* Badge de Preço e Categoria */
.category-badge {
    background: #fff0eb;
    color: #ff4a17;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    text-transform: uppercase;
}

/* Container de Filtros */
.active-filters {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}

/* Estilo das Etiquetas (Pills) */
.filter-pill {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 50px;
    padding: 6px 14px;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.filter-pill:hover {
    border-color: #ff4a17;
    background: #fffafa;
}

.filter-pill strong {
    color: #333;
}

.filter-pill .remove-filter {
    color: #adb5bd;
    display: flex;
    align-items: center;
    transition: color 0.2s;
}

.filter-pill:hover .remove-filter {
    color: #ff4a17;
}

/* Link de Limpar Tudo */
.btn-clear-all {
    font-size: 0.8rem;
    color: #ff4a17;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    padding: 5px 10px;
}

.btn-clear-all:hover {
    color: #d43d12;
    text-decoration: underline;
}

.btn-filter-year {
    border: 1px solid #dee2e6;
    color: #666;
    background: #fff;
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 5px;
    transition: all 0.2s;
}
.btn-filter-year:hover, .btn-filter-year.active {
    background-color: #ff4a17;
    border-color: #ff4a17;
    color: #fff;
}
</style>

    <!-- Courses Section -->
    <section id="courses" class="courses section mt-5">
    <div class="container section-title mt-5">
        <h2>OFERTAS</h2>
        <p>Veículos novos</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar bg-white shadow-sm rounded-4 p-3">
  <form action="{{ route('veiculos.novos.search') }}" method="GET" id="mainFilterForm">
    
    <div class="accordion accordion-flush" id="filterAccordion">

      <div class="accordion-item border-bottom">
        <h2 class="accordion-header">
          <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterMarca">
            Marca, modelo e versão
          </button>
        </h2>
        <div id="filterMarca" class="accordion-collapse collapse show" data-bs-parent="#filterAccordion">
          <div class="accordion-body px-0">
            <div class="input-group mb-3 position-relative">
    <input type="text" 
       name="search" 
       class="form-control border-end-0" 
       placeholder="Digite o veículo" 
       id="search-input-sidebar" 
       value="{{ request('search') }}"
       onkeypress="if(event.key === 'Enter') { document.getElementById('hidden_ano').value = ''; }">
    <span class="input-group-text bg-white border-start-0 text-muted">
        <i class="bi bi-search"></i>
    </span>
    <div id="suggestion-box-sidebar" class="list-group shadow d-none position-absolute w-100" style="top:100%; z-index:100;"></div>
</div>
            
            <div class="row g-2 text-center mb-2">
              @php $marcasPopulares = ['Volkswagen', 'Chevrolet', 'Fiat', 'Ford', 'Honda', 'Hyundai', 'Jeep', 'Nissan', 'Renault']; @endphp
              @foreach($marcasPopulares as $marca)
              <div class="col-4">
                <label class="brand-item p-2 border rounded d-block cursor-pointer">
                  <input type="radio" name="marca" value="{{ $marca }}" class="d-none" onchange="this.form.submit()">
                  <span class="small d-block text-truncate">{{ $marca }}</span>
                </label>
              </div>
              @endforeach
            </div>
            <a href="#" class="btn btn-link btn-sm p-0 text-decoration-none fw-bold">Ver todas as marcas</a>
          </div>
        </div>
      </div>

      <div class="accordion-item border-bottom">
        <h2 class="accordion-header">
          <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterPreco">
            Preço
          </button>
        </h2>
        <div id="filterPreco" class="accordion-collapse collapse show">
          <div class="accordion-body px-0 py-3">
            <div class="row g-2">
              <div class="col-6">
                <label class="small text-muted">De</label>
                <input type="text" name="min_price" class="form-control form-control-sm" placeholder="R$">
              </div>
              <div class="col-6">
                <label class="small text-muted">Até</label>
                <input type="text" name="max_price" class="form-control form-control-sm" placeholder="R$">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="accordion-item border-bottom">
        <h2 class="accordion-header">
          <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterAno">
            Ano
          </button>
        </h2>
        <div id="filterAno" class="accordion-collapse collapse show">
    <div class="accordion-body px-0">
        <div class="row g-2 mb-3">
            <div class="col-6">
                <input type="number" name="ano_de" value="{{ request('ano_de') }}" 
                       class="form-control form-control-sm border-light-subtle" placeholder="De">
            </div>
            <div class="col-6">
                <input type="number" name="ano_ate" value="{{ request('ano_ate') }}" 
                       class="form-control form-control-sm border-light-subtle" placeholder="Até">
            </div>
        </div>

        <div class="d-flex flex-wrap gap-1 overflow-auto" style="max-height: 150px; padding-bottom: 5px;">
            @foreach($anosDisponiveis as $anoItem)
    @php 
        $isActive = request('ano') == $anoItem && !request('ano_de') && !request('ano_ate');
    @endphp
    {{-- Mudamos o botão para type="button" e usamos JS para enviar apenas o necessário --}}
    <button type="button" 
        class="btn btn-sm btn-filter-year {{ $isActive ? 'active' : '' }}"
        onclick="filterBySingleYear('{{ $anoItem }}')">
        {{ $anoItem }}
    </button>
@endforeach

{{-- Input hidden para armazenar o ano único apenas quando necessário --}}
<input type="hidden" name="ano" id="hidden_ano" value="{{ request('ano') }}">
        </div>
        
        @if(request('ano') || request('ano_de') || request('ano_ate'))
            <div class="mt-2">
                <a href="{{ request()->fullUrlWithQuery(['ano' => null, 'ano_de' => null, 'ano_ate' => null]) }}" 
                   class="text-danger small text-decoration-none" style="font-size: 0.7rem;">
                   <i class="bi bi-x-circle"></i> Limpar ano
                </a>
            </div>
        @endif
    </div>
</div>
      </div>

      <div class="accordion-item border-bottom">
        <h2 class="accordion-header">
          <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterKm">
            Quilometragem <br>
          </button>
        </h2>
        <div id="filterKm" class="accordion-collapse collapse show">
          <div class="accordion-body px-0">
             <label class="small text-muted">Até</label>
             <input type="text" name="km_max" class="form-control form-control-sm" placeholder="Ex: 50.000">
          </div>
        </div>
      </div>

      <div class="accordion-item border-bottom">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterMotor">
            Motor
          </button>
        </h2>
        <div id="filterMotor" class="accordion-collapse collapse">
          <div class="accordion-body px-0 py-2">
             @foreach(['1.0', '1.3', '1.4', '1.6', '2.0'] as $motor)
             <div class="form-check mb-1">
               <input class="form-check-input" type="checkbox" name="motor[]" value="{{$motor}}" id="motor{{$motor}}">
               <label class="form-check-label small" for="motor{{$motor}}">{{$motor}}</label>
             </div>
             @endforeach
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterPlaca">
            Final da placa
          </button>
        </h2>
        <div id="filterPlaca" class="accordion-collapse collapse">
          <div class="accordion-body px-0 py-2">
             @foreach(['1 ou 2', '3 ou 4', '5 ou 6', '7 ou 8', '9 ou 0'] as $placa)
             <div class="form-check">
               <input class="form-check-input" type="checkbox" name="placa[]" value="{{$placa}}" id="placa{{$placa}}">
               <label class="form-check-label small" for="placa{{$placa}}">{{$placa}}</label>
             </div>
             @endforeach
          </div>
        </div>
      </div>

    </div>

    <button type="submit" class="btn btn-accent w-100 mt-4 fw-bold">APLICAR FILTROS</button>
  </form>
</div>

<style>
  .accordion-button:not(.collapsed) { background-color: transparent; color: inherit; box-shadow: none; }
  .accordion-button::after { background-size: 1rem; }
  .brand-item:hover { background-color: #f8f9fa; border-color: var(--accent-color) !important; color: var(--accent-color); }
  .cursor-pointer { cursor: pointer; }
</style>
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