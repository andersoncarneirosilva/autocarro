<div class="modal fade" id="editCidadeModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInfoModalLabel">Editar cidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFormCidade" method="POST">
                @csrf
                @method('PUT') <!-- Usado para edições -->
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome_outorgado" class="form-label">Cidade: <span style="color: red;">*</span></label>
                            <input class="form-control" id="edit_cidade" name="cidade"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
            </form>
        </div>
    </div>
</div>