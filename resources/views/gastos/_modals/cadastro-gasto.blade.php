<div class="modal fade" id="modalCadastrarGasto" tabindex="-1" role="dialog" aria-labelledby="modalCadastrarGastoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="modalCadastrarGastoLabel">
                    <i class="mdi mdi-plus-circle text-primary me-1"></i> Novo Gasto de Preparação
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('veiculos.gastos.store') }}" method="POST" id="formCadastrarGasto">
                @csrf
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="veiculo_id" class="form-label text-dark fw-bold">Veículo</label>
                            <select class="form-select select2" name="veiculo_id" id="veiculo_id" required>
                                <option value="">Selecione o veículo...</option>
                                @foreach($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}">
                                        {{ $veiculo->placa }} - {{ $veiculo->marca }} {{ $veiculo->modelo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="descricao" class="form-label text-dark fw-bold">Descrição do Serviço</label>
                            <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Ex: Higienização Completa" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label text-dark fw-bold">Categoria</label>
                            <select class="form-select" name="categoria" id="categoria" required>
                                <option value="Mecânica">Mecânica</option>
                                <option value="Estética">Estética</option>
                                <option value="Pneus">Pneus</option>
                                <option value="Documentação">Documentação</option>
                                <option value="Acessórios">Acessórios</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="valor" class="form-label text-dark fw-bold">Valor (R$)</label>
                            {{-- Mudamos para type="text" e adicionamos a classe money --}}
                            <input type="text" class="form-control money" name="valor" id="valor" placeholder="0,00" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="data_gasto" class="form-label text-dark fw-bold">Data do Gasto</label>
                            <input type="date" class="form-control" name="data_gasto" id="data_gasto" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fornecedor" class="form-label text-dark fw-bold">Fornecedor</label>
                            <input type="text" class="form-control" name="fornecedor" id="fornecedor" placeholder="Oficina, Loja, etc.">
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="pago" id="pago" value="1">
                                <label class="form-check-label text-dark fw-bold" for="pago">Já está pago?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4" id="btnSalvarGasto">
                        <i class="mdi mdi-check me-1"></i> Salvar Gasto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Se estiver usando Select2, inicialize aqui
    $(document).ready(function() {
        $('#modalCadastrarGasto .select2').select2({
            dropdownParent: $('#modalCadastrarGasto')
        });

        // Feedback visual de loading ao salvar
        $('#formCadastrarGasto').on('submit', function() {
            let btn = $('#btnSalvarGasto');
            btn.prop('disabled', true);
            btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Salvando...');
        });
    });

    $(document).ready(function() {
    // Função para formatar como moeda
    $('.money').on('keyup', function() {
        let valor = $(this).val().replace(/\D/g, ''); // Remove tudo que não é dígito
        valor = (valor / 100).toFixed(2) + '';
        valor = valor.replace(".", ",");
        valor = valor.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        valor = valor.replace(/(\d)(\d{3}),/g, "$1.$2,");
        
        // Se o valor for vazio, limpa o campo, senão coloca o R$
        $(this).val(valor !== 'NaN' && valor !== '0,00' ? valor : '');
    });
});
</script>

