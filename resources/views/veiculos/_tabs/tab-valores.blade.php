
                        <div class="row">
    <div class="col-md-4">
    <div class="card widget-flat border-primary border">
        <div class="card-body">
            <div class="float-end">
                <i class="mdi mdi-currency-usd widget-icon bg-primary-lighten text-primary"></i>
            </div>
            
            <h5 class="text-muted fw-normal mt-0" title="Preço base de venda">Valor de Venda</h5>
            <h3 class="mt-3 mb-2">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h3>
            
            @if($veiculo->exibir_parcelamento == '1' && $veiculo->valor_parcela > 0)
                <div class="bg-primary-lighten rounded p-2 mb-2 border border-primary border-opacity-10">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-finance text-primary me-2 font-18"></i>
                        <div>
                            <p class="m-0 text-muted font-11 fw-bold text-uppercase">Entrada + Parcelas</p>
                            <h5 class="m-0 text-primary font-14">
                                {{ $veiculo->qtd_parcelas }}x de R$ {{ number_format($veiculo->valor_parcela, 2, ',', '.') }}
                            </h5>
                        </div>
                    </div>
                </div>
            @else
                <div style="height: 48px;" class="d-flex align-items-center">
                    <p class="text-muted font-12 mb-0 italic">Sem parcelamento ativo</p>
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mt-2">
                <p class="mb-0 text-muted">
                    <span class="text-nowrap font-12">Preço de vitrine</span>
                </p>
                <button type="button" class="btn btn-link btn-sm text-primary p-0 text-decoration-none fw-bold font-12" data-bs-toggle="modal" data-bs-target="#modalEditarPrecos">
                    <i class="mdi mdi-pencil"></i> EDITAR
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-lighten { background-color: rgba(114, 124, 245, 0.1); }
    .font-11 { font-size: 11px; }
    .font-12 { font-size: 12px; }
    .font-14 { font-size: 14px; }
    .italic { font-style: italic; }
</style>

    <div class="col-md-4">
        <div class="card widget-flat border-warning border">
            <div class="card-body">
                <div class="float-end">
                    <i class="mdi mdi-tag-outline widget-icon bg-warning-lighten text-warning"></i>
                </div>
                <h5 class="text-muted fw-normal mt-0" title="Preço promocional">Valor de Oferta</h5>
                <h3 class="mt-3 mb-2 text-warning">
                    {{ $veiculo->valor_oferta > 0 ? 'R$ ' . number_format($veiculo->valor_oferta, 2, ',', '.') : '---' }}
                </h3>
                <p class="mb-0 text-muted">
                    @if($veiculo->valor_oferta > 0)
                        <span class="text-danger me-2"><i class="mdi mdi-trending-down"></i> Econ. R$ {{ number_format($veiculo->valor - $veiculo->valor_oferta, 2, ',', '.') }}</span>
                    @else
                        <span class="text-nowrap">Sem oferta ativa</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
    <div class="card widget-flat border-success border">
        <div class="card-body">
            <div class="float-end">
                <i class="mdi mdi-calculator widget-icon bg-success-lighten text-success"></i>
            </div>
            <h5 class="text-muted fw-normal mt-0">Tabela FIPE</h5>
            <h3 class="mt-3 mb-2 text-success" id="fipe-price">---</h3>
            <p class="mb-0 text-muted">
                <span id="fipe-comparison"></span>
                <small class="d-block text-truncate" id="fipe-info">Carregando...</small>
            </p>
        </div>
    </div>
</div>
</div>

@if($dadosFipe)
<div class="row">
    <div class="col-12">
        <div class="alert alert-light border-0 py-1 px-2 font-12 text-muted">
            <i class="mdi mdi-information-outline"></i> 
            <b>Referência FIPE:</b> {{ $dadosFipe['model'] }} ({{ $dadosFipe['codeFipe'] }}) - {{ $dadosFipe['referenceMonth'] }}
        </div>
    </div>
</div>
@endif