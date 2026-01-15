<div class="row">
    <div class="col-md-12">
        <!-- Card Geral -->
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- INFORMAÇÕES DO PROPRIETÁRIO -->
                <h6 class="text-primary border-start border-3 ps-2 mb-3">
                    <i class="mdi mdi-account me-1"></i> INFORMAÇÕES DO PROPRIETÁRIO
                </h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Nome:</strong> {{ $veiculo->nome }}</div>
                    <div class="col-md-6"><strong>CPF:</strong> {{ $veiculo->cpf }}</div>
                    <div class="col-md-12 mt-2"><strong>Endereço:</strong> {{ $veiculo->endereco }}</div>
                </div>

                <hr>

                <!-- INFORMAÇÕES DO VEÍCULO -->
                <h6 class="text-primary border-start border-3 ps-2 mb-3">
                    <i class="mdi mdi-car-info me-1"></i> INFORMAÇÕES DO VEÍCULO
                </h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Marca:</strong> {{ $veiculo->marca }}</div>
                    <div class="col-md-6"><strong>Placa:</strong> {{ substr($veiculo->placa, 0, 3) . '-' . substr($veiculo->placa, 3) }}</div>
                    <div class="col-md-6"><strong>Chassi:</strong> {{ $veiculo->chassi }}</div>
                    <div class="col-md-6"><strong>Cor:</strong> {{ $veiculo->cor }}</div>
                    <div class="col-md-6"><strong>Ano:</strong> {{ $veiculo->ano }}</div>
                    <div class="col-md-6"><strong>Renavam:</strong> {{ $veiculo->renavam }}</div>
                    <div class="col-md-6"><strong>Cidade:</strong> {{ $veiculo->cidade }}</div>
                    <div class="col-md-6"><strong>CRV:</strong> {{ $veiculo->crv }}</div>
                </div>

                <hr>

                <!-- INFORMAÇÕES COMPLEMENTARES -->
                <h6 class="text-primary border-start border-3 ps-2 mb-3">
                    <i class="mdi mdi-information-outline me-1"></i> INFORMAÇÕES COMPLEMENTARES
                </h6>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Placa Anterior:</strong> {{ $veiculo->placaAnterior }}</div>
                    <div class="col-md-6"><strong>Categoria:</strong> {{ $veiculo->categoria }}</div>
                    <div class="col-md-6"><strong>Motor:</strong> {{ $veiculo->motor }}</div>
                    <div class="col-md-6"><strong>Combustível:</strong> {{ $veiculo->combustivel }}</div>
                </div>

                <hr>

                <!-- INFORMAÇÕES ADICIONAIS -->
                <h6 class="text-primary border-start border-3 ps-2 mb-3">
                    <i class="mdi mdi-note-text-outline me-1"></i> INFORMAÇÕES ADICIONAIS
                </h6>
                <div class="row">
                    <div class="col-md-12"><strong>Observações:</strong> {{ $veiculo->infos }}</div>
                </div>

            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-md-12 -->
</div> <!-- row -->
