
<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInfoModalLabel">Editar Informações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-form-cad" method="POST">
                @csrf
                @method('PUT') <!-- Usado para edições -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_outorgado" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_nome_outorgado" name="nome_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf_outorgado" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="edit_cpf_outorgado" name="cpf_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_outorgado" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="edit_end_outorgado" name="end_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email_outorgado" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email_outorgado" name="email_outorgado" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    // Seleciona todos os campos de entrada no formulário
                    const camposEdit = document.querySelectorAll('#edit_nome_outorgado, #edit_end_outorgado');
            
                    // Adiciona um ouvinte de evento em cada campo
                    camposEdit.forEach(camposEdit => {
                        camposEdit.addEventListener('input', (event) => {
                            // Força o valor para maiúsculas
                            event.target.value = event.target.value.toUpperCase();
                        });
                    });
                });
            </script>
            
        </div>
    </div>
</div>
<script>
    function openEditModalOutorgado(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    const docId = event.target.closest('a').getAttribute('data-id');

    // Faça uma requisição AJAX para buscar os dados
    console.log(docId);
    $.ajax({
        url: `/outorgados/${docId}`,
        method: 'GET',
        success: function(response) {
            // Preencha os campos do modal com os dados do documento
            $('#edit_nome_outorgado').val(response.nome_outorgado);
            $('#edit_cpf_outorgado').val(response.cpf_outorgado);
            $('#edit_end_outorgado').val(response.end_outorgado);
            $('#edit_email_outorgado').val(response.email_outorgado);

            // Atualize a ação do formulário para apontar para a rota de edição com o ID
            $('#edit-form-cad').attr('action', `/outorgados/${docId}`); // Atualizando a action com o ID

            // Exiba o modal
            $('#editInfoModal').modal('show');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar os dados.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

</script>