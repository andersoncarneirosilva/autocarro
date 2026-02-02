<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editInfoModalLabel">
                    <i class="mdi mdi-account-edit-outline me-1"></i> Editar Informações do Outorgado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="edit-form-cad" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="mdi mdi-information-outline font-24"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading h6 fw-bold">Informações do Representante</h5>
                                <p class="mb-0 small">Certifique-se de que o <strong>RG</strong>, <strong>CPF</strong> e o <strong>E-mail</strong> estejam corretos para a emissão das procurações.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-account me-1"></i> Nome Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control uppercase-field" id="edit_nome_outorgado" name="nome_outorgado" placeholder="NOME COMPLETO" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-card-account-details me-1"></i> RG <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_rg_outorgado" name="rg_outorgado" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-card-account-details me-1"></i> CPF <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_cpf_outorgado" name="cpf_outorgado" placeholder="000.000.000-00" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-email me-1"></i> E-mail <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="edit_email_outorgado" name="email_outorgado" placeholder="email@exemplo.com" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-phone me-1"></i> Telefone <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="edit_telefone_outorgado" class="form-control telefone-mask" name="telefone_outorgado" placeholder="(00) 00000-0000" required>
                        </div>

                        <div class="col-md-6 mb-1">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-map-marker me-1"></i> Endereço Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control uppercase-field" id="edit_end_outorgado" name="end_outorgado" placeholder="RUA, NÚMERO, BAIRRO, CIDADE-UF" required>
                            <div class="form-text">
                                Verifique se o endereço está completo para constar na procuração.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i> Cancelar
                    </button>
                    
                    <button type="submit" class="btn btn-primary" id="btnSubmitEdit">
                        <i class="mdi mdi-check me-1"></i> Salvar Alterações
                    </button>

                    <button class="btn btn-primary" id="btnLoadingEdit" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Salvando...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Mantive suas funções globais de máscara e carregamento
function maskCPF(value) {
    return value
        .replace(/\D/g, '')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})/, '$1-$2')
        .replace(/(-\d{2})\d+?$/, '$1');
}

document.addEventListener('DOMContentLoaded', function () {
    const formEdit = document.getElementById('edit-form-cad');
    const submitBtnEdit = document.getElementById('btnSubmitEdit');
    const loadingBtnEdit = document.getElementById('btnLoadingEdit');

    if (formEdit) {
        formEdit.addEventListener('submit', function (e) {
            if (!formEdit.checkValidity()) return;
            submitBtnEdit.disabled = true;
            submitBtnEdit.style.display = 'none';
            loadingBtnEdit.style.display = 'inline-block';
        });
    }
});

// Listener único para inputs (CPF e Uppercase)
document.addEventListener('input', function (e) {
    if (e.target.id === 'cpf_outorgado' || e.target.id === 'edit_cpf_outorgado') {
        e.target.value = maskCPF(e.target.value);
    }
    if (e.target.classList.contains('uppercase-field')) {
        e.target.value = e.target.value.toUpperCase();
    }
});

// Ajax de carregamento
function openEditModalOutorgado(event) {
    event.preventDefault();
    const button = event.target.closest('[data-id]');
    if (!button) return;
    
    const docId = button.getAttribute('data-id');

    $.ajax({
        url: `/outorgados/${docId}`,
        method: 'GET',
        success: function(response) {
            $('#edit_nome_outorgado').val(response.nome_outorgado);
            $('#edit_rg_outorgado').val(response.rg_outorgado);
            $('#edit_cpf_outorgado').val(response.cpf_outorgado);
            $('#edit_end_outorgado').val(response.end_outorgado);
            $('#edit_email_outorgado').val(response.email_outorgado);
            $('#edit_telefone_outorgado').val(response.telefone_outorgado); // Carrega telefone
            
            $('#edit-form-cad').attr('action', `/outorgados/${docId}`);
            $('#editInfoModal').modal('show');
        },
        error: function() {
            Swal.fire({ title: 'Erro!', text: 'Não foi possível carregar os dados.', icon: 'error' });
        }
    });
}

// Máscara Jquery (aplica em ambos os modais pela classe)
$(document).ready(function() {
    var behavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(behavior.apply({}, arguments), options);
        }
    };
    $('.telefone-mask').mask(behavior, options);
});
</script>