@extends('loja.layout.app')

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
@include('loja.components.card-veiculos')
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