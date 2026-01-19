@extends('loja.layout.app')

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

     

    <!-- Courses Section -->
    <section id="courses" class="courses section mt-5">
    <div class="container section-title mt-5">
        <h2>Resultado</h2>
        <p>Veículos encontrados</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">

               @include('loja.components.filter')

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