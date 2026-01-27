<div class="modal fade" id="modalCadastrarMulta" tabindex="-1" aria-labelledby="modalCadastrarMultaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalCadastrarMultaLabel">
                    <i class="mdi mdi-alert-decagram-outline me-1"></i> Cadastrar Nova Multa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('multas.store') }}" method="POST" id="formMulta">
                @csrf
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="multa_veiculo_id" class="form-label text-dark fw-bold">Veículo</label>
                            <select class="form-select" id="multa_veiculo_id" name="veiculo_id" required>
                                <option value="">Selecione o veículo pela placa ou modelo...</option>
                                @foreach($veiculos_list as $v)
                                    <option value="{{ $v->id }}">{{ $v->placa }} - {{ $v->marca }} {{ $v->modelo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="descricao" class="form-label text-dark fw-bold">Descrição da Infração</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Ex: Avançar sinal vermelho" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="codigo_infracao" class="form-label text-dark fw-bold">Código</label>
                            <input type="text" class="form-control" id="codigo_infracao" name="codigo_infracao" placeholder="Ex: 605-01">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="data_infracao" class="form-label text-dark fw-bold">Data da Infração</label>
                            <input type="date" class="form-control" id="data_infracao" name="data_infracao" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="data_vencimento" class="form-label text-dark fw-bold">Vencimento</label>
                            <input type="date" class="form-control" id="data_vencimento" name="data_vencimento">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="valor" class="form-label text-dark fw-bold">Valor (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control mascara-dinheiro" id="valor" name="valor" placeholder="0,00" required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="multa_status" class="form-label text-dark fw-bold">Status Inicial</label>
                            <select class="form-select" id="multa_status" name="status" required style="display: block !important;">
                                <option value="pendente" selected>Pendente</option>
                                <option value="recurso">Em Recurso</option>
                                <option value="pago">Pago</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fechar
                        </button>
                    
                    <button type="submit" class="btn btn-primary" id="submitButtonMulta">
                        <i class="mdi mdi-check me-1"></i> Cadastrar Multa
                    </button>

                    <button class="btn btn-primary" id="loadingButtonMulta" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Processando...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('submit', function (e) {
    const form = e.target;
    
    if (form.id === 'formMulta') {
        if (!form.checkValidity()) return;

        const submitBtn = form.querySelector('#submitButtonMulta');
        const loadingBtn = form.querySelector('#loadingButtonMulta');

        if (submitBtn && loadingBtn) {
            submitBtn.style.display = 'none';
            loadingBtn.style.display = 'inline-block';
        }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Seleciona todos os campos com a classe de máscara
    const inputsDinheiro = document.querySelectorAll('.mascara-dinheiro');

    inputsDinheiro.forEach(input => {
        input.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
            
            // Impede que o campo fique vazio ou estranho ao apagar
            if (v.length === 0) {
                e.target.value = '';
                return;
            }

            // Transforma em decimal (ex: 150 viraria 1.50)
            v = (v / 100).toFixed(2) + '';
            v = v.replace(".", ",");
            v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
            v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
            
            e.target.value = v;
        });
    });

    // Lógica do Loading Button no Submit
    const formMulta = document.getElementById('formMulta');
    if (formMulta) {
        formMulta.addEventListener('submit', function (e) {
            if (!this.checkValidity()) return;

            const submitBtn = this.querySelector('#submitButtonMulta');
            const loadingBtn = this.querySelector('#loadingButtonMulta');

            if (submitBtn && loadingBtn) {
                submitBtn.style.display = 'none';
                loadingBtn.style.display = 'inline-block';
            }
        });
    }
});
</script>