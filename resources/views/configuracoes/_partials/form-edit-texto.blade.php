<div class="modal fade" id="editTextModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInfoModalLabel">Editar texto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFormPoderes" method="POST">
                @csrf
                @method('PUT') <!-- Usado para edições -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_outorgado" class="form-label">Texto </label>
                        <textarea class="form-control" id="edit_texto_final" name="texto_final" rows="6" cols="150"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
            
        </div>
    </div>
</div>