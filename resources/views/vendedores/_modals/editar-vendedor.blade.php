<div class="modal fade" id="modalEditarVend" tabindex="-1" aria-labelledby="modalEditarVendLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white p-3">
                <h5 class="modal-title text-white fw-bold" id="modalEditarVendLabel">
                    <i class="uil uil-edit me-2"></i>Editar Vendedor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST" id="formEditarVendedor">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="edit_name" class="form-label fw-semibold text-dark">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="edit_name" name="name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_email" class="form-label fw-semibold text-dark">E-mail (Login)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-start-0" id="edit_email" name="email" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_cpf_vendedor" class="form-label fw-semibold text-dark">CPF</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-card-atm text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="edit_cpf_vendedor" name="cpf" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_telefone_vendedor" class="form-label fw-semibold text-dark">Telefone/WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-phone text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="edit_telefone_vendedor" name="telefone">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_status" class="form-label fw-semibold text-dark">Status</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-check-circle text-muted"></i></span>
                                <select class="form-select bg-light border-start-0" id="edit_status" name="status">
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info border-0 mb-0 py-2">
                                <small><i class="uil uil-info-circle me-1"></i> Deixe a senha em branco para manter a atual.</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_password" class="form-label fw-semibold text-dark">Nova Senha (Opcional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="uil uil-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light border-start-0" id="edit_password" name="password" placeholder="Mínimo 8 caracteres">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i> Cancelar
                    </button>
                    
                    {{-- IDs alterados para terminar em 'Edit' --}}
                    <button type="submit" class="btn btn-primary" id="btnSubmitEdit">
                        <i class="mdi mdi-check me-1"></i> Salvar
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
document.addEventListener('DOMContentLoaded', function () {
    // Captura os elementos do Modal de Edição
    const formEdit = document.getElementById('formEditarVendedor');
    const submitBtnEdit = document.getElementById('btnSubmitEdit');
    const loadingBtnEdit = document.getElementById('btnLoadingEdit');

    if (formEdit) {
        formEdit.addEventListener('submit', function (e) {
            // Se o formulário for válido, troca os botões
            if (formEdit.checkValidity()) {
                submitBtnEdit.style.display = 'none';
                loadingBtnEdit.style.setProperty('display', 'inline-block', 'important');
            }
        });
    }
});

function openEditModalVendedor(event) {
    const button = event.currentTarget;
    const id = button.getAttribute('data-id');
    
    // Antes de abrir, resetamos o estado do botão (caso tenha sido fechado no meio de um erro)
    document.getElementById('btnSubmitEdit').style.display = 'inline-block';
    document.getElementById('btnLoadingEdit').style.display = 'none';

    fetch(`/vendedores/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            const form = document.getElementById('formEditarVendedor');
            form.action = `/vendedores/${id}`;
            
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_cpf_vendedor').value = data.cpf;
            document.getElementById('edit_telefone_vendedor').value = data.telefone;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('edit_password').value = '';

            const modal = new bootstrap.Modal(document.getElementById('modalEditarVend'));
            modal.show();
            
            aplicarMascaraCPF('edit_cpf_vendedor');
        })
        .catch(error => {
            Swal.fire('Erro!', 'Não foi possível carregar os dados.', 'error');
        });
}
</script>