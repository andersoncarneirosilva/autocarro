<div class="filter-sidebar bg-white shadow-sm rounded-4 p-3">
    <form action="{{ route('veiculos.search.geral') }}" method="GET" id="mainFilterForm">
    <input type="hidden" name="modelo" id="input-modelo">
    <input type="hidden" name="ano" id="input-ano">
    <input type="hidden" name="valor" id="input-preco">

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

<script>
function filterBySingleYear(ano) {
    const form = document.getElementById('mainFilterForm');
    const inputAno = document.getElementById('input-ano');
    
    if (inputAno && form) {
        inputAno.value = ano;
        form.submit(); // O navegador usará automaticamente o action="{{ route('veiculos.search.geral') }}"
    }
}
</script>