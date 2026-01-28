<div class="card border-0">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mt-0">Status da Venda</h4>
                @if($veiculo->status == 'Vendido')
                    <div class="alert alert-success border-0">
                        <h4 class="alert-heading">Veículo Vendido!</h4>
                        <p class="mb-0">Este veículo foi processado e não está mais disponível no estoque.</p>
                    </div>
                @else
                    <p class="text-muted">Este veículo ainda está disponível no estoque. Clique no botão abaixo para registrar uma nova venda.</p>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalVenderVeiculo">
                        <i class="mdi mdi-cart-check me-1"></i> Registrar Venda
                    </button>
                @endif
            </div>
        </div>

        @if($veiculo->status == 'Vendido')
            <hr>
            <div class="row mt-3">
                <div class="col-md-4">
                    <p class="text-muted mb-1">Comprador</p>
                    <h5 class="mt-0">{{ $veiculo->comprador_nome ?? 'Não informado' }}</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">Valor Final</p>
                    <h5 class="mt-0 text-success">R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">Data da Venda</p>
                    <h5 class="mt-0">{{ \Carbon\Carbon::parse($veiculo->data_venda)->format('d/m/Y') }}</h5>
                </div>
            </div>
        @endif
    </div>
</div>