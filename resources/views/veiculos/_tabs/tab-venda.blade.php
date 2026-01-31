<div class="alert {{ $veiculo->status == 'Vendido' ? 'alert-success border-success' : 'alert-info border-primary' }} shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
        <div class="avatar-sm me-3">
            <span class="avatar-title bg-white rounded-circle">
                <i class="mdi {{ $veiculo->status == 'Vendido' ? 'mdi-check-decagram text-success' : 'mdi-car-key text-primary' }} font-24"></i>
            </span>
        </div>
        <div class="flex-grow-1">
            <h5 class="alert-heading fw-bold mb-1">Status: {{ $veiculo->status }}</h5>
            <p class="mb-0">
                @if($veiculo->status == 'Vendido')
                    Negociação concluída com <strong>{{ $veiculo->cliente->nome ?? 'Cliente Final' }}</strong>.
                @else
                    Veículo disponível no estoque. Preço sugerido de venda: <strong>R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</strong>.
                @endif
            </p>
        </div>
        @if($veiculo->status != 'Vendido')
            <div class="ms-auto">
                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalVenderVeiculo">
                    <i class="mdi mdi-cart-check me-1"></i> Registrar Venda
                </button>
            </div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="row g-0 text-center">
            <div class="col-6 col-lg-3 border-end p-4">
                <p class="text-muted mb-2 small text-uppercase fw-bold">Preço de Compra</p>
                <h3 class="mb-1 fw-bold text-dark">R$ {{ number_format($veiculo->valor_compra, 2, ',', '.') }}</h3>
                <small class="text-danger"><i class="mdi mdi-arrow-down"></i> Saída inicial</small>
            </div>

            <div class="col-6 col-lg-3 border-end p-4">
                <p class="text-muted mb-2 small text-uppercase fw-bold">Gastos de Preparação</p>
                <h3 class="mb-1 fw-bold text-info">R$ {{ number_format($veiculo->gastos->sum('valor'), 2, ',', '.') }}</h3>
                <small class="text-muted"><i class="mdi mdi-wrench"></i> Manutenção/Multas</small>
            </div>

            <div class="col-6 col-lg-3 border-end p-4 bg-soft-light">
                <p class="text-muted mb-2 small text-uppercase fw-bold">Custo Total</p>
                @php $custoTotal = $veiculo->valor_compra + $veiculo->gastos->sum('valor'); @endphp
                <h3 class="mb-1 fw-bold text-dark">R$ {{ number_format($custoTotal, 2, ',', '.') }}</h3>
                <small class="text-muted">Investimento no carro</small>
            </div>

            <div class="col-6 col-lg-3 p-4 {{ ($veiculo->valor - $custoTotal) < 0 ? 'bg-soft-danger' : '' }}">
                <p class="text-muted mb-2 small text-uppercase fw-bold">Margem Bruta Est.</p>
                @php $margem = $veiculo->valor - $custoTotal; @endphp
                <h3 class="mb-1 fw-bold {{ $margem >= 0 ? 'text-success' : 'text-danger' }}">
                    R$ {{ number_format($margem, 2, ',', '.') }}
                </h3>
                <small class="{{ $margem >= 0 ? 'text-success' : 'text-danger' }}">
                    <i class="mdi {{ $margem >= 0 ? 'mdi-trending-up' : 'mdi-trending-down' }}"></i> 
                    Baseado no valor de anúncio
                </small>
            </div>
        </div>
    </div>
</div>