@extends('site.layout.app')

@section('title', 'Veículos')

@section('content')

<style>
  /* Removido o margin-top negativo para não colar no topo */
  .search-menu-container {
    position: relative;
    z-index: 10;
    /* Adicionamos uma margem positiva para desgrudar da breadcrumb */
    margin-top: 20px; 
  }
  
  /* Garante que o fundo da página de título não corte a sombra do filtro */
  .page-title {
    margin-bottom: 0 !important;
  }

  .nav-pills .nav-link {
    color: #6c757d;
    font-weight: 600;
    transition: all 0.3s;
  }
  .nav-pills .nav-link.active {
    background-color: var(--accent-color, #007bff);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  }
  .form-select, .form-control {
    padding: 0.75rem 1rem;
    border-color: #e9ecef;
  }
  section, .section{
    padding: 20px;
  }
</style>

    {{-- <div class="page-title mb-4" data-aos="fade">

    <div class="heading" style="position: relative; z-index: 2; padding-top: 80px;">
        <div class="container position-relative">
            <div class="row justify-content-center">
      <div class="col-" data-aos="fade-up">
        
        <div class="search-menu-container bg-white shadow-lg rounded-4 p-4 p-md-5">
          <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Encontre seu próximo veículo</h3>
            <p class="text-muted">Explore nosso estoque!</p>
          </div>

          

          <form action="{{ route('anuncios.index') }}" method="GET">
    <div class="row g-2 justify-content-center">
        <div class="col-md-9">
            <label class="form-label small fw-bold text-muted">O que você procura?</label>
            <div class="input-group position-relative shadow-sm rounded-2">
                <span class="input-group-text bg-white border-end-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" id="search-input" 
                       class="form-control border-start-0 py-3" 
                       placeholder="Digite a marca ou modelo do veículo..." 
                       autocomplete="off" 
                       style="font-size: 1.1rem;">
                
                <div id="suggestion-box" class="list-group shadow-lg d-none" 
                     style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000; max-height: 250px; overflow-y: auto; border-radius: 0 0 10px 10px;">
                </div>
            </div>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-accent btn-lg w-100 fw-bold shadow-sm py-3">
                <i class="bi bi-search me-2"></i>BUSCAR
            </button>
        </div>
    </div>
</form>

        </div>

      </div>
    </div>
        </div>
    </div>
</div> --}}




    

    <!-- Courses Section -->
    <section id="courses" class="courses section">
    <div class="container section-title mt-4">
        <h2>OFERTAS</h2>
        <p>Mais vendidos</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar bg-white shadow-sm rounded-4 p-3">
  <form action="{{ route('veiculos.usados.search') }}" method="GET">
    
    <div class="accordion accordion-flush" id="filterAccordion">

      <div class="accordion-item border-bottom">
        <h2 class="accordion-header">
          <button class="accordion-button fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterMarca">
            Marca, modelo e versão
          </button>
        </h2>
        <div id="filterMarca" class="accordion-collapse collapse show" data-bs-parent="#filterAccordion">
          <div class="accordion-body px-0">
            <div class="input-group input-group-sm mb-3 position-relative">
              <input type="text" class="form-control border-end-0" placeholder="Digite o veículo" id="search-input-sidebar">
              <span class="input-group-text bg-white border-start-0 text-muted"><i class="bi bi-search"></i></span>
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
              <div class="col-6"><input type="number" name="ano_de" class="form-control form-control-sm" placeholder="De"></div>
              <div class="col-6"><input type="number" name="ano_ate" class="form-control form-control-sm" placeholder="Até"></div>
            </div>
            <div class="d-flex flex-wrap gap-1">
               @for($i=2026; $i>=2017; $i--)
                <button type="submit" name="ano" value="{{$i}}" class="btn btn-outline-secondary btn-sm py-0 px-2">{{$i}}</button>
               @endfor
            </div>
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
                  @if(request()->anyFilled(['search', 'marca', 'tipo', 'cambio', 'min_price', 'max_price', 'ano_de', 'ano_ate']))
<div class="active-filters mb-4 d-flex flex-wrap align-items-center gap-2">
    <span class="small fw-bold text-muted me-2">Filtrado por:</span>

    {{-- Filtro de Texto --}}
    @if(request('search'))
        <span class="badge bg-light text-dark border p-2 fw-normal">
            Busca: <strong>"{{ request('search') }}"</strong>
            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-danger ms-2"><i class="bi bi-x-lg"></i></a>
        </span>
    @endif

    {{-- Filtro de Marca --}}
    @if(request('marca'))
        <span class="badge bg-light text-dark border p-2 fw-normal">
            Marca: <strong>{{ request('marca') }}</strong>
            <a href="{{ request()->fullUrlWithQuery(['marca' => null]) }}" class="text-danger ms-2"><i class="bi bi-x-lg"></i></a>
        </span>
    @endif

    {{-- Filtro de Preço --}}
    @if(request('min_price') || request('max_price'))
        <span class="badge bg-light text-dark border p-2 fw-normal">
            Preço: <strong>R$ {{ request('min_price', '0') }} - R$ {{ request('max_price', '...') }}</strong>
            <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="text-danger ms-2"><i class="bi bi-x-lg"></i></a>
        </span>
    @endif

    {{-- Filtro de Ano --}}
    @if(request('ano_de') || request('ano_ate'))
        <span class="badge bg-light text-dark border p-2 fw-normal">
            Ano: <strong>{{ request('ano_de', 'Antigo') }} a {{ request('ano_ate', '2026') }}</strong>
            <a href="{{ request()->fullUrlWithQuery(['ano_de' => null, 'ano_ate' => null]) }}" class="text-danger ms-2"><i class="bi bi-x-lg"></i></a>
        </span>
    @endif

    {{-- Botão Limpar Tudo --}}
    <a href="{{ route('veiculos.novos') }}" class="btn btn-sm btn-link text-decoration-none text-muted small">
        Limpar tudo
    </a>
</div>
@endif
                    @forelse ($veiculos as $veiculo)
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                      
                        <div class="course-item w-100">
                          
                            @php $imagens = json_decode($veiculo->images, true) ?? []; @endphp

                            @if (count($imagens) > 1)
                                <div id="carousel{{ $veiculo->id }}" class="carousel slide">
                                    <div class="carousel-inner">
                                        @foreach ($imagens as $index => $img)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 img-fluid" style="height: 200px; object-fit: cover;" alt="Veículo">
                                        </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon small"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon small"></span>
                                    </button>
                                </div>
                            @else
                                <img src="{{ count($imagens) ? asset('storage/' . $imagens[0]) : url('assets/img/default-car.png') }}" class="img-fluid" style="height: 200px; width: 100%; object-fit: cover;" alt="Veículo">
                            @endif

                            <div class="course-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="category">{{ explode(' ', $veiculo->marca)[0] }}</p>
                                    <p class="price">{{ $veiculo->estado }}</p>
                                </div>
                                <h3>{{ $veiculo->marca }}</h3>
                                <p class="description small text-muted">{{ $veiculo->kilometragem }}km | ANO: {{ $veiculo->ano }}</p>
                                
                                <div class="trainer d-flex align-items-center justify-content-between mt-3">
                                    <a href="{{ url('sistema/veiculo/' . $veiculo->slug) }}">
                                        <p class="pchama mb-0 badge border border-success text-success bg-transparent">+ DETALHES</p>
                                    </a>
                                    <div class="text-end">
                                        @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
                                            <p class="text-muted mb-0 small" style="text-decoration: line-through;">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</p>
                                            <div class="ptext fw-bold" style="font-size: 18px; color: var(--accent-color);">R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}</div>
                                        @else
                                            <div class="ptext fw-bold" style="font-size: 18px;">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <p class="mt-2">Nenhum veículo encontrado nesta categoria.</p>
                    </div>
                    @endforelse
                </div>
                <div class="mt-4">
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

    @endsection