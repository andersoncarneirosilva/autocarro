<div class="modal fade" id="modalEditarMulta" tabindex="-1" aria-labelledby="modalEditarMultaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarMultaLabel">
                    <i class="mdi mdi-pencil-outline me-1"></i> Editar Multa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST" id="formEditarMulta">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-dark fw-bold">Veículo</label>
                            <input type="text" class="form-control bg-light" id="edit_veiculo_nome" readonly>
                            <input type="hidden" name="veiculo_id" id="edit_veiculo_id">
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="edit_descricao" class="form-label text-dark fw-bold">Descrição da Infração</label>
                            <input type="text" class="form-control" id="edit_descricao" name="descricao" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit_codigo_infracao" class="form-label text-dark fw-bold">Código</label>
                            <input type="text" class="form-control" id="edit_codigo_infracao" name="codigo_infracao">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit_data_infracao" class="form-label text-dark fw-bold">Data da Infração</label>
                            <input type="date" class="form-control" id="edit_data_infracao" name="data_infracao" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit_data_vencimento" class="form-label text-dark fw-bold">Vencimento</label>
                            <input type="date" class="form-control" id="edit_data_vencimento" name="data_vencimento">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="edit_valor" class="form-label text-dark fw-bold">Valor (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control mascara-dinheiro" id="edit_valor" name="valor" placeholder="0,00" required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit_status" class="form-label text-dark fw-bold">Status Atual</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="pendente">Pendente</option>
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
                    
                    <button type="submit" class="btn btn-primary" id="submitButtonEdit">
                        <i class="mdi mdi-check me-1"></i> Salvar
                    </button>

                    <button class="btn btn-primary" id="loadingButtonEdit" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Salvando...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('submit', function (e) {
    const form = e.target;
    
    // Configurações para cada formulário
    const config = {
        'formMulta': { submit: '#submitButtonMulta', loading: '#loadingButtonMulta' },
        'formEditarMulta': { submit: '#submitButtonEdit', loading: '#loadingButtonEdit' }
    };

    if (config[form.id]) {
        if (!form.checkValidity()) return;

        const ids = config[form.id];
        const submitBtn = form.querySelector(ids.submit);
        const loadingBtn = form.querySelector(ids.loading);

        if (submitBtn && loadingBtn) {
            submitBtn.style.setProperty('display', 'none', 'important');
            loadingBtn.style.setProperty('display', 'inline-block', 'important');
        }
    }
});
</script>


<script>
function editarMulta(multa) {
    // 1. Define a URL de destino do formulário dinamicamente
    const form = document.getElementById('formEditarMulta');
    form.action = `/multas/${multa.id}`;

    // 2. Preenche os campos de texto e IDs
    document.getElementById('edit_veiculo_nome').value = `${multa.veiculo.placa} - ${multa.veiculo.marca} ${multa.veiculo.modelo}`;
    document.getElementById('edit_veiculo_id').value = multa.veiculo_id;
    document.getElementById('edit_descricao').value = multa.descricao;
    document.getElementById('edit_codigo_infracao').value = multa.codigo_infracao || '';
    document.getElementById('edit_data_infracao').value = multa.data_infracao;
    document.getElementById('edit_data_vencimento').value = multa.data_vencimento || '';
    document.getElementById('edit_valor').value = multa.valor;

    // 3. Seleciona o Status no SELECT
    const selectStatus = document.getElementById('edit_status');
    if (selectStatus) {
        selectStatus.value = multa.status;
    }

    // 4. Abre o modal
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEditarMulta'));
    modalEdit.show();
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Função para formatar o valor enquanto digita
    function aplicarMascaraDinheiro(e) {
        let v = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
        v = (v / 100).toFixed(2) + '';
        v = v.replace(".", ",");
        v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
        e.target.value = v;
    }

    // Aplica o evento em todos os campos com a classe
    const inputsDinheiro = document.querySelectorAll('.mascara-dinheiro');
    inputsDinheiro.forEach(input => {
        input.addEventListener('input', aplicarMascaraDinheiro);
    });

});
</script>