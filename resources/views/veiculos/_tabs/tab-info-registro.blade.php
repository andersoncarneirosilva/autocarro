<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title text-primary mb-0">
                <i class="mdi mdi-file-certificate-outline me-1"></i> Dados de Registro e Identificação
            </h4>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-4 g-3">
                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Renavam</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->renavam ?? '---' }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Chassi</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->chassi ?? '---' }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Número do Motor</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->motor ?? '---' }}</span>
                    </div>

                    <div class="col">
    <small class="text-muted d-block font-11 fw-bold text-uppercase">Número CRV (Recibo)</small>
    <div class="d-flex align-items-center">
        <span class="font-14 text-dark fw-semibold">{{ $veiculo->crv ?? '---' }}</span>

            <button type="button" class="btn btn-sm btn-link text-primary ms-1 p-0" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalEditarRegistro" 
                    title="Cadastrar CRV">
                <i class="mdi mdi-pencil-plus font-14"></i> Editar
            </button>
        
    </div>
</div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Placa Atual</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->placa }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Placa Anterior</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->placaAnterior ?? '---' }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Tipo / Categoria</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->tipo }} / {{ $veiculo->categoria }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Combustível</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->combustivel }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Potência</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->potencia }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Cilindrada</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->cilindrada }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Peso bruto</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->peso_bruto }}</span>
                    </div>

                    <div class="col">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Carroceria</small>
                        <span class="font-14 text-dark fw-semibold">{{ $veiculo->carroceria }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($veiculo->nome)
            <h4 class="header-title mb-3 text-primary">
                <i class="mdi mdi-account-box-outline me-1"></i> Informações do Proprietário Anterior
            </h4>
            
            <div class="card border shadow-none bg-light bg-opacity-25">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <small class="text-muted fw-bold text-uppercase font-11">Proprietário</small>
                            <div class="d-flex align-items-center mt-1">
                                
                                <div>
                                    <h5 class="m-0 text-dark font-15">{{ $veiculo->nome }}</h5>
                                    <small class="text-muted">{{ $veiculo->cpf ?? 'Documento não informado' }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 border-start-md ps-md-4">
                            <small class="text-muted d-block font-11 fw-bold text-uppercase">Cidade / UF</small>
                            <span class="font-14 text-dark fw-semibold">
                                <i class="mdi mdi-map-marker-outline me-1 text-danger"></i>{{ $veiculo->cidade ?? 'Não informado' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($veiculo->infos)
        <div class="card border shadow-none bg-light bg-opacity-25">
                <div class="card-body">
            <div class="mt-3">
                <small class="text-muted d-block font-11 fw-bold text-uppercase">Observações do veículo</small>
                <p class="text-muted font-13">{{ $veiculo->infos }}</p>
            </div>
                </div>
        </div>
        @endif
    </div>
</div>

<style>
    .avatar-sm { height: 36px; width: 36px; }
    .bg-primary-lighten { background-color: rgba(114, 124, 245, 0.15); }
    .font-11 { font-size: 11px; }
    .font-13 { font-size: 13px; }
    .font-14 { font-size: 14px; }
    .font-15 { font-size: 15px; }

    @media (min-width: 768px) {
        .border-start-md { border-left: 1px solid #dee2e6 !important; }
    }
</style>