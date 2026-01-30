<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h4 class="mt-0 mb-3">
                    <i class="mdi mdi-Check-decagram text-success me-1"></i> Status da Unidade
                </h4>
                @if($veiculo->status == 'Vendido')
                    <div class="alert alert-success border-0 bg-soft-success">
                        <h4 class="alert-heading fw-bold">Veículo Vendido!</h4>
                        <p class="mb-0">A negociação foi concluída e o veículo foi removido do estoque ativo.</p>
                    </div>
                @else
                    <div class="p-2">
                        <p class="text-muted">Este veículo encontra-se <strong>Disponível</strong> em seu estoque. Para registrar a saída e os dados financeiros, utilize o botão abaixo.</p>
                        <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#modalVenderVeiculo">
                            <i class="mdi mdi-cart-check me-1"></i> Registrar Venda Agora
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @if($veiculo->status == 'Vendido')
            <hr class="my-4">
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Cliente / Comprador</p>
                    <h5 class="mt-0"><i class="mdi mdi-account-circle-outline me-1"></i> {{ $veiculo->cliente->nome ?? 'Não informado' }}</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Vendedor Responsável</p>
                    <h5 class="mt-0"><i class="mdi mdi-badge-account-horizontal-outline me-1"></i> {{ $veiculo->vendedor->name ?? 'Não informado' }}</h5>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Data da Transação</p>
                    <h5 class="mt-0"><i class="mdi mdi-calendar-check me-1"></i> {{ \Carbon\Carbon::parse($veiculo->data_venda)->format('d/m/Y') }}</h5>
                </div>
            </div>

            <div class="p-3 rounded bg-light border">
                <div class="row text-center text-md-start">
                    <div class="col-md-3 border-end">
                        <p class="text-muted mb-1 small text-uppercase">Valor Total de Venda</p>
                        <h4 class="mt-0 text-success fw-bold">R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</h4>
                    </div>
                    
                    <div class="col-md-3 border-end">
                        <p class="text-muted mb-1 small text-uppercase">Entrada</p>
                        <h5 class="mt-0 text-dark">R$ {{ number_format($veiculo->entrada, 2, ',', '.') }}</h5>
                    </div>

                    <div class="col-md-3 border-end">
                        <p class="text-muted mb-1 small text-uppercase">Condição</p>
                        @if($veiculo->qtd_parcelas > 1)
                            <h5 class="mt-0 text-primary">{{ $veiculo->qtd_parcelas }}x Parcelado</h5>
                        @else
                            <h5 class="mt-0 text-primary">Pagamento à Vista</h5>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <p class="text-muted mb-1 small text-uppercase">Valor da Parcela</p>
                        <h5 class="mt-0">
                            @if($veiculo->qtd_parcelas > 1)
                                <span class="badge bg-soft-primary text-primary px-2">R$ {{ number_format($veiculo->valor_parcela, 2, ',', '.') }}</span>
                                <small class="d-block text-muted" style="font-size: 10px;">Taxa: {{ $veiculo->taxa_juros }}% a.m.</small>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </h5>
                    </div>
                </div>
            </div>

            @if($veiculo->observacoes_venda)
                <div class="mt-3">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Observações da Venda</p>
                    <p class="mb-0 text-dark italic">{{ $veiculo->observacoes_venda }}</p>
                </div>
            @endif
        @endif
    </div>
</div>